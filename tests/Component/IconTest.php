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

use DOMDocument;
use DOMElement;
use Silarhi\TablerUxComponents\Tests\ComponentTestCase;

final class IconTest extends ComponentTestCase
{
    public function testBasicIcon(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Icon name="check" />');

        self::assertHtmlSame('<i class="ti ti-check"></i>', $html);
    }

    public function testColorAndAnimation(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Icon name="refresh" variant="danger" animation="rotate" />');

        self::assertHtmlSame('<i class="ti text-danger icon-rotate ti-refresh"></i>', $html);
    }

    public function testConsumerClassMerges(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Icon name="heart" class="me-1" />');

        self::assertHtmlSame('<i class="ti ti-heart me-1"></i>', $html);
    }

    public function testFilledUsesTheFilledWebfontClasses(): void
    {
        // @tabler/icons-webfont 3.36.1+ ships the filled icons as their own font: tabler-icons-filled.scss
        // compiled with $ti-prefix: 'ti-filled' styles these classes, next to the outline ti ones
        self::assertHtmlSame(
            '<i class="ti-filled text-warning ti-filled-star me-1" aria-hidden="true"></i>',
            $this->renderComponent('<twig:Tabler:Icon name="star" variant="warning" filled class="me-1" aria-hidden="true" />'),
        );
        self::assertHtmlSame('<i class="ti ti-star"></i>', $this->renderComponent('<twig:Tabler:Icon name="star" filled="{{ false }}" />'));
    }

    public function testPrefixedNameRendersAnUxIconsSvg(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Icon name="tabler:check" />');

        self::assertSame(['class' => 'icon', 'aria-hidden' => 'true'], self::svgAttributes($html, 'class', 'aria-hidden', 'aria-label'));
        self::assertStringContainsString('d="m5 12l5 5L20 7"', $html);
    }

    public function testUxIconsSvgGetsTheSameClassesAndAttributes(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Icon name="tabler:check" variant="danger" animation="rotate" size="sm" class="me-1" id="saved" aria-label="Saved" />');

        // An aria-label replaces the aria-hidden that UX Icons adds to decorative icons
        self::assertSame(
            ['class' => 'icon text-danger icon-rotate icon-sm me-1', 'id' => 'saved', 'aria-label' => 'Saved'],
            self::svgAttributes($html, 'class', 'id', 'aria-label', 'aria-hidden'),
        );
    }

    public function testFilledPicksTheFilledIconOfTheTablerSetOnly(): void
    {
        self::assertStringContainsString(
            '<path fill="currentColor" d="m8.243 7.34',
            $this->renderComponent('<twig:Tabler:Icon name="tabler:star" filled />'),
        );
        // Other sets have no filled convention: the icon is rendered as named
        self::assertStringContainsString(
            '<circle cx="12" cy="12" r="10">',
            $this->renderComponent('<twig:Tabler:Icon name="lucide:circle-check" filled />'),
        );
    }

    public function testComponentIconPropsAcceptUxIconsNames(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Alert icon="lucide:circle-check" title="Saved!" />');

        self::assertMatchesRegularExpression('#class="alert-icon"><svg [^>]*class="icon"#', $html);
        self::assertStringContainsString('<circle cx="12" cy="12" r="10">', $html);
    }

    /**
     * The given attributes of the first <svg>, in the order asked, without the missing ones: UX Icons releases
     * order and add attributes differently (2.17 has no xmlns).
     *
     * @return array<string, string>
     */
    private static function svgAttributes(string $html, string ...$names): array
    {
        $document = new DOMDocument();
        self::assertTrue(@$document->loadHTML($html));
        $svg = $document->getElementsByTagName('svg')->item(0);
        self::assertInstanceOf(DOMElement::class, $svg);

        $attributes = [];
        foreach ($names as $name) {
            if ($svg->hasAttribute($name)) {
                $attributes[$name] = $svg->getAttribute($name);
            }
        }

        return $attributes;
    }
}
