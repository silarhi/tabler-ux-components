<?php

declare(strict_types=1);

/*
 * This file is part of the Tabler UX Components Bundle package.
 *
 * (c) SILARHI <dev@silarhi.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Silarhi\TablerUxComponents\Tests\Standalone;

use function dirname;

use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use ReflectionNamedType;
use ReflectionParameter;
use Silarhi\TablerUxComponents\Tests\AssertsHtmlTrait;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Contracts\Service\ServiceLocatorTrait;
use Symfony\UX\TwigComponent\ComponentAttributes;
use Symfony\UX\TwigComponent\ComponentFactory;
use Symfony\UX\TwigComponent\ComponentProperties;
use Symfony\UX\TwigComponent\ComponentRenderer;
use Symfony\UX\TwigComponent\ComponentStack;
use Symfony\UX\TwigComponent\ComponentTemplateFinder;
use Symfony\UX\TwigComponent\Twig\ComponentExtension;
use Symfony\UX\TwigComponent\Twig\ComponentLexer;
use Symfony\UX\TwigComponent\Twig\ComponentRuntime;
use Twig\Environment;
use Twig\Extra\Html\HtmlExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Runtime\EscaperRuntime;
use Twig\RuntimeLoader\FactoryRuntimeLoader;

/**
 * Renders the components in a plain Twig environment, wired as the README's "Without the bundle" section says: no
 * kernel, no symfony/dependency-injection. ux-twig-component 3.2+ only: before, its runtime needs a Symfony
 * ServiceLocator.
 */
final class PlainTwigTest extends TestCase
{
    use AssertsHtmlTrait;

    private Environment $twig;

    protected function setUp(): void
    {
        $container = (new ReflectionParameter([ComponentFactory::class, '__construct'], 1))->getType();
        if (!$container instanceof ReflectionNamedType || ContainerInterface::class !== $container->getName()) {
            self::markTestSkipped('symfony/ux-twig-component 3.2+ runs with any PSR-11 container.');
        }

        $loader = new FilesystemLoader();
        $loader->addPath(dirname(__DIR__, 2) . '/templates');

        $this->twig = new Environment($loader, ['strict_variables' => true]);
        $this->twig->setLexer(new ComponentLexer($this->twig));
        $this->twig->addExtension(new ComponentExtension());
        $this->twig->addExtension(new HtmlExtension());
        $this->twig->getRuntime(EscaperRuntime::class)->addSafeClass(ComponentAttributes::class, ['html']);

        $services = new class([]) implements ContainerInterface {
            use ServiceLocatorTrait;
        };
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $dispatcher = new EventDispatcher();
        $stack = new ComponentStack();
        $factory = new ComponentFactory(new ComponentTemplateFinder($loader, 'components'), $services, $propertyAccessor, $dispatcher, [], [], $this->twig);
        $renderer = new ComponentRenderer($this->twig, $dispatcher, $factory, new ComponentProperties($propertyAccessor), $stack);

        $this->twig->addRuntimeLoader(new FactoryRuntimeLoader([
            ComponentRuntime::class => static fn (): ComponentRuntime => new ComponentRuntime($renderer, $services, $stack),
        ]));
    }

    public function testRendersTheVariantsOfAComponent(): void
    {
        self::assertHtmlSame(<<<HTML
            <div class="alert alert-success alert-important text-white shadow-sm" role="alert">
                <div>
                    <h4 class="alert-heading">Saved!</h4>
                    <div class="alert-description">Your changes are live.</div>
                </div>
            </div>
            HTML, $this->render('<twig:Tabler:Alert variant="success" important title="Saved!" description="Your changes are live." class="shadow-sm" />'));
    }

    public function testRendersSubComponents(): void
    {
        self::assertHtmlSame(<<<HTML
            <div class="alert alert-success" role="alert">
                <div class="alert-icon"><i class="ti ti-check"></i></div>
                <h4 class="alert-heading">Saved!</h4>
                <div class="alert-description">Your changes are <strong>live</strong>.</div>
            </div>
            HTML, $this->render(<<<TWIG
            <twig:Tabler:Alert variant="success">
                <twig:Tabler:Alert:Icon><i class="ti ti-check"></i></twig:Tabler:Alert:Icon>
                <twig:Tabler:Alert:Title>Saved!</twig:Tabler:Alert:Title>
                <twig:Tabler:Alert:Description>Your changes are <strong>live</strong>.</twig:Tabler:Alert:Description>
            </twig:Tabler:Alert>
            TWIG));
    }

    public function testRendersComponentsRenderingOthers(): void
    {
        self::assertHtmlSame(<<<HTML
            <div class="card">
                <div class="card-header"><h3 class="card-title">Stats</h3></div>
                <div class="card-body">42 users</div>
                <div class="card-footer">Updated today</div>
            </div>
            HTML, $this->render('<twig:Tabler:Card title="Stats" text="42 users" footer="Updated today" />'));

        self::assertHtmlSame(
            '<button type="button" class="btn btn-lg btn-pill btn-success">Go</button>',
            $this->render('<twig:Tabler:Button variant="success" size="lg" pill>Go</twig:Tabler:Button>'),
        );
    }

    public function testEscapesProps(): void
    {
        self::assertStringNotContainsString('<script>', $this->render("{% component 'Tabler:Alert' with {title: title} %}{% endcomponent %}", ['title' => '<script>alert(1)</script>']));
    }

    /**
     * @param array<string, mixed> $context
     */
    private function render(string $template, array $context = []): string
    {
        return $this->twig->createTemplate($template)->render($context);
    }
}
