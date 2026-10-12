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

use PHPUnit\Framework\Attributes\DataProvider;
use Silarhi\TablerUxComponents\Tests\ComponentTestCase;

/**
 * Components used in running text must not add a space around themselves:
 * assertHtmlSame() collapses whitespace, so these compare the exact output.
 */
final class InlineWhitespaceTest extends ComponentTestCase
{
    /**
     * @return iterable<string, array{string, string}>
     */
    public static function inlineProvider(): iterable
    {
        yield 'Badge' => ['<twig:Tabler:Badge variant="success">New</twig:Tabler:Badge>', '<span class="badge text-bg-success" >New</span>'];
        yield 'Icon' => ['<twig:Tabler:Icon name="star" />', '<i class="ti ti-star" ></i>'];
        yield 'Mention' => ['<twig:Tabler:Mention>Jane</twig:Tabler:Mention>', '<span  class="mention">Jane</span>'];
        yield 'Status' => ['<twig:Tabler:Status label="Online" />', '<span class="status status-primary" >Online</span>'];
    }

    #[DataProvider('inlineProvider')]
    public function testNoSpaceAroundInlineComponent(string $component, string $html): void
    {
        self::assertSame("Click {$html}.", $this->renderComponent("Click {$component}."));
    }
}
