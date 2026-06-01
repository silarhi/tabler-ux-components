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

    public function testToast(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Toast show>
                <twig:Tabler:Toast:Header><strong class="me-auto">Notice</strong><twig:Tabler:Toast:Close /></twig:Tabler:Toast:Header>
                <twig:Tabler:Toast:Body>Saved.</twig:Tabler:Toast:Body>
            </twig:Tabler:Toast>
            TWIG);

        self::assertHtmlSame(
            '<div class="toast show" role="alert" aria-live="polite" aria-atomic="true" data-bs-toggle="toast">'
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
            . '<button class="nav-link active" role="tab" data-bs-toggle="tab" aria-selected="true">Day</button>'
            . '<button class="nav-link" role="tab" data-bs-toggle="tab" aria-selected="false" tabindex="-1">Week</button>'
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
}
