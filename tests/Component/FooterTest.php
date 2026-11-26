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

final class FooterTest extends ComponentTestCase
{
    public function testAllInOne(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Footer
                copyright="Copyright © 2026 Acme"
                links="{{ [{label: 'v1.2.0', href: '/changelog'}] }}"
                endLinks="{{ [{label: 'Documentation', href: '/docs'}, {label: 'Made in <France>'}] }}"
            />
            TWIG);

        self::assertHtmlSame(
            '<footer class="footer d-print-none">'
            . '<div class="container-xl">'
            . '<div class="row text-center align-items-center flex-row-reverse">'
            . '<div class="col-lg-auto ms-lg-auto">'
            . '<ul class="list-inline list-inline-dots mb-0">'
            . '<li class="list-inline-item"><a href="/docs" class="link-secondary">Documentation</a></li>'
            . '<li class="list-inline-item">Made in &lt;France&gt;</li>'
            . '</ul>'
            . '</div>'
            . '<div class="col-12 col-lg-auto mt-3 mt-lg-0">'
            . '<ul class="list-inline list-inline-dots mb-0">'
            . '<li class="list-inline-item">Copyright © 2026 Acme</li>'
            . '<li class="list-inline-item"><a href="/changelog" class="link-secondary">v1.2.0</a></li>'
            . '</ul>'
            . '</div>'
            . '</div>'
            . '</div>'
            . '</footer>',
            $html,
        );
    }

    public function testEmptySidesAreNotRendered(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Footer copyright="Acme" />');

        self::assertHtmlSame(
            '<footer class="footer d-print-none">'
            . '<div class="container-xl">'
            . '<div class="row text-center align-items-center flex-row-reverse">'
            . '<div class="col-12 col-lg-auto mt-3 mt-lg-0">'
            . '<ul class="list-inline list-inline-dots mb-0"><li class="list-inline-item">Acme</li></ul>'
            . '</div>'
            . '</div>'
            . '</div>'
            . '</footer>',
            $html,
        );
    }

    public function testEndLinksOnly(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Footer endLinks="{{ [{label: \'Docs\', href: \'/docs\'}] }}" />');

        self::assertHtmlSame(
            '<footer class="footer d-print-none">'
            . '<div class="container-xl">'
            . '<div class="row text-center align-items-center flex-row-reverse">'
            . '<div class="col-lg-auto ms-lg-auto">'
            . '<ul class="list-inline list-inline-dots mb-0"><li class="list-inline-item"><a href="/docs" class="link-secondary">Docs</a></li></ul>'
            . '</div>'
            . '</div>'
            . '</div>'
            . '</footer>',
            $html,
        );
    }

    public function testVariantsAndAttributes(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Footer transparent container="fluid" class="mt-0" id="footer">Custom</twig:Tabler:Footer>');

        self::assertHtmlSame(
            '<footer class="footer d-print-none footer-transparent mt-0" id="footer">'
            . '<div class="container-fluid">Custom</div>'
            . '</footer>',
            $html,
        );
    }

    public function testCopyrightBlock(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Footer links="{{ [{label: 'v1.2.0', href: '/changelog'}] }}">
                <twig:block name="copyright">
                    <twig:Tabler:Footer:Item>Copyright © 2026 <a href="/" class="link-secondary">Acme</a></twig:Tabler:Footer:Item>
                </twig:block>
            </twig:Tabler:Footer>
            TWIG);

        self::assertHtmlSame(
            '<footer class="footer d-print-none">'
            . '<div class="container-xl">'
            . '<div class="row text-center align-items-center flex-row-reverse">'
            . '<div class="col-12 col-lg-auto mt-3 mt-lg-0">'
            . '<ul class="list-inline list-inline-dots mb-0">'
            . '<li class="list-inline-item">Copyright © 2026<a href="/" class="link-secondary">Acme</a></li>'
            . '<li class="list-inline-item"><a href="/changelog" class="link-secondary">v1.2.0</a></li>'
            . '</ul>'
            . '</div>'
            . '</div>'
            . '</div>'
            . '</footer>',
            $html,
        );
    }

    public function testComposed(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Footer transparent>
                <twig:block name="start">
                    <twig:Tabler:Footer:Links class="text-secondary">
                        <twig:Tabler:Footer:Item>Acme</twig:Tabler:Footer:Item>
                    </twig:Tabler:Footer:Links>
                </twig:block>
                <twig:block name="end">
                    <nav aria-label="Footer">
                        <twig:Tabler:Footer:Links>
                            <twig:Tabler:Footer:Item href="/docs" class="me-3">Docs</twig:Tabler:Footer:Item>
                        </twig:Tabler:Footer:Links>
                    </nav>
                </twig:block>
            </twig:Tabler:Footer>
            TWIG);

        self::assertHtmlSame(
            '<footer class="footer d-print-none footer-transparent">'
            . '<div class="container-xl">'
            . '<div class="row text-center align-items-center flex-row-reverse">'
            . '<div class="col-lg-auto ms-lg-auto">'
            . '<nav aria-label="Footer"><ul class="list-inline list-inline-dots mb-0">'
            . '<li class="list-inline-item me-3"><a href="/docs" class="link-secondary">Docs</a></li>'
            . '</ul></nav>'
            . '</div>'
            . '<div class="col-12 col-lg-auto mt-3 mt-lg-0">'
            . '<ul class="list-inline list-inline-dots mb-0 text-secondary"><li class="list-inline-item">Acme</li></ul>'
            . '</div>'
            . '</div>'
            . '</div>'
            . '</footer>',
            $html,
        );
    }
}
