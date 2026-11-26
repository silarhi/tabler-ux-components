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

final class MockupBrowserTest extends ComponentTestCase
{
    public function testAllInOne(): void
    {
        self::assertHtmlSame(
            '<div class="mockup-browser">'
            . '<div class="mockup-browser-toolbar"><span class="mockup-browser-controls"></span>'
            . '<div class="mockup-browser-url"><span>preview.tabler.io</span></div></div>'
            . '<div class="mockup-browser-body"><img src="/dashboard.png" alt="Dashboard"></div>'
            . '</div>',
            $this->renderComponent('<twig:Tabler:MockupBrowser url="preview.tabler.io" src="/dashboard.png" alt="Dashboard" />'),
        );
    }

    public function testSmallWithSecureAddressAndAttributes(): void
    {
        self::assertHtmlSame(
            '<div class="mockup-browser mockup-browser-sm shadow-none" id="preview">'
            . '<div class="mockup-browser-toolbar"><span class="mockup-browser-controls"></span>'
            . '<div class="mockup-browser-url"><i class="ti ti-lock"></i> <span>https://preview.tabler.io</span></div></div>'
            . '<div class="mockup-browser-body"><img src="/dashboard.png" alt=""></div>'
            . '</div>',
            $this->renderComponent('<twig:Tabler:MockupBrowser size="sm" icon="lock" url="https://preview.tabler.io" src="/dashboard.png" class="shadow-none" id="preview" />'),
        );
    }

    public function testWithoutAddressBarNorBody(): void
    {
        self::assertHtmlSame(
            '<div class="mockup-browser"><div class="mockup-browser-toolbar"><span class="mockup-browser-controls"></span></div></div>',
            $this->renderComponent('<twig:Tabler:MockupBrowser />'),
        );
    }

    public function testBodyBlockKeepsTheToolbar(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:MockupBrowser url="example.com/signup">
                <twig:block name="body"><twig:Tabler:MockupBrowser:Body class="p-4"><h3>Sign up</h3></twig:Tabler:MockupBrowser:Body></twig:block>
            </twig:Tabler:MockupBrowser>
            TWIG);

        self::assertHtmlSame(
            '<div class="mockup-browser">'
            . '<div class="mockup-browser-toolbar"><span class="mockup-browser-controls"></span>'
            . '<div class="mockup-browser-url"><span>example.com/signup</span></div></div>'
            . '<div class="mockup-browser-body p-4"><h3>Sign up</h3></div>'
            . '</div>',
            $html,
        );
    }

    public function testComposed(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:MockupBrowser>
                <twig:Tabler:MockupBrowser:Toolbar class="extra">
                    <twig:Tabler:MockupBrowser:Controls />
                    <twig:Tabler:MockupBrowser:Url icon="lock">preview.tabler.io</twig:Tabler:MockupBrowser:Url>
                </twig:Tabler:MockupBrowser:Toolbar>
                <twig:Tabler:MockupBrowser:Body src="/dashboard.png" alt="Dashboard" />
            </twig:Tabler:MockupBrowser>
            TWIG);

        self::assertHtmlSame(
            '<div class="mockup-browser">'
            . '<div class="mockup-browser-toolbar extra"><span class="mockup-browser-controls"></span>'
            . '<div class="mockup-browser-url"><i class="ti ti-lock"></i> <span>preview.tabler.io</span></div></div>'
            . '<div class="mockup-browser-body"><img src="/dashboard.png" alt="Dashboard"></div>'
            . '</div>',
            $html,
        );
    }

    public function testToolbarAllInOne(): void
    {
        self::assertHtmlSame(
            '<div class="mockup-browser-toolbar"><span class="mockup-browser-controls"></span><div class="mockup-browser-url"><span>a.test</span></div></div>',
            $this->renderComponent('<twig:Tabler:MockupBrowser:Toolbar url="a.test" />'),
        );
    }
}
