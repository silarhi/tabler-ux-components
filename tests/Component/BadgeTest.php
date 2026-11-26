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

    public function testLinkBadgeFromHeaderExample(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Badge href="/tags/php" variant="info" light>PHP</twig:Tabler:Badge>');

        self::assertHtmlSame('<a href="/tags/php" class="badge bg-info-lt">PHP</a>', $html);
    }

    public function testIcon(): void
    {
        self::assertHtmlSame(
            '<span class="badge text-bg-success"><i class="ti ti-check icon" aria-hidden="true"></i>Verified</span>',
            $this->renderComponent('<twig:Tabler:Badge variant="success" icon="check">Verified</twig:Tabler:Badge>'),
        );
        self::assertHtmlSame(
            '<span class="badge badge-icononly bg-warning-lt" aria-label="Starred"><i class="ti ti-star icon" aria-hidden="true"></i></span>',
            $this->renderComponent('<twig:Tabler:Badge variant="warning" light icon="star" iconOnly aria-label="Starred" />'),
        );
    }

    public function testIconBlockCanBeOverridden(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Badge icon="star"><twig:block name="icon"><span class="status-dot"></span></twig:block>Live</twig:Tabler:Badge>');

        self::assertHtmlSame('<span class="badge text-bg-primary"><span class="status-dot"></span>Live</span>', $html);
    }

    public function testBadgeListItems(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:Badge:List class="mb-2" items="{{ [
                {text: 'PHP'},
                {text: 'Symfony', variant: 'success', light: true, icon: 'check'},
                {text: 'Twig', variant: 'info', outline: true, pill: true, size: 'sm', href: '/tags/twig'},
            ] }}" />
            TWIG);

        self::assertHtmlSame(
            '<div class="badge-list mb-2">'
            . '<span class="badge text-bg-primary">PHP</span>'
            . '<span class="badge bg-success-lt"><i class="ti ti-check icon" aria-hidden="true"></i>Symfony</span>'
            . '<a href="/tags/twig" class="badge badge-sm badge-pill badge-outline text-info">Twig</a>'
            . '</div>',
            $html,
        );
    }

    public function testBadgeListItemsAreEscaped(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Badge:List items="{{ [{text: \'<b>x</b>\'}] }}" />');

        self::assertHtmlSame('<div class="badge-list"><span class="badge text-bg-primary">&lt;b&gt;x&lt;/b&gt;</span></div>', $html);
    }
}
