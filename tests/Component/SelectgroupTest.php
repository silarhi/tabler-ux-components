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

final class SelectgroupTest extends ComponentTestCase
{
    public function testAllInOne(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:Selectgroup name="status" items="{{ [
                {value: 'all', label: 'All', checked: true},
                {value: 'open', label: 'Open', icon: 'circle-dot'},
                {value: 'closed', label: 'Closed', disabled: true},
            ] }}" />
            TWIG);

        self::assertHtmlSame(
            '<div class="form-selectgroup">'
            . '<label class="form-selectgroup-item"><input type="radio" name="status" value="all" class="form-selectgroup-input" checked><span class="form-selectgroup-label">All</span></label>'
            . '<label class="form-selectgroup-item"><input type="radio" name="status" value="open" class="form-selectgroup-input"><span class="form-selectgroup-label"><i class="ti ti-circle-dot me-1"></i>Open</span></label>'
            . '<label class="form-selectgroup-item"><input type="radio" name="status" value="closed" class="form-selectgroup-input" disabled><span class="form-selectgroup-label">Closed</span></label>'
            . '</div>',
            $html,
        );
    }

    public function testItemInputAttributes(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:Selectgroup:Item name="plan" value="pro" label="Pro" class="w-100" title="Pro plan" input:id="plan-pro" input:data-x="1" />',
        );

        self::assertHtmlSame(
            '<label class="form-selectgroup-item w-100" title="Pro plan">'
            . '<input type="radio" name="plan" value="pro" class="form-selectgroup-input" id="plan-pro" data-x="1">'
            . '<span class="form-selectgroup-label">Pro</span>'
            . '</label>',
            $html,
        );
    }

    public function testCheckboxIconOnly(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:Selectgroup name="weather[]" type="checkbox" items="{{ [{value: 'sun', label: 'Sunny', icon: 'sun', iconOnly: true}] }}" />
            TWIG);

        self::assertHtmlSame(
            '<div class="form-selectgroup">'
            . '<label class="form-selectgroup-item"><input type="checkbox" name="weather[]" value="sun" class="form-selectgroup-input" aria-label="Sunny"><span class="form-selectgroup-label"><i class="ti ti-sun"></i></span></label>'
            . '</div>',
            $html,
        );
    }

    /**
     * @return iterable<string, array{string|null, bool, string}>
     */
    public static function variantProvider(): iterable
    {
        yield 'default' => [null, false, 'form-selectgroup'];
        yield 'pills' => ['pills', false, 'form-selectgroup form-selectgroup-pills'];
        yield 'boxes' => ['boxes', false, 'form-selectgroup form-selectgroup-boxes'];
        yield 'vertical' => [null, true, 'form-selectgroup form-selectgroup-vertical'];
    }

    #[DataProvider('variantProvider')]
    public function testVariants(?string $variant, bool $vertical, string $class): void
    {
        $html = $this->renderComponent('<twig:Tabler:Selectgroup variant="{{ variant }}" vertical="{{ vertical }}" />', ['variant' => $variant, 'vertical' => $vertical]);

        self::assertHtmlSame(sprintf('<div class="%s"></div>', $class), $html);
    }

    public function testBoxesHaveACheck(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Selectgroup name="plan" variant="boxes" items="{{ [{value: \'pro\', label: \'Pro\'}] }}" />');

        self::assertHtmlSame(
            '<div class="form-selectgroup form-selectgroup-boxes">'
            . '<label class="form-selectgroup-item"><input type="radio" name="plan" value="pro" class="form-selectgroup-input">'
            . '<span class="form-selectgroup-label d-flex align-items-center p-3"><span class="me-3"><span class="form-selectgroup-check"></span></span><span>Pro</span></span>'
            . '</label>'
            . '</div>',
            $html,
        );
    }

    public function testComposed(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:Selectgroup variant="boxes" vertical class="w-100">
                <twig:Tabler:Selectgroup:Item name="plan" value="pro" check checked class="flex-fill">
                    <strong>Pro</strong> — $29 per month
                </twig:Tabler:Selectgroup:Item>
            </twig:Tabler:Selectgroup>
            TWIG);

        self::assertHtmlSame(
            '<div class="form-selectgroup form-selectgroup-boxes form-selectgroup-vertical w-100">'
            . '<label class="form-selectgroup-item flex-fill"><input type="radio" name="plan" value="pro" class="form-selectgroup-input" checked>'
            . '<span class="form-selectgroup-label d-flex align-items-center p-3"><span class="me-3"><span class="form-selectgroup-check"></span></span><span><strong>Pro</strong> — $29 per month</span></span>'
            . '</label>'
            . '</div>',
            $html,
        );
    }

    public function testItemIconBlock(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:Selectgroup:Item name="view" value="grid" label="Grid" data-view="grid">
                <twig:block name="icon"><twig:Tabler:Icon name="layout-grid" variant="primary" class="me-1" /></twig:block>
            </twig:Tabler:Selectgroup:Item>
            TWIG);

        self::assertHtmlSame(
            '<label class="form-selectgroup-item" data-view="grid"><input type="radio" name="view" value="grid" class="form-selectgroup-input"><span class="form-selectgroup-label"><i class="ti text-primary ti-layout-grid me-1"></i>Grid</span></label>',
            $html,
        );
    }

    public function testLabelAndCheckAlone(): void
    {
        self::assertHtmlSame(
            '<span class="form-selectgroup-label px-2">HTML</span>',
            $this->renderComponent('<twig:Tabler:Selectgroup:Label class="px-2">HTML</twig:Tabler:Selectgroup:Label>'),
        );
        self::assertHtmlSame(
            '<span class="form-selectgroup-check form-selectgroup-check-floated"></span>',
            $this->renderComponent('<twig:Tabler:Selectgroup:Check class="form-selectgroup-check-floated" />'),
        );
    }

    public function testAttributesMerge(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Selectgroup variant="pills" class="mb-3" aria-label="Status" />');

        self::assertHtmlSame('<div class="form-selectgroup form-selectgroup-pills mb-3" aria-label="Status"></div>', $html);
    }
}
