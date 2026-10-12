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

    public function testSquareShape(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Avatar square>JL</twig:Tabler:Avatar>');

        self::assertHtmlSame('<span class="avatar avatar-square">JL</span>', $html);
    }

    public function testSmallestAndLargestSizes(): void
    {
        self::assertHtmlSame('<span class="avatar avatar-xxs">JL</span>', $this->renderComponent('<twig:Tabler:Avatar size="xxs">JL</twig:Tabler:Avatar>'));
        self::assertHtmlSame('<span class="avatar avatar-2xl">JL</span>', $this->renderComponent('<twig:Tabler:Avatar size="2xl">JL</twig:Tabler:Avatar>'));
    }

    public function testConsumerStyleIsKeptWithoutImage(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Avatar style="--tblr-avatar-size: 3rem">JL</twig:Tabler:Avatar>');

        self::assertHtmlSame('<span class="avatar" style="--tblr-avatar-size: 3rem">JL</span>', $html);
    }

    public function testConsumerStyleMergesWithImage(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Avatar image="/a.jpg" style="background-position: top" />');

        self::assertHtmlSame('<span class="avatar" style="background-image: url(/a.jpg); background-position: top"></span>', $html);
    }

    public function testBrandConsumerStyleIsKept(): void
    {
        self::assertHtmlSame(
            '<span class="avatar-brand bg-cover" style="background-image: url(/gh.svg); opacity: .5"></span>',
            $this->renderComponent('<twig:Tabler:Avatar:Brand image="/gh.svg" style="opacity: .5" />'),
        );
        self::assertHtmlSame(
            '<span class="avatar-brand" style="opacity: .5"><i class="ti ti-x"></i></span>',
            $this->renderComponent('<twig:Tabler:Avatar:Brand style="opacity: .5"><i class="ti ti-x"></i></twig:Tabler:Avatar:Brand>'),
        );
    }
}
