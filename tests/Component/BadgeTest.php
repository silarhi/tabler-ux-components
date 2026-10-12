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

final class BadgeTest extends ComponentTestCase
{
    public function testRendersSpanByDefault(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Badge variant="success">New</twig:Tabler:Badge>');

        self::assertHtmlSame('<span class="badge text-bg-success">New</span>', $html);
    }

    public function testLightVariant(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Badge variant="primary" light>Beta</twig:Tabler:Badge>');

        self::assertHtmlSame('<span class="badge bg-primary-lt">Beta</span>', $html);
    }

    public function testPillVariant(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Badge variant="danger" pill>3</twig:Tabler:Badge>');

        self::assertHtmlSame('<span class="badge badge-pill text-bg-danger">3</span>', $html);
    }

    public function testSize(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Badge variant="info" size="lg">Big</twig:Tabler:Badge>');

        self::assertHtmlSame('<span class="badge badge-lg text-bg-info">Big</span>', $html);
    }

    public function testRendersAnchorWhenHrefGiven(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Badge href="/tags/php" variant="primary" light>PHP</twig:Tabler:Badge>');

        self::assertHtmlSame('<a href="/tags/php" class="badge bg-primary-lt">PHP</a>', $html);
    }

    public function testConsumerClassMerges(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Badge variant="success" class="ms-2">OK</twig:Tabler:Badge>');

        self::assertHtmlSame('<span class="badge text-bg-success ms-2">OK</span>', $html);
    }

    public function testOutlineUsesTextColor(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Badge variant="danger" outline>Deprecated</twig:Tabler:Badge>');

        self::assertHtmlSame('<span class="badge badge-outline text-danger">Deprecated</span>', $html);
    }

    public function testDotNotificationBlinkAndIconOnly(): void
    {
        self::assertHtmlSame(
            '<span class="badge badge-dot text-bg-success" aria-label="Online"></span>',
            $this->renderComponent('<twig:Tabler:Badge variant="success" dot aria-label="Online" />'),
        );
        self::assertHtmlSame(
            '<span class="badge badge-notification badge-blink text-bg-danger">4</span>',
            $this->renderComponent('<twig:Tabler:Badge variant="danger" notification blink>4</twig:Tabler:Badge>'),
        );
        self::assertHtmlSame(
            '<span class="badge badge-icononly bg-primary-lt"><i class="ti ti-star"></i></span>',
            $this->renderComponent('<twig:Tabler:Badge iconOnly light><i class="ti ti-star"></i></twig:Tabler:Badge>'),
        );
    }

    public function testBadgeList(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Badge:List><twig:Tabler:Badge>PHP</twig:Tabler:Badge></twig:Tabler:Badge:List>');

        self::assertHtmlSame('<div class="badge-list"><span class="badge text-bg-primary">PHP</span></div>', $html);
    }
}
