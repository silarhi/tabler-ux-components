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

final class StatusTest extends ComponentTestCase
{
    public function testColorLabel(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Status variant="success">Online</twig:Tabler:Status>');

        self::assertHtmlSame('<span class="status status-success">Online</span>', $html);
    }

    public function testDot(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Status variant="danger" dot label="Live" />');

        self::assertHtmlSame('<span class="status status-danger"><span class="status-dot"></span>Live</span>', $html);
    }

    public function testAnimatedDot(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Status variant="danger" dot animated label="Live" />');

        self::assertHtmlSame('<span class="status status-danger"><span class="status-dot status-dot-animated"></span>Live</span>', $html);
    }

    public function testDotAndLabelLiveInsideContentBlock(): void
    {
        // Overriding `content` replaces the dot AND label — proving both are inside it.
        $html = $this->renderComponent('<twig:Tabler:Status variant="danger" dot label="Live">Custom</twig:Tabler:Status>');

        self::assertHtmlSame('<span class="status status-danger">Custom</span>', $html);
    }
}
