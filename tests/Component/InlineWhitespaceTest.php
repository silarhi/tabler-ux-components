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

use function sprintf;

/**
 * Components used in running text must not add a space around themselves,
 * while components on consecutive lines keep the line break between them:
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

    #[DataProvider('inlineProvider')]
    public function testLineBreakBetweenConsecutiveComponents(string $component, string $html): void
    {
        self::assertSame("{$html}\n{$html}\n", $this->renderComponent("{$component}\n{$component}\n"));
        self::assertSame("<p>\n    {$html}\n    {$html}\n</p>", $this->renderComponent("<p>\n    {$component}\n    {$component}\n</p>"));
    }

    public function testLineBreaksInsideAParentComponent(): void
    {
        $badge = '<span class="badge text-bg-primary" >%s</span>';

        self::assertSame(
            '<button type="button" class="btn btn-primary" >' . sprintf($badge, 'A') . "\n    " . sprintf($badge, 'B') . "\n</button>",
            $this->renderComponent(<<<'TWIG'
                <twig:Tabler:Button>
                    <twig:Tabler:Badge>A</twig:Tabler:Badge>
                    <twig:Tabler:Badge>B</twig:Tabler:Badge>
                </twig:Tabler:Button>
                TWIG),
        );
        self::assertSame(
            '<button type="button" class="btn btn-primary" >Inbox ' . sprintf($badge, '4') . '</button>',
            $this->renderComponent('<twig:Tabler:Button>Inbox <twig:Tabler:Badge>4</twig:Tabler:Badge></twig:Tabler:Button>'),
        );
    }

    public function testClosingTagInCommentOrVerbatimIsLeftAlone(): void
    {
        self::assertSame('', $this->renderComponent("{# <twig:Tabler:Badge>A</twig:Tabler:Badge>\n #}"));
        self::assertSame(
            "<twig:Tabler:Badge>A</twig:Tabler:Badge>\n",
            $this->renderComponent("{% verbatim %}<twig:Tabler:Badge>A</twig:Tabler:Badge>\n{% endverbatim %}"),
        );
    }
}
