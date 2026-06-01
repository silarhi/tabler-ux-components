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

        self::assertHtmlSame('<span class="badge bg-primary-lt text-primary-lt-fg">Beta</span>', $html);
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

        self::assertHtmlSame('<a href="/tags/php" class="badge bg-primary-lt text-primary-lt-fg">PHP</a>', $html);
    }

    public function testConsumerClassMerges(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Badge variant="success" class="ms-2">OK</twig:Tabler:Badge>');

        self::assertHtmlSame('<span class="badge text-bg-success ms-2">OK</span>', $html);
    }
}
