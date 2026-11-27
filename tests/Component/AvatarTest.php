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

    public function testNameRendersInitialsAndLabel(): void
    {
        self::assertHtmlSame(
            '<span class="avatar" role="img" title="Jane Doe" aria-label="Jane Doe">JD</span>',
            $this->renderComponent('<twig:Tabler:Avatar name="Jane Doe" />'),
        );
        self::assertHtmlSame(
            '<span class="avatar" role="img" title="Jean Paul Gaultier" aria-label="Jean Paul Gaultier">JP</span>',
            $this->renderComponent('<twig:Tabler:Avatar name="  Jean  Paul Gaultier " />'),
        );
    }

    public function testInitialsAreMultibyteSafe(): void
    {
        self::assertHtmlSame(
            '<span class="avatar" role="img" title="élodie" aria-label="élodie">É</span>',
            $this->renderComponent('<twig:Tabler:Avatar name="élodie" />'),
        );
        self::assertHtmlSame(
            '<span class="avatar" role="img" title="Øyvind Åsen" aria-label="Øyvind Åsen">ØÅ</span>',
            $this->renderComponent('<twig:Tabler:Avatar name="Øyvind Åsen" />'),
        );
    }

    public function testNameWithImageOrChildrenKeepsTheirContent(): void
    {
        self::assertHtmlSame(
            '<span class="avatar" style="background-image: url(/a.jpg)" role="img" title="Jane Doe" aria-label="Jane Doe"></span>',
            $this->renderComponent('<twig:Tabler:Avatar name="Jane Doe" image="/a.jpg" />'),
        );
        self::assertHtmlSame(
            '<span class="avatar" role="img" title="Jane Doe" aria-label="Jane Doe"><i class="ti ti-user"></i></span>',
            $this->renderComponent('<twig:Tabler:Avatar name="Jane Doe"><i class="ti ti-user"></i></twig:Tabler:Avatar>'),
        );
    }

    public function testExplicitAttributesWinOverName(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Avatar name="Jane Doe" title="Jane (admin)" aria-label="Jane Doe, administrator" class="me-2" data-id="7" />');

        self::assertHtmlSame('<span class="avatar me-2" role="img" title="Jane (admin)" aria-label="Jane Doe, administrator" data-id="7">JD</span>', $html);
    }

    public function testColor(): void
    {
        self::assertHtmlSame(
            '<span class="avatar bg-purple-lt">JL</span>',
            $this->renderComponent('<twig:Tabler:Avatar color="purple">JL</twig:Tabler:Avatar>'),
        );
        self::assertHtmlSame(
            '<span class="avatar bg-teal-lt">JL</span>',
            $this->renderComponent('<twig:Tabler:Avatar color="teal" variant="primary">JL</twig:Tabler:Avatar>'),
        );
    }

    public function testTablerColorVariant(): void
    {
        self::assertHtmlSame(
            '<span class="avatar bg-azure-lt">JL</span>',
            $this->renderComponent('<twig:Tabler:Avatar variant="azure">JL</twig:Tabler:Avatar>'),
        );
        self::assertHtmlSame(
            '<span class="avatar bg-teal-lt">JL</span>',
            $this->renderComponent('<twig:Tabler:Avatar color="teal" variant="orange">JL</twig:Tabler:Avatar>'),
        );
    }

    public function testAutoColorIsStable(): void
    {
        $jane = $this->renderComponent('<twig:Tabler:Avatar name="Jane Doe" color="auto" />');

        self::assertHtmlSame('<span class="avatar bg-cyan-lt" role="img" title="Jane Doe" aria-label="Jane Doe">JD</span>', $jane);
        self::assertSame($jane, $this->renderComponent('<twig:Tabler:Avatar name="Jane Doe" color="auto" />'));
        self::assertHtmlSame(
            '<span class="avatar bg-pink-lt" role="img" title="élodie" aria-label="élodie">É</span>',
            $this->renderComponent('<twig:Tabler:Avatar name="élodie" color="auto" />'),
        );
    }

    public function testAutoColorWithoutNameRendersNoColor(): void
    {
        self::assertHtmlSame(
            '<span class="avatar bg-primary-lt">JL</span>',
            $this->renderComponent('<twig:Tabler:Avatar color="auto" variant="primary">JL</twig:Tabler:Avatar>'),
        );
    }

    public function testAvatarListItems(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:Avatar:List stacked size="sm" class="mb-3" items="{{ [
                {image: '/a.jpg'},
                {name: 'Jane Doe', variant: 'primary', rounded: true},
                {name: 'Paweł Kuna', color: 'green', square: true, size: 'lg'},
                {text: '+8'},
            ] }}" />
            TWIG);

        self::assertHtmlSame(
            '<div class="avatar-list avatar-list-stacked avatar-list-sm mb-3">'
            . '<span class="avatar" style="background-image: url(/a.jpg)"></span>'
            . '<span class="avatar bg-primary-lt rounded-circle" role="img" title="Jane Doe" aria-label="Jane Doe">JD</span>'
            . '<span class="avatar avatar-lg bg-green-lt avatar-square" role="img" title="Paweł Kuna" aria-label="Paweł Kuna">PK</span>'
            . '<span class="avatar">+8</span>'
            . '</div>',
            $html,
        );
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

    public function testTooltip(): void
    {
        self::assertHtmlSame(
            '<span class="avatar" style="background-image: url(/a.jpg)" data-bs-toggle="tooltip" title="Jane Doe"></span>',
            $this->renderComponent('<twig:Tabler:Avatar image="/a.jpg" tooltip="Jane Doe" />'),
        );
    }

    public function testTooltipReplacesTheTitleOfName(): void
    {
        // The name stays the accessible name; the tooltip only replaces the title
        self::assertHtmlSame(
            '<span class="avatar" role="img" title="Jane Doe, project owner" aria-label="Jane Doe" data-bs-toggle="tooltip">JD</span>',
            $this->renderComponent('<twig:Tabler:Avatar name="Jane Doe" tooltip="Jane Doe, project owner" />'),
        );
    }

    public function testExplicitAttributesWinOverTooltip(): void
    {
        self::assertHtmlSame(
            '<span class="avatar" role="img" title="Owner" aria-label="Jane Doe" data-bs-toggle="popover">JD</span>',
            $this->renderComponent('<twig:Tabler:Avatar name="Jane Doe" tooltip="Jane Doe, project owner" title="Owner" data-bs-toggle="popover" />'),
        );
    }

    public function testAvatarListItemTooltip(): void
    {
        self::assertHtmlSame(
            '<div class="avatar-list avatar-list-stacked"><span class="avatar" role="img" title="Jane Doe, owner" aria-label="Jane Doe" data-bs-toggle="tooltip">JD</span></div>',
            $this->renderComponent('<twig:Tabler:Avatar:List stacked items="{{ [{name: \'Jane Doe\', tooltip: \'Jane Doe, owner\'}] }}" />'),
        );
    }
}
