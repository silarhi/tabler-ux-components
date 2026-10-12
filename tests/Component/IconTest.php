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
}
