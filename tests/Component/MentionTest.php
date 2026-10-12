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

final class MentionTest extends ComponentTestCase
{
    public function testPersonLinkWithHiddenPrefix(): void
    {
        self::assertHtmlSame(
            '<a href="/u/john" class="mention"><span class="mention-avatar" style="background-image: url(/john.jpg)"></span><span class="visually-hidden">@</span>JohnDoe</a>',
            $this->renderComponent('<twig:Tabler:Mention label="JohnDoe" prefix="@" prefixHidden avatar="/john.jpg" href="/u/john" />'),
        );
    }

    public function testApp(): void
    {
        self::assertHtmlSame(
            '<span class="mention"><span class="mention-app" style="background-image: url(/github.svg)"></span>GitHub</span>',
            $this->renderComponent('<twig:Tabler:Mention label="GitHub" logo="/github.svg" />'),
        );
    }

    public function testColorSwatch(): void
    {
        self::assertHtmlSame(
            '<span class="mention extra"><span class="mention-color bg-blue"></span>#066fd1</span>',
            $this->renderComponent('<twig:Tabler:Mention label="#066fd1" swatch="blue" class="extra" />'),
        );
    }

    public function testVisiblePrefixAndCount(): void
    {
        self::assertHtmlSame(
            '<a href="/tags/web" class="mention">#WebDevelopment<span class="mention-count">16</span></a>',
            $this->renderComponent('<twig:Tabler:Mention label="WebDevelopment" prefix="#" count="16" href="/tags/web" />'),
        );
    }

    public function testComposed(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Mention href="/u/jane" data-user="7">
                <twig:Tabler:Mention:Avatar image="/jane.jpg" />
                <span class="visually-hidden">@</span>JaneSmith
                <twig:Tabler:Mention:Count>3</twig:Tabler:Mention:Count>
            </twig:Tabler:Mention>
            TWIG);

        self::assertHtmlSame(
            '<a href="/u/jane" class="mention" data-user="7"><span class="mention-avatar" style="background-image: url(/jane.jpg)"></span><span class="visually-hidden">@</span>JaneSmith<span class="mention-count">3</span></a>',
            $html,
        );
    }

    public function testStandaloneColor(): void
    {
        self::assertHtmlSame(
            '<span class="mention-color bg-orange"></span>',
            $this->renderComponent('<twig:Tabler:Mention:Color variant="orange" />'),
        );
    }
}
