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

final class ClipboardTest extends ComponentTestCase
{
    public function testTargetWithDefaultLabels(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Clipboard target="#api-key" />');

        self::assertHtmlSame(
            '<button type="button" class="btn" data-bs-toggle="clipboard" data-bs-target="#api-key">'
            . '<span class="clipboard-label">Copy</span>'
            . '<span class="clipboard-feedback">Copied</span>'
            . '</button>',
            $html,
        );
    }

    public function testLiteralTextDelayAndCustomLabels(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Clipboard text="https://tabler.io/" delay="0" label="Copy link" feedback="Link copied" class="btn-sm" />');

        self::assertHtmlSame(
            '<button type="button" class="btn btn-sm" data-bs-toggle="clipboard" data-bs-text="https://tabler.io/" data-bs-delay="0">'
            . '<span class="clipboard-label">Copy link</span>'
            . '<span class="clipboard-feedback">Link copied</span>'
            . '</button>',
            $html,
        );
    }

    public function testComposedStates(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Clipboard target="#key" aria-label="Copy the key">
                <twig:Tabler:Clipboard:Label><i class="ti ti-copy"></i></twig:Tabler:Clipboard:Label>
                <twig:Tabler:Clipboard:Feedback class="text-green"><i class="ti ti-check"></i></twig:Tabler:Clipboard:Feedback>
            </twig:Tabler:Clipboard>
            TWIG);

        self::assertHtmlSame(
            '<button type="button" class="btn" aria-label="Copy the key" data-bs-toggle="clipboard" data-bs-target="#key">'
            . '<span class="clipboard-label"><i class="ti ti-copy"></i></span>'
            . '<span class="clipboard-feedback text-green"><i class="ti ti-check"></i></span>'
            . '</button>',
            $html,
        );
    }
}
