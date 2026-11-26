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

final class HoverGalleryTest extends ComponentTestCase
{
    public function testAllInOneImages(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:HoverGallery images="{{ images }}" />',
            ['images' => [
                ['src' => '/a.jpg', 'alt' => 'Front view'],
                ['src' => '/b.jpg'],
            ]],
        );

        self::assertHtmlSame(
            '<div class="hover-gallery">'
            . '<div class="hover-gallery-item"><img src="/a.jpg" alt="Front view"></div>'
            . '<div class="hover-gallery-item"><img src="/b.jpg" alt=""></div>'
            . '</div>',
            $html,
        );
    }

    public function testComposedWithIndicatorsAndAttributes(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:HoverGallery indicators class="rounded" style="--tblr-hover-gallery-aspect-ratio: 16 / 9">
                <twig:Tabler:HoverGallery:Item src="/a.jpg" alt="Front view" class="extra" />
                <twig:Tabler:HoverGallery:Item><img src="/b.jpg" srcset="/b@2x.jpg 2x" alt="Back view"></twig:Tabler:HoverGallery:Item>
            </twig:Tabler:HoverGallery>
            TWIG);

        self::assertHtmlSame(
            '<div class="hover-gallery hover-gallery-indicators rounded" style="--tblr-hover-gallery-aspect-ratio: 16 / 9">'
            . '<div class="hover-gallery-item extra"><img src="/a.jpg" alt="Front view"></div>'
            . '<div class="hover-gallery-item"><img src="/b.jpg" srcset="/b@2x.jpg 2x" alt="Back view"></div>'
            . '</div>',
            $html,
        );
    }

    public function testEscapesImageProps(): void
    {
        self::assertHtmlSame(
            '<div class="hover-gallery-item"><img src="/a.jpg?x=1&amp;y=2" alt="&quot;Quoted&quot;"></div>',
            $this->renderComponent('<twig:Tabler:HoverGallery:Item src="/a.jpg?x=1&y=2" alt="{{ alt }}" />', ['alt' => '"Quoted"']),
        );
    }
}
