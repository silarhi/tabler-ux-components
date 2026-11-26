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

use function sprintf;

final class InputIconTest extends ComponentTestCase
{
    public function testAllInOne(): void
    {
        $html = $this->renderComponent('<twig:Tabler:InputIcon icon="search" name="q" id="q" value="tabler" placeholder="Search…" label="Search" />');

        self::assertHtmlSame(
            '<div class="input-icon">'
            . '<input type="text" class="form-control" name="q" id="q" value="tabler" placeholder="Search…" aria-label="Search">'
            . '<span class="input-icon-addon"><i class="ti ti-search"></i></span>'
            . '</div>',
            $html,
        );
    }

    public function testPositionStart(): void
    {
        $html = $this->renderComponent('<twig:Tabler:InputIcon icon="user" position="start" type="email" />');

        self::assertHtmlSame(
            '<div class="input-icon"><span class="input-icon-addon"><i class="ti ti-user"></i></span><input type="email" class="form-control"></div>',
            $html,
        );
    }

    public function testLoader(): void
    {
        $html = $this->renderComponent('<twig:Tabler:InputIcon loader placeholder="Loading…" />');

        self::assertHtmlSame(
            '<div class="input-icon">'
            . '<input type="text" class="form-control" placeholder="Loading…">'
            . '<span class="input-icon-addon"><div class="spinner-border text-secondary spinner-border-sm" role="status"></div></span>'
            . '</div>',
            $html,
        );
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function sizeProvider(): iterable
    {
        yield 'sm' => ['sm', 'form-control form-control-sm'];
        yield 'md' => ['md', 'form-control'];
        yield 'lg' => ['lg', 'form-control form-control-lg'];
    }

    #[DataProvider('sizeProvider')]
    public function testSizes(string $size, string $class): void
    {
        $html = $this->renderComponent('<twig:Tabler:InputIcon icon="search" size="{{ size }}" />', ['size' => $size]);

        self::assertStringContainsString(sprintf('<input type="text" class="%s">', $class), $html);
    }

    public function testContentKeepsTheAddon(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:InputIcon icon="search" position="start">
                <input type="search" class="form-control form-control-rounded" name="query">
            </twig:Tabler:InputIcon>
            TWIG);

        self::assertHtmlSame(
            '<div class="input-icon"><span class="input-icon-addon"><i class="ti ti-search"></i></span><input type="search" class="form-control form-control-rounded" name="query"></div>',
            $html,
        );
    }

    public function testComposed(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:InputIcon>
                <twig:Tabler:InputIcon:Addon icon="mail" />
                <input type="email" class="form-control" name="email">
                <twig:Tabler:InputIcon:Addon class="text-secondary">@example.com</twig:Tabler:InputIcon:Addon>
            </twig:Tabler:InputIcon>
            TWIG);

        self::assertHtmlSame(
            '<div class="input-icon">'
            . '<span class="input-icon-addon"><i class="ti ti-mail"></i></span>'
            . '<input type="email" class="form-control" name="email">'
            . '<span class="input-icon-addon text-secondary">@example.com</span>'
            . '</div>',
            $html,
        );
    }

    public function testAddonBlock(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:InputIcon icon="search">
                <twig:block name="addon"><twig:Tabler:InputIcon:Addon><twig:Tabler:Icon name="search" variant="primary" /></twig:Tabler:InputIcon:Addon></twig:block>
            </twig:Tabler:InputIcon>
            TWIG);

        self::assertHtmlSame(
            '<div class="input-icon"><input type="text" class="form-control"><span class="input-icon-addon"><i class="ti text-primary ti-search"></i></span></div>',
            $html,
        );
    }

    public function testAttributesMerge(): void
    {
        $html = $this->renderComponent('<twig:Tabler:InputIcon icon="search" class="mb-3" data-controller="search" />');

        self::assertHtmlSame(
            '<div class="input-icon mb-3" data-controller="search"><input type="text" class="form-control"><span class="input-icon-addon"><i class="ti ti-search"></i></span></div>',
            $html,
        );
    }
}
