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
 * The last Tabler 1.6 classes: action buttons, card parts, stacked progress, table cells, plain lists.
 */
/**
 * Image props end up in an inline `background-image: url(…)`: the URL must not
 * be able to close it and add CSS declarations of its own.
 */
final class BackgroundImageTest extends ComponentTestCase
{
    private const HOSTILE = "/a.jpg); color: red; x: url('q\"";
    private const ESCAPED = 'url(/a.jpg\);\ color:\ red;\ x:\ url\(\&#039;q\&quot;)';

    /**
     * @return iterable<string, array{string}>
     */
    public static function componentProvider(): iterable
    {
        yield 'Avatar' => ['<twig:Tabler:Avatar image="{{ url }}" />'];
        yield 'Avatar:Brand' => ['<twig:Tabler:Avatar:Brand image="{{ url }}" />'];
        yield 'Card:Cover' => ['<twig:Tabler:Card:Cover image="{{ url }}" />'];
        yield 'Carousel:Indicator' => ['<twig:Tabler:Carousel:Indicator image="{{ url }}" />'];
        yield 'Chat:Message' => ['<twig:Tabler:Chat:Message avatar="{{ url }}" />'];
        yield 'Mention:App' => ['<twig:Tabler:Mention:App image="{{ url }}" />'];
        yield 'Mention:Avatar' => ['<twig:Tabler:Mention:Avatar image="{{ url }}" />'];
        yield 'Tag:Avatar' => ['<twig:Tabler:Tag:Avatar image="{{ url }}" />'];
    }

    #[DataProvider('componentProvider')]
    public function testUrlCannotLeaveTheBackgroundImage(string $component): void
    {
        $html = $this->renderComponent('{% autoescape "html" %}' . $component . '{% endautoescape %}', ['url' => self::HOSTILE]);

        self::assertStringContainsString('style="background-image: ' . self::ESCAPED . '"', $html);
    }

    public function testPlainUrlIsUnchanged(): void
    {
        self::assertHtmlSame(
            '<span class="avatar" style="background-image: url(/avatars/jane-doe_1.jpg?v=2&amp;s=64)"></span>',
            $this->renderComponent('<twig:Tabler:Avatar image="/avatars/jane-doe_1.jpg?v=2&s=64" />'),
        );
    }

    public function testWhitespaceAndBackslashesAreEscaped(): void
    {
        self::assertStringContainsString(
            'url(/my\ photo\\\\1\a .jpg)',
            $this->renderComponent('<twig:Tabler:Avatar image="{{ url }}" />', ['url' => "/my photo\\1\n.jpg"]),
        );
    }
}
