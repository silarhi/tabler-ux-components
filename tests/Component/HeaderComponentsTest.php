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

/**
 * The header sub-components (Card:Header, Modal:Header, Offcanvas:Header, Toast:Header) take their parts as props too.
 */
final class HeaderComponentsTest extends ComponentTestCase
{
    public function testCardHeaderTitle(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Card:Header title="Invoices" class="py-2" />');

        self::assertHtmlSame('<div class="card-header py-2"><h3 class="card-title">Invoices</h3></div>', $html);
    }

    public function testCardHeaderSubtitleWrapsTitleAndSubtitle(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Card:Header title="Invoice #42" subtitle="Acme Corp" />');

        self::assertHtmlSame(
            '<div class="card-header"><div>'
            . '<h3 class="card-title">Invoice #42</h3><div class="card-subtitle">Acme Corp</div>'
            . '</div></div>',
            $html,
        );
    }

    public function testCardHeaderActionsBlockKeepsTitle(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Card:Header title="Danger zone">
                <twig:block name="actions"><twig:Tabler:Card:Actions>Delete</twig:Tabler:Card:Actions></twig:block>
            </twig:Tabler:Card:Header>
            TWIG);

        self::assertHtmlSame(
            '<div class="card-header"><h3 class="card-title">Danger zone</h3><div class="card-actions">Delete</div></div>',
            $html,
        );
    }

    public function testCardHeaderEscapesProps(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Card:Header title="{{ title }}" subtitle="{{ title }}" />', ['title' => '<b>x</b>']);

        self::assertStringNotContainsString('<b>', $html);
        self::assertStringContainsString('&lt;b&gt;x&lt;/b&gt;', $html);
    }

    public function testCardForwardsTitleToHeader(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Card>
                <twig:Tabler:Card:Header title="Stats" subtitle="Last 30 days" />
            </twig:Tabler:Card>
            TWIG);

        self::assertHtmlSame(
            '<div class="card"><div class="card-header"><div>'
            . '<h3 class="card-title">Stats</h3><div class="card-subtitle">Last 30 days</div>'
            . '</div></div></div>',
            $html,
        );
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function dismissibleHeaders(): iterable
    {
        yield 'modal' => ['Modal', 'modal'];
        yield 'offcanvas' => ['Offcanvas', 'offcanvas'];
    }

    #[DataProvider('dismissibleHeaders')]
    public function testHeaderTitleAndClose(string $component, string $prefix): void
    {
        $html = $this->renderComponent(sprintf('<twig:Tabler:%s:Header title="Filters" />', $component));

        self::assertHtmlSame(
            sprintf('<div class="%1$s-header"><h5 class="%1$s-title">Filters</h5>', $prefix)
            . sprintf('<button type="button" class="btn-close" data-bs-dismiss="%s" aria-label="Close"></button></div>', $prefix),
            $html,
        );
    }

    #[DataProvider('dismissibleHeaders')]
    public function testHeaderNotDismissible(string $component, string $prefix): void
    {
        $html = $this->renderComponent(sprintf('<twig:Tabler:%s:Header title="Filters" dismissible="{{ false }}" />', $component));

        self::assertHtmlSame(sprintf('<div class="%1$s-header"><h5 class="%1$s-title">Filters</h5></div>', $prefix), $html);
    }

    #[DataProvider('dismissibleHeaders')]
    public function testHeaderTitleBlockKeepsClose(string $component, string $prefix): void
    {
        $html = $this->renderComponent(sprintf(<<<'TWIG'
            <twig:Tabler:%1$s:Header title="Ignored">
                <twig:block name="title"><twig:Tabler:%1$s:Title>Custom <em>title</em></twig:Tabler:%1$s:Title></twig:block>
            </twig:Tabler:%1$s:Header>
            TWIG, $component));

        self::assertHtmlSame(
            sprintf('<div class="%1$s-header"><h5 class="%1$s-title">Custom <em>title</em></h5>', $prefix)
            . sprintf('<button type="button" class="btn-close" data-bs-dismiss="%s" aria-label="Close"></button></div>', $prefix),
            $html,
        );
    }

    #[DataProvider('dismissibleHeaders')]
    public function testHeaderComposedChildrenReplaceContent(string $component, string $prefix): void
    {
        $html = $this->renderComponent(sprintf(
            '<twig:Tabler:%1$s:Header><twig:Tabler:%1$s:Title>Only a title</twig:Tabler:%1$s:Title></twig:Tabler:%1$s:Header>',
            $component,
        ));

        self::assertHtmlSame(sprintf('<div class="%1$s-header"><h5 class="%1$s-title">Only a title</h5></div>', $prefix), $html);
    }

    public function testModalForwardsDismissibleToHeader(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Modal title="Terms" dismissible="{{ false }}" />');

        self::assertStringContainsString('modal-title">Terms</h5>', $html);
        self::assertStringNotContainsString('btn-close', $html);
    }

    public function testToastHeaderAllInOne(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Toast:Header title="Backup" time="just now" />');

        self::assertHtmlSame(
            '<div class="toast-header"><strong class="me-auto">Backup</strong><small class="text-secondary">just now</small>'
            . '<button type="button" class="ms-2 btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div>',
            $html,
        );
    }

    public function testToastHeaderNotDismissibleWithoutTime(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Toast:Header title="Notice" dismissible="{{ false }}" />');

        self::assertHtmlSame('<div class="toast-header"><strong class="me-auto">Notice</strong></div>', $html);
    }

    public function testToastHeaderTitleBlockKeepsTimeAndClose(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Toast:Header title="Jane Doe" time="2 min ago">
                <twig:block name="title"><span class="avatar avatar-xs me-2"></span><twig:Tabler:Toast:Title>Jane Doe</twig:Tabler:Toast:Title></twig:block>
            </twig:Tabler:Toast:Header>
            TWIG);

        self::assertHtmlSame(
            '<div class="toast-header"><span class="avatar avatar-xs me-2"></span><strong class="me-auto">Jane Doe</strong>'
            . '<small class="text-secondary">2 min ago</small>'
            . '<button type="button" class="ms-2 btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div>',
            $html,
        );
    }

    public function testToastTitleAndTimeMergeClasses(): void
    {
        self::assertHtmlSame('<strong class="me-auto fw-bold">Notice</strong>', $this->renderComponent('<twig:Tabler:Toast:Title class="fw-bold">Notice</twig:Tabler:Toast:Title>'));
        self::assertHtmlSame('<small class="text-secondary ms-1">now</small>', $this->renderComponent('<twig:Tabler:Toast:Time class="ms-1">now</twig:Tabler:Toast:Time>'));
    }

    public function testCardSubtitleProp(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Card title="Invoice" subtitle="Acme Corp" text="$4,320.00" />');

        self::assertHtmlSame(
            '<div class="card"><div class="card-header"><div>'
            . '<h3 class="card-title">Invoice</h3><div class="card-subtitle">Acme Corp</div>'
            . '</div></div><div class="card-body">$4,320.00</div></div>',
            $html,
        );
    }

    public function testCardSubtitleWithoutTitle(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Card subtitle="Last 30 days" />');

        self::assertHtmlSame('<div class="card"><div class="card-header"><div><div class="card-subtitle">Last 30 days</div></div></div></div>', $html);
    }

    public function testToastAllInOne(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Toast show title="Backup" time="just now" text="The nightly backup finished." />');

        self::assertHtmlSame(
            '<div class="toast show" role="status" aria-live="polite" aria-atomic="true">'
            . '<div class="toast-header"><strong class="me-auto">Backup</strong><small class="text-secondary">just now</small>'
            . '<button type="button" class="ms-2 btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div>'
            . '<div class="toast-body">The nightly backup finished.</div>'
            . '</div>',
            $html,
        );
    }

    public function testToastNotDismissibleAndBodyOnly(): void
    {
        $notDismissible = $this->renderComponent('<twig:Tabler:Toast title="Notice" dismissible="{{ false }}" />');
        self::assertStringNotContainsString('btn-close', $notDismissible);

        $bodyOnly = $this->renderComponent('<twig:Tabler:Toast text="Saved." />');
        self::assertHtmlSame('<div class="toast" role="status" aria-live="polite" aria-atomic="true"><div class="toast-body">Saved.</div></div>', $bodyOnly);
    }

    public function testToastBodyBlockKeepsHeader(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Toast title="Deploy" text="Ignored">
                <twig:block name="body"><twig:Tabler:Toast:Body>Live on <a href="#">production</a>.</twig:Tabler:Toast:Body></twig:block>
            </twig:Tabler:Toast>
            TWIG);

        self::assertStringContainsString('me-auto">Deploy</strong>', $html);
        self::assertStringContainsString('Live on <a href="#">production</a>.', $html);
        self::assertStringNotContainsString('Ignored', $html);
    }
}
