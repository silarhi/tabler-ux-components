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

final class KbdTest extends ComponentTestCase
{
    public function testSingleKey(): void
    {
        self::assertHtmlSame('<kbd>Esc</kbd>', $this->renderComponent('<twig:Tabler:Kbd>Esc</twig:Tabler:Kbd>'));
    }

    public function testKeysString(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Kbd keys="ctrl + k" />');

        self::assertHtmlSame('<kbd class="kbd-group"><kbd>ctrl</kbd><kbd>k</kbd></kbd>', $html);
    }

    public function testKeysList(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Kbd keys="{{ [\'⌘\', \'+\'] }}" />');

        self::assertHtmlSame('<kbd class="kbd-group"><kbd>⌘</kbd><kbd>+</kbd></kbd>', $html);
    }

    public function testComposed(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:Kbd:Group class="ms-auto">
                <twig:Tabler:Kbd:Key>⌘</twig:Tabler:Kbd:Key>
                <twig:Tabler:Kbd:Key><twig:Tabler:Icon name="arrow-up" /></twig:Tabler:Kbd:Key>
            </twig:Tabler:Kbd:Group>
            TWIG);

        self::assertHtmlSame('<kbd class="kbd-group ms-auto"><kbd>⌘</kbd><kbd><i class="ti ti-arrow-up"></i></kbd></kbd>', $html);
    }

    public function testKeysBlock(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:Kbd keys="ctrl+k">
                <twig:block name="keys"><twig:Tabler:Kbd:Key title="Control">⌃</twig:Tabler:Kbd:Key><twig:Tabler:Kbd:Key>K</twig:Tabler:Kbd:Key></twig:block>
            </twig:Tabler:Kbd>
            TWIG);

        self::assertHtmlSame('<kbd class="kbd-group"><kbd title="Control">⌃</kbd><kbd>K</kbd></kbd>', $html);
    }

    public function testAttributesMerge(): void
    {
        self::assertHtmlSame(
            '<kbd class="kbd-group ms-auto ps-4" data-shortcut="search"><kbd>⌘</kbd><kbd>K</kbd></kbd>',
            $this->renderComponent('<twig:Tabler:Kbd keys="⌘+K" class="ms-auto ps-4" data-shortcut="search" />'),
        );
        self::assertHtmlSame(
            '<kbd class="text-reset" title="Escape">Esc</kbd>',
            $this->renderComponent('<twig:Tabler:Kbd class="text-reset" title="Escape">Esc</twig:Tabler:Kbd>'),
        );
    }
}
