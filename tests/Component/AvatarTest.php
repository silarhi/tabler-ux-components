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

final class AvatarTest extends ComponentTestCase
{
    public function testInitials(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Avatar>JL</twig:Tabler:Avatar>');

        self::assertHtmlSame('<span class="avatar">JL</span>', $html);
    }

    public function testSizeAndColor(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Avatar size="lg" variant="primary">AB</twig:Tabler:Avatar>');

        self::assertHtmlSame('<span class="avatar avatar-lg bg-primary-lt">AB</span>', $html);
    }

    public function testRoundedWithImage(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Avatar image="/a.jpg" rounded />');

        self::assertHtmlSame('<span class="avatar rounded-circle" style="background-image: url(/a.jpg)"></span>', $html);
    }

    public function testConsumerClassMerges(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Avatar size="sm" class="me-2">CD</twig:Tabler:Avatar>');

        self::assertHtmlSame('<span class="avatar avatar-sm me-2">CD</span>', $html);
    }
}
