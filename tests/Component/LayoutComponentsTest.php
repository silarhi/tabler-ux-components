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

final class LayoutComponentsTest extends ComponentTestCase
{
    public function testProse(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Prose><h1>Title</h1></twig:Tabler:Prose>');

        self::assertHtmlSame('<div class="prose"><h1>Title</h1></div>', $html);
    }

    public function testPageHeaderAllInOne(): void
    {
        $html = $this->renderComponent('<twig:Tabler:PageHeader pretitle="Overview" title="Dashboard" />');

        self::assertHtmlSame(
            '<div class="page-header d-print-none">'
            . '<div class="row align-items-center">'
            . '<div class="col">'
            . '<div class="page-pretitle">Overview</div>'
            . '<h2 class="page-title">Dashboard</h2>'
            . '</div>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testPageHeaderComposedActions(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:PageHeader title="Dashboard">
                <twig:block name="actions">
                    <twig:Tabler:PageHeader:Actions>
                        <twig:Tabler:Button variant="primary">New</twig:Tabler:Button>
                    </twig:Tabler:PageHeader:Actions>
                </twig:block>
            </twig:Tabler:PageHeader>
            TWIG);

        self::assertHtmlSame(
            '<div class="page-header d-print-none">'
            . '<div class="row align-items-center">'
            . '<div class="col"><h2 class="page-title">Dashboard</h2></div>'
            . '<div class="col-auto ms-auto"><div class="btn-list">'
            . '<button type="button" class="btn btn-primary">New</button>'
            . '</div></div>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testNavbar(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Navbar>
                <twig:Tabler:Navbar:Toggler target="navbar-menu" />
                <twig:Tabler:Navbar:Brand href="/">My App</twig:Tabler:Navbar:Brand>
                <twig:Tabler:Navbar:Nav id="navbar-menu" collapse>
                    <twig:Tabler:Navbar:Item href="/" active>Home</twig:Tabler:Navbar:Item>
                </twig:Tabler:Navbar:Nav>
            </twig:Tabler:Navbar>
            TWIG);

        self::assertHtmlSame(
            '<header class="navbar d-print-none navbar-expand-md">'
            . '<div class="container-xl">'
            . '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">'
            . '<span class="navbar-toggler-icon"></span>'
            . '</button>'
            . '<a href="/" class="navbar-brand">My App</a>'
            . '<div class="collapse navbar-collapse" id="navbar-menu">'
            . '<ul class="navbar-nav">'
            . '<li class="nav-item active"><a class="nav-link" href="/" aria-current="page"><span class="nav-link-title">Home</span></a></li>'
            . '</ul>'
            . '</div>'
            . '</div>'
            . '</header>',
            $html,
        );
    }

    public function testNavbarItemWithIcon(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Navbar:Item href="/profile" icon="user">Profile</twig:Tabler:Navbar:Item>');

        self::assertHtmlSame(
            '<li class="nav-item">'
            . '<a class="nav-link" href="/profile">'
            . '<span class="nav-link-icon"><i class="ti ti-user"></i></span>'
            . '<span class="nav-link-title">Profile</span>'
            . '</a>'
            . '</li>',
            $html,
        );
    }

    public function testVerticalFoldedSidebar(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Navbar vertical expand="lg" folded="hover" floating>
                <twig:Tabler:Navbar:Nav id="sidebar-menu" collapse>
                    <twig:Tabler:Navbar:SectionTitle>Overview</twig:Tabler:Navbar:SectionTitle>
                    <twig:Tabler:Navbar:Item href="/">Home</twig:Tabler:Navbar:Item>
                    <twig:block name="side">
                        <twig:Tabler:Navbar:Side>
                            <twig:Tabler:Navbar:Item href="/help">Help</twig:Tabler:Navbar:Item>
                        </twig:Tabler:Navbar:Side>
                    </twig:block>
                </twig:Tabler:Navbar:Nav>
                <twig:Tabler:Navbar:Footer>
                    <twig:Tabler:Navbar:Item href="/me">Jane</twig:Tabler:Navbar:Item>
                </twig:Tabler:Navbar:Footer>
            </twig:Tabler:Navbar>
            TWIG);

        self::assertHtmlSame(
            '<aside class="navbar d-print-none navbar-expand-lg navbar-vertical navbar-folded-hover navbar-floating">'
            . '<div class="container-fluid">'
            . '<div class="collapse navbar-collapse" id="sidebar-menu">'
            . '<ul class="navbar-nav">'
            . '<li class="nav-section-title">Overview</li>'
            . '<li class="nav-item"><a class="nav-link" href="/"><span class="nav-link-title">Home</span></a></li>'
            . '</ul>'
            . '<div class="navbar-side"><ul class="navbar-nav">'
            . '<li class="nav-item"><a class="nav-link" href="/help"><span class="nav-link-title">Help</span></a></li>'
            . '</ul></div>'
            . '</div>'
            . '<div class="navbar-footer"><ul class="navbar-nav">'
            . '<li class="nav-item"><a class="nav-link" href="/me"><span class="nav-link-title">Jane</span></a></li>'
            . '</ul></div>'
            . '</div>'
            . '</aside>',
            $html,
        );
    }

    public function testFoldedSidebarRail(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Navbar vertical folded container="lg" />');

        self::assertHtmlSame(
            '<aside class="navbar d-print-none navbar-expand-md navbar-vertical navbar-folded"><div class="container-lg"></div></aside>',
            $html,
        );
    }
}
