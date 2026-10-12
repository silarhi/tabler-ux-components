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

namespace Silarhi\TablerUxComponents\Tests\Component;

use PHPUnit\Framework\Attributes\DataProvider;
use Silarhi\TablerUxComponents\Tests\ComponentTestCase;

use function sprintf;

final class AlertTest extends ComponentTestCase
{
    public function testRendersBareAlertWithDefaults(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Alert />');

        self::assertHtmlSame(
            '<div class="alert alert-info" role="alert"></div>',
            $html,
        );
    }

    public function testRendersAllInOneProps(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Alert variant="success" title="Saved!" description="Your changes are live." />');

        self::assertHtmlSame(<<<HTML
            <div class="alert alert-success" role="alert">
                <div>
                    <h4 class="alert-heading">Saved!</h4>
                    <div class="alert-description">Your changes are live.</div>
                </div>
            </div>
            HTML, $html);
    }

    public function testTitleOnlyStillWrapsInDiv(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Alert variant="warning" title="Heads up" />');

        self::assertHtmlSame(<<<HTML
            <div class="alert alert-warning" role="alert">
                <div>
                    <h4 class="alert-heading">Heads up</h4>
                </div>
            </div>
            HTML, $html);
    }

    public function testIconPropRendersAlertIconWrapper(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Alert variant="danger" icon="x" title="Error" />');

        self::assertHtmlSame(<<<HTML
            <div class="alert alert-danger" role="alert">
                <div class="alert-icon"><i class="ti ti-x"></i></div>
                <div>
                    <h4 class="alert-heading">Error</h4>
                </div>
            </div>
            HTML, $html);
    }

    public function testDismissibleAddsClassAndCloseButton(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Alert variant="info" title="Hi" dismissible />');

        self::assertHtmlSame(<<<HTML
            <div class="alert alert-info alert-dismissible" role="alert">
                <div>
                    <h4 class="alert-heading">Hi</h4>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            HTML, $html);
    }

    public function testImportantAppliesCompoundVariant(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Alert variant="success" important title="Done" />');

        self::assertHtmlSame(<<<HTML
            <div class="alert alert-success alert-important text-white" role="alert">
                <div>
                    <h4 class="alert-heading">Done</h4>
                </div>
            </div>
            HTML, $html);
    }

    public function testForwardsStyleAttributeToRoot(): void
    {
        // `style` is no longer a prop, so a CSS `style` attribute is forwarded.
        $html = $this->renderComponent('<twig:Tabler:Alert variant="info" style="margin: 0" />');

        self::assertHtmlSame('<div class="alert alert-info" role="alert" style="margin: 0"></div>', $html);
    }

    public function testComposedModeReplacesContent(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Alert variant="success">
                <twig:Tabler:Alert:Icon><i class="ti ti-check"></i></twig:Tabler:Alert:Icon>
                <twig:Tabler:Alert:Title>Saved!</twig:Tabler:Alert:Title>
                <twig:Tabler:Alert:Description>Your changes are <strong>live</strong>.</twig:Tabler:Alert:Description>
            </twig:Tabler:Alert>
            TWIG);

        self::assertHtmlSame(<<<HTML
            <div class="alert alert-success" role="alert">
                <div class="alert-icon"><i class="ti ti-check"></i></div>
                <h4 class="alert-heading">Saved!</h4>
                <div class="alert-description">Your changes are <strong>live</strong>.</div>
            </div>
            HTML, $html);
    }

    public function testOverrideTitleBlockKeepsOtherProps(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Alert variant="info" title="Default" description="A description">
                <twig:block name="title">
                    <twig:Tabler:Alert:Title class="display-6">Custom!</twig:Tabler:Alert:Title>
                </twig:block>
            </twig:Tabler:Alert>
            TWIG);

        self::assertHtmlSame(<<<HTML
            <div class="alert alert-info" role="alert">
                <div>
                    <h4 class="alert-heading display-6">Custom!</h4>
                    <div class="alert-description">A description</div>
                </div>
            </div>
            HTML, $html);
    }

    public function testConsumerClassMergesWithVariantClasses(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Alert variant="success" title="Hi" class="shadow-sm mt-3" />');

        self::assertHtmlSame(<<<HTML
            <div class="alert alert-success shadow-sm mt-3" role="alert">
                <div>
                    <h4 class="alert-heading">Hi</h4>
                </div>
            </div>
            HTML, $html);
    }

    public function testWrapperDivOmittedWhenNoTitleOrDescription(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Alert variant="info" icon="info-circle" />');

        self::assertHtmlSame(<<<HTML
            <div class="alert alert-info" role="alert">
                <div class="alert-icon"><i class="ti ti-info-circle"></i></div>
            </div>
            HTML, $html);
    }

    public function testIconPropIsEscaped(): void
    {
        $html = $this->renderComponent(
            <<<'TWIG'
            {% component 'Tabler:Alert' with {icon: icon} %}{% endcomponent %}
            TWIG,
            ['icon' => '"><script>alert(1)</script>'],
        );

        self::assertStringNotContainsString('<script>', $html);
    }

    public function testIconBlockTakesCustomMarkup(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Alert variant="info">
                <twig:block name="icon"><twig:Tabler:Alert:Icon><svg></svg></twig:Tabler:Alert:Icon></twig:block>
            </twig:Tabler:Alert>
            TWIG);

        self::assertHtmlSame(<<<HTML
            <div class="alert alert-info" role="alert">
                <div class="alert-icon"><svg></svg></div>
            </div>
            HTML, $html);
    }

    /**
     * @return iterable<string, array{0: string, 1: string}>
     */
    public static function variantProvider(): iterable
    {
        yield 'primary' => ['primary', 'alert-primary'];
        yield 'secondary' => ['secondary', 'alert-secondary'];
        yield 'success' => ['success', 'alert-success'];
        yield 'danger' => ['danger', 'alert-danger'];
        yield 'warning' => ['warning', 'alert-warning'];
        yield 'info' => ['info', 'alert-info'];
    }

    #[DataProvider('variantProvider')]
    public function testEveryVariantProducesItsClass(string $variant, string $expectedClass): void
    {
        $html = $this->renderComponent(sprintf('<twig:Tabler:Alert variant="%s" />', $variant));

        self::assertHtmlSame(
            sprintf('<div class="alert %s" role="alert"></div>', $expectedClass),
            $html,
        );
    }

    public function testMinorAddsQuietStyle(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Alert variant="info" minor />');

        self::assertHtmlSame('<div class="alert alert-info alert-minor" role="alert"></div>', $html);
    }

    public function testLinkActionAndListParts(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Alert variant="danger">
                <twig:Tabler:Alert:Title>An error occurred</twig:Tabler:Alert:Title>
                <twig:Tabler:Alert:Description>Read the <twig:Tabler:Alert:Link href="/docs">docs</twig:Tabler:Alert:Link>.</twig:Tabler:Alert:Description>
                <twig:Tabler:Alert:List><li>Missing email.</li></twig:Tabler:Alert:List>
                <twig:Tabler:Alert:Action href="/retry">Try again</twig:Tabler:Alert:Action>
            </twig:Tabler:Alert>
            TWIG);

        self::assertHtmlSame(<<<HTML
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">An error occurred</h4>
                <div class="alert-description">Read the <a href="/docs" class="alert-link">docs</a>.</div>
                <ul class="alert-list"><li>Missing email.</li></ul>
                <a href="/retry" class="alert-action">Try again</a>
            </div>
            HTML, $html);
    }
}
