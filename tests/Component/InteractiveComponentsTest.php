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

use Silarhi\TablerUxComponents\Tests\ComponentTestCase;

final class InteractiveComponentsTest extends ComponentTestCase
{
    public function testTabsBar(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Tabs>
                <twig:Tabler:Tabs:Item target="home" active>Home</twig:Tabler:Tabs:Item>
                <twig:Tabler:Tabs:Item target="profile">Profile</twig:Tabler:Tabs:Item>
            </twig:Tabler:Tabs>
            TWIG);

        self::assertHtmlSame(
            '<ul class="nav nav-tabs" data-bs-toggle="tabs" role="tablist">'
            . '<li class="nav-item" role="presentation"><a href="#home" class="nav-link active" data-bs-toggle="tab">Home</a></li>'
            . '<li class="nav-item" role="presentation"><a href="#profile" class="nav-link" data-bs-toggle="tab">Profile</a></li>'
            . '</ul>',
            $html,
        );
    }

    public function testTabsContentAndPane(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Tabs:Content>
                <twig:Tabler:Tabs:Pane id="home" active>Home content</twig:Tabler:Tabs:Pane>
                <twig:Tabler:Tabs:Pane id="profile">Profile content</twig:Tabler:Tabs:Pane>
            </twig:Tabler:Tabs:Content>
            TWIG);

        self::assertHtmlSame(
            '<div class="tab-content">'
            . '<div class="tab-pane active show" id="home" role="tabpanel">Home content</div>'
            . '<div class="tab-pane" id="profile" role="tabpanel">Profile content</div>'
            . '</div>',
            $html,
        );
    }

    public function testTabsAllInOneItems(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:Tabs id="profile" pills class="mb-3" items="{{ items }}" />',
            ['items' => [
                ['label' => 'Overview', 'text' => 'Jane <Cooper>'],
                ['label' => 'Activity', 'icon' => 'activity', 'id' => 'activity', 'text' => 'Signed in.'],
                ['label' => 'Billing', 'disabled' => true],
            ]],
        );

        // The first tab is active, pane ids default to "<id>-<n>"; attributes go to the tab bar
        self::assertHtmlSame(
            '<ul class="nav nav-pills mb-3" id="profile" data-bs-toggle="tabs" role="tablist">'
            . '<li class="nav-item" role="presentation"><a href="#profile-1" class="nav-link active" data-bs-toggle="tab">Overview</a></li>'
            . '<li class="nav-item" role="presentation"><a href="#activity" class="nav-link" data-bs-toggle="tab"><span class="nav-link-icon"><i class="ti ti-activity"></i></span>Activity</a></li>'
            . '<li class="nav-item" role="presentation"><a href="#profile-3" class="nav-link disabled" data-bs-toggle="tab" aria-disabled="true">Billing</a></li>'
            . '</ul>'
            . '<div class="tab-content">'
            . '<div class="tab-pane active show" id="profile-1" role="tabpanel">Jane &lt;Cooper&gt;</div>'
            . '<div class="tab-pane" id="activity" role="tabpanel">Signed in.</div>'
            . '<div class="tab-pane" id="profile-3" role="tabpanel"></div>'
            . '</div>',
            $html,
        );
    }

    public function testTabsItemsExplicitActiveAndRandomId(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Tabs items="{{ [{label: \'A\', text: \'a\'}, {label: \'B\', text: \'b\', active: true}] }}" />');

        // Without an id, the bar gets none and the panes a random prefix
        self::assertSame(1, preg_match('/href="#(tabs-\d{6})-1" class="nav-link"/', $html, $match));
        $prefix = $match[1] ?? '';
        self::assertStringContainsString('<a href="#' . $prefix . '-2" class="nav-link active"', $html);
        self::assertStringContainsString('<div class="tab-pane" id="' . $prefix . '-1"', $html);
        self::assertStringContainsString('<div class="tab-pane active show" id="' . $prefix . '-2"', $html);
        self::assertStringStartsWith('<ul class="nav nav-tabs" data-bs-toggle="tabs"', $html);
    }

    public function testTabsPanesBlockOverride(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Tabs id="t" items="{{ [{label: 'A'}] }}">
                <twig:block name="panes"><twig:Tabler:Tabs:Content class="pt-3"><twig:Tabler:Tabs:Pane id="t-1" active>Own <strong>pane</strong></twig:Tabler:Tabs:Pane></twig:Tabler:Tabs:Content></twig:block>
            </twig:Tabler:Tabs>
            TWIG);

        self::assertHtmlSame(
            '<ul class="nav nav-tabs" id="t" data-bs-toggle="tabs" role="tablist">'
            . '<li class="nav-item" role="presentation"><a href="#t-1" class="nav-link active" data-bs-toggle="tab">A</a></li>'
            . '</ul>'
            . '<div class="tab-content pt-3"><div class="tab-pane active show" id="t-1" role="tabpanel">Own <strong>pane</strong></div></div>',
            $html,
        );
    }

    public function testTabsItemIconAndDisabled(): void
    {
        self::assertHtmlSame(
            '<li class="nav-item" role="presentation"><a href="#home" class="nav-link disabled" data-bs-toggle="tab" aria-disabled="true"><span class="nav-link-icon"><i class="ti ti-home"></i></span>Home</a></li>',
            $this->renderComponent('<twig:Tabler:Tabs:Item target="home" icon="home" disabled>Home</twig:Tabler:Tabs:Item>'),
        );
    }

    public function testToast(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Toast show>
                <twig:Tabler:Toast:Header><strong class="me-auto">Notice</strong><twig:Tabler:Toast:Close /></twig:Tabler:Toast:Header>
                <twig:Tabler:Toast:Body>Saved.</twig:Tabler:Toast:Body>
            </twig:Tabler:Toast>
            TWIG);

        self::assertHtmlSame(
            '<div class="toast show" role="status" aria-live="polite" aria-atomic="true">'
            . '<div class="toast-header"><strong class="me-auto">Notice</strong>'
            . '<button type="button" class="ms-2 btn-close" data-bs-dismiss="toast" aria-label="Close"></button></div>'
            . '<div class="toast-body">Saved.</div>'
            . '</div>',
            $html,
        );
    }

    public function testOffcanvasAllInOne(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Offcanvas id="menu" placement="end" title="Filters" text="Body" />');

        self::assertHtmlSame(
            '<div class="offcanvas offcanvas-end" tabindex="-1" id="menu">'
            . '<div class="offcanvas-header">'
            . '<h5 class="offcanvas-title">Filters</h5>'
            . '<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>'
            . '</div>'
            . '<div class="offcanvas-body">Body</div>'
            . '</div>',
            $html,
        );
    }

    public function testSegmentedControl(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:SegmentedControl fullWidth>
                <twig:Tabler:SegmentedControl:Item active>Day</twig:Tabler:SegmentedControl:Item>
                <twig:Tabler:SegmentedControl:Item>Week</twig:Tabler:SegmentedControl:Item>
            </twig:Tabler:SegmentedControl>
            TWIG);

        self::assertHtmlSame(
            '<nav class="nav nav-segmented w-100" role="tablist">'
            . '<button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" aria-selected="true">Day</button>'
            . '<button type="button" class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1">Week</button>'
            . '</nav>',
            $html,
        );
    }

    public function testDatagrid(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Datagrid>
                <twig:Tabler:Datagrid:Item title="Registrar" text="Third Party" />
                <twig:Tabler:Datagrid:Item>
                    <twig:Tabler:Datagrid:Item:Title>Port</twig:Tabler:Datagrid:Item:Title>
                    <twig:Tabler:Datagrid:Item:Content>3306</twig:Tabler:Datagrid:Item:Content>
                </twig:Tabler:Datagrid:Item>
            </twig:Tabler:Datagrid>
            TWIG);

        self::assertHtmlSame(
            '<div class="datagrid">'
            . '<div class="datagrid-item"><div class="datagrid-title">Registrar</div><div class="datagrid-content">Third Party</div></div>'
            . '<div class="datagrid-item"><div class="datagrid-title">Port</div><div class="datagrid-content">3306</div></div>'
            . '</div>',
            $html,
        );
    }

    public function testOffcanvasNarrowFloatingWithFooter(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Offcanvas id="filters" narrow floating text="Body" footer="Actions" />');

        self::assertHtmlSame(
            '<div class="offcanvas offcanvas-start offcanvas-narrow offcanvas-floating" tabindex="-1" id="filters">'
            . '<div class="offcanvas-body">Body</div>'
            . '<div class="offcanvas-footer">Actions</div>'
            . '</div>',
            $html,
        );
    }

    public function testToastRootIsNotAToggleTrigger(): void
    {
        // tabler.js binds [data-bs-toggle="toast"] as a *trigger* button that
        // shows its data-bs-target; on the toast itself it has no target.
        $html = $this->renderComponent('<twig:Tabler:Toast autohide="{{ false }}"><twig:Tabler:Toast:Body>Saved.</twig:Tabler:Toast:Body></twig:Tabler:Toast>');

        self::assertHtmlSame(
            '<div class="toast" role="status" aria-live="polite" aria-atomic="true" data-bs-autohide="false"><div class="toast-body">Saved.</div></div>',
            $html,
        );
    }

    public function testSegmentedControlItemDoesNotSubmitForms(): void
    {
        self::assertHtmlSame(
            '<form><button type="button" class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1">Day</button></form>',
            $this->renderComponent('<form><twig:Tabler:SegmentedControl:Item>Day</twig:Tabler:SegmentedControl:Item></form>'),
        );
        self::assertHtmlSame(
            '<button type="submit" class="nav-link active" role="tab" data-bs-toggle="tab" aria-selected="true" name="period" value="day">Day</button>',
            $this->renderComponent('<twig:Tabler:SegmentedControl:Item active type="submit" name="period" value="day">Day</twig:Tabler:SegmentedControl:Item>'),
        );
    }
}
