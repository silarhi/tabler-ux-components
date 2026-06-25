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
                    <h4 class="alert-title">Saved!</h4>
                    <div class="text-secondary">Your changes are live.</div>
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
                    <h4 class="alert-title">Heads up</h4>
                </div>
            </div>
            HTML, $html);
    }

    public function testIconPropRendersAlertIconWrapper(): void
    {
        // Non-HTML syntax + context variable lets us pass HTML through the `icon` prop
        // without fighting the HTML-attribute lexer (it would choke on `<`).
        $html = $this->renderComponent(
            <<<'TWIG'
            {% component 'Tabler:Alert' with {variant: 'danger', icon: icon, title: 'Error'} %}{% endcomponent %}
            TWIG,
            ['icon' => '<i class="ti ti-x"></i>'],
        );

        self::assertHtmlSame(<<<HTML
            <div class="alert alert-danger" role="alert">
                <div class="alert-icon"><i class="ti ti-x"></i></div>
                <div>
                    <h4 class="alert-title">Error</h4>
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
                    <h4 class="alert-title">Hi</h4>
                </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            HTML, $html);
    }

    public function testImportantStyleAppliesCompoundVariant(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Alert variant="success" style="important" title="Done" />');

        self::assertHtmlSame(<<<HTML
            <div class="alert alert-success alert-important text-white" role="alert">
                <div>
                    <h4 class="alert-title">Done</h4>
                </div>
            </div>
            HTML, $html);
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
                <h4 class="alert-title">Saved!</h4>
                <div class="text-secondary">Your changes are <strong>live</strong>.</div>
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
                    <h4 class="alert-title display-6">Custom!</h4>
                    <div class="text-secondary">A description</div>
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
                    <h4 class="alert-title">Hi</h4>
                </div>
            </div>
            HTML, $html);
    }

    public function testWrapperDivOmittedWhenNoTitleOrDescription(): void
    {
        $html = $this->renderComponent(
            <<<'TWIG'
            {% component 'Tabler:Alert' with {variant: 'info', icon: icon} %}{% endcomponent %}
            TWIG,
            ['icon' => '<svg></svg>'],
        );

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
}
