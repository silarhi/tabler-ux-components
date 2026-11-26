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

final class PageTest extends ComponentTestCase
{
    public function testAllInOne(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Page pretitle="Overview" title="Dashboard">
                <twig:block name="navbar"><header class="navbar"></header></twig:block>
                <div class="row row-cards"></div>
                <twig:block name="footer"><footer class="footer"></footer></twig:block>
            </twig:Tabler:Page>
            TWIG);

        self::assertHtmlSame(
            '<div class="page">'
            . '<header class="navbar"></header>'
            . '<div class="page-wrapper">'
            . '<div class="container-xl">'
            . '<div class="page-header d-print-none">'
            . '<div class="row align-items-center">'
            . '<div class="col">'
            . '<div class="page-pretitle">Overview</div>'
            . '<h2 class="page-title">Dashboard</h2>'
            . '</div>'
            . '</div>'
            . '</div>'
            . '</div>'
            . '<main class="page-body"><div class="container-xl"><div class="row row-cards"></div></div></main>'
            . '<footer class="footer"></footer>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testWithoutTitleHasNoHeader(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Page>Content</twig:Tabler:Page>');

        self::assertHtmlSame(
            '<div class="page">'
            . '<div class="page-wrapper">'
            . '<main class="page-body"><div class="container-xl">Content</div></main>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testActionsAreForwardedToThePageHeader(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Page title="Dashboard">
                <twig:block name="actions">
                    <twig:Tabler:PageHeader:Actions>
                        <twig:Tabler:Button variant="primary">New</twig:Tabler:Button>
                    </twig:Tabler:PageHeader:Actions>
                </twig:block>
                Content
            </twig:Tabler:Page>
            TWIG);

        self::assertHtmlSame(
            '<div class="page">'
            . '<div class="page-wrapper">'
            . '<div class="container-xl">'
            . '<div class="page-header d-print-none">'
            . '<div class="row align-items-center">'
            . '<div class="col"><h2 class="page-title">Dashboard</h2></div>'
            . '<div class="col-auto ms-auto"><div class="btn-list">'
            . '<button type="button" class="btn btn-primary">New</button>'
            . '</div></div>'
            . '</div>'
            . '</div>'
            . '</div>'
            . '<main class="page-body"><div class="container-xl">Content</div></main>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testVariantsAndAttributes(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Page fluid center container="narrow" class="bg-white" id="app">Content</twig:Tabler:Page>');

        self::assertHtmlSame(
            '<div class="page layout-fluid page-center bg-white" id="app">'
            . '<div class="page-wrapper">'
            . '<main class="page-body"><div class="container-narrow">Content</div></main>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testContainerAppliesToTheHeaderToo(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Page title="Dashboard" container="fluid">Content</twig:Tabler:Page>');

        self::assertStringContainsString('<div class="container-fluid"><div class="page-header d-print-none">', $this->compact($html));
        self::assertStringContainsString('<main class="page-body"><div class="container-fluid">Content</div></main>', $this->compact($html));
    }

    public function testComposed(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Page>
                <twig:block name="navbar"><aside class="navbar navbar-vertical"></aside></twig:block>
                <twig:block name="wrapper">
                    <twig:Tabler:Page:Wrapper class="page-wrapper-full">
                        <twig:Tabler:Page:Body container="fluid" tag="div" class="page-body-card">Content</twig:Tabler:Page:Body>
                    </twig:Tabler:Page:Wrapper>
                </twig:block>
            </twig:Tabler:Page>
            TWIG);

        self::assertHtmlSame(
            '<div class="page">'
            . '<aside class="navbar navbar-vertical"></aside>'
            . '<div class="page-wrapper page-wrapper-full">'
            . '<div class="page-body page-body-card"><div class="container-fluid">Content</div></div>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testOverrideBody(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Page>
                <twig:block name="body">
                    <twig:Tabler:Page:Body>First</twig:Tabler:Page:Body>
                    <twig:Tabler:Page:Body tag="div">Second</twig:Tabler:Page:Body>
                </twig:block>
            </twig:Tabler:Page>
            TWIG);

        self::assertHtmlSame(
            '<div class="page">'
            . '<div class="page-wrapper">'
            . '<main class="page-body"><div class="container-xl">First</div></main>'
            . '<div class="page-body"><div class="container-xl">Second</div></div>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testBodyOverrideKeepsTheChildrenThroughOuterBlocks(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Page>
                <twig:block name="body">
                    <twig:Tabler:Page:Body id="content">{{ block(outerBlocks.content) }}</twig:Tabler:Page:Body>
                </twig:block>
                Content
            </twig:Tabler:Page>
            TWIG);

        self::assertHtmlSame(
            '<div class="page">'
            . '<div class="page-wrapper">'
            . '<main class="page-body" id="content"><div class="container-xl">Content</div></main>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testWithNavbarAndFooter(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Page title="Dashboard">
                <twig:block name="navbar">
                    <twig:Tabler:Navbar expand="sm">
                        <twig:Tabler:Navbar:Brand href="/">Acme</twig:Tabler:Navbar:Brand>
                    </twig:Tabler:Navbar>
                </twig:block>
                Content
                <twig:block name="footer">
                    <twig:Tabler:Footer transparent copyright="Acme" />
                </twig:block>
            </twig:Tabler:Page>
            TWIG);

        $html = $this->compact($html);
        self::assertStringStartsWith('<div class="page"><header class="navbar d-print-none navbar-expand-sm">', $html);
        self::assertStringContainsString('</header><div class="page-wrapper"><div class="container-xl"><div class="page-header d-print-none">', $html);
        self::assertStringEndsWith('</main><footer class="footer d-print-none footer-transparent"><div class="container-xl"><div class="row text-center align-items-center flex-row-reverse"><div class="col-12 col-lg-auto mt-3 mt-lg-0"><ul class="list-inline list-inline-dots mb-0"><li class="list-inline-item">Acme</li></ul></div></div></div></footer></div></div>', $html);
    }

    private function compact(string $html): string
    {
        $html = preg_replace('/\s+/', ' ', $html) ?? $html;
        $html = preg_replace('/\s*(<|>)\s*/', '$1', $html) ?? $html;

        return preg_replace('/\s+(\/?>)/', '$1', $html) ?? $html;
    }
}
