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

final class TextShimmerTest extends ComponentTestCase
{
    public function testAllInOne(): void
    {
        self::assertHtmlSame(
            '<span class="text-shimmer">Thinking…</span>',
            $this->renderComponent('<twig:Tabler:TextShimmer label="Thinking…" />'),
        );
    }

    public function testLoaderAndLive(): void
    {
        self::assertHtmlSame(
            '<span class="text-shimmer" role="status" aria-live="polite"><span class="text-shimmer-loader" aria-hidden="true"></span>Generating a reply…</span>',
            $this->renderComponent('<twig:Tabler:TextShimmer label="Generating a reply…" loader live />'),
        );
    }

    public function testContentKeepsTheLoader(): void
    {
        self::assertHtmlSame(
            '<span class="text-shimmer"><span class="text-shimmer-loader" aria-hidden="true"></span>Reading <strong>report.pdf</strong>…</span>',
            $this->renderComponent('<twig:Tabler:TextShimmer loader>Reading <strong>report.pdf</strong>…</twig:Tabler:TextShimmer>'),
        );
    }

    public function testComposed(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:TextShimmer tag="div">
                <twig:Tabler:TextShimmer:Loader class="me-2" />
                Thinking…
            </twig:Tabler:TextShimmer>
            TWIG);

        self::assertHtmlSame('<div class="text-shimmer"><span class="text-shimmer-loader me-2" aria-hidden="true"></span>Thinking…</div>', $html);
    }

    public function testAttributesMerge(): void
    {
        self::assertHtmlSame(
            '<span class="text-shimmer text-primary" style="--tblr-text-shimmer-duration: 1s" id="status">Fast</span>',
            $this->renderComponent('<twig:Tabler:TextShimmer label="Fast" class="text-primary" style="--tblr-text-shimmer-duration: 1s" id="status" />'),
        );
    }
}
