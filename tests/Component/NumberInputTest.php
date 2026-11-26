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

final class NumberInputTest extends ComponentTestCase
{
    private const DECREMENT = '<button type="button" class="btn btn-icon" data-bs-number-input-action="decrement" aria-label="Decrease"></button>';
    private const INCREMENT = '<button type="button" class="btn btn-icon" data-bs-number-input-action="increment" aria-label="Increase"></button>';

    public function testAllInOne(): void
    {
        $html = $this->renderComponent('<twig:Tabler:NumberInput name="quantity" id="quantity" value="1" min="1" max="99" step="1" label="Quantity" />');

        self::assertHtmlSame(
            '<div class="number-input" data-bs-toggle="number-input">'
            . self::DECREMENT
            . '<input type="text" class="form-control" name="quantity" id="quantity" value="1" min="1" max="99" step="1" aria-label="Quantity">'
            . self::INCREMENT
            . '</div>',
            $html,
        );
    }

    public function testBareInput(): void
    {
        self::assertHtmlSame(
            '<div class="number-input" data-bs-toggle="number-input">' . self::DECREMENT . '<input type="text" class="form-control">' . self::INCREMENT . '</div>',
            $this->renderComponent('<twig:Tabler:NumberInput />'),
        );
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function sizeProvider(): iterable
    {
        yield 'sm' => ['sm', 'number-input number-input-sm'];
        yield 'md' => ['md', 'number-input'];
        yield 'lg' => ['lg', 'number-input number-input-lg'];
    }

    #[DataProvider('sizeProvider')]
    public function testSizes(string $size, string $class): void
    {
        $html = $this->renderComponent('<twig:Tabler:NumberInput size="{{ size }}" />', ['size' => $size]);

        self::assertStringStartsWith(sprintf('<div class="%s" data-bs-toggle="number-input"', $class), $html);
    }

    public function testDisabledNumberWithoutRepeat(): void
    {
        $html = $this->renderComponent('<twig:Tabler:NumberInput type="number" value="3" disabled repeat="{{ false }}" decrementLabel="Fewer" incrementLabel="More" />');

        self::assertHtmlSame(
            '<div class="number-input" data-bs-toggle="number-input" data-bs-repeat="false">'
            . '<button type="button" class="btn btn-icon" data-bs-number-input-action="decrement" aria-label="Fewer" disabled></button>'
            . '<input type="number" class="form-control" value="3" disabled>'
            . '<button type="button" class="btn btn-icon" data-bs-number-input-action="increment" aria-label="More" disabled></button>'
            . '</div>',
            $html,
        );
    }

    public function testReadonly(): void
    {
        self::assertStringContainsString(
            '<input type="text" class="form-control" value="2" readonly',
            $this->renderComponent('<twig:Tabler:NumberInput value="2" readonly />'),
        );
    }

    public function testComposed(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:NumberInput>
                <twig:Tabler:NumberInput:Button action="decrement" label="Fewer"><twig:Tabler:Icon name="chevron-down" /></twig:Tabler:NumberInput:Button>
                <twig:Tabler:NumberInput:Input name="seats" min="0" class="is-invalid" form="cart" style="--tblr-number-input-input-width: 6rem" />
                <twig:Tabler:NumberInput:Button action="increment" class="btn-ghost-primary"><twig:Tabler:Icon name="chevron-up" /></twig:Tabler:NumberInput:Button>
            </twig:Tabler:NumberInput>
            TWIG);

        self::assertHtmlSame(
            '<div class="number-input" data-bs-toggle="number-input">'
            . '<button type="button" class="btn btn-icon" data-bs-number-input-action="decrement" aria-label="Fewer"><i class="ti ti-chevron-down"></i></button>'
            . '<input type="text" class="form-control is-invalid" name="seats" min="0" form="cart" style="--tblr-number-input-input-width: 6rem">'
            . '<button type="button" class="btn btn-icon btn-ghost-primary" data-bs-number-input-action="increment" aria-label="Increase"><i class="ti ti-chevron-up"></i></button>'
            . '</div>',
            $html,
        );
    }

    public function testInputBlock(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:NumberInput>
                <twig:block name="input"><input type="text" class="form-control" name="custom"></twig:block>
            </twig:Tabler:NumberInput>
            TWIG);

        self::assertHtmlSame('<div class="number-input" data-bs-toggle="number-input">' . self::DECREMENT . '<input type="text" class="form-control" name="custom">' . self::INCREMENT . '</div>', $html);
    }

    public function testAttributesMerge(): void
    {
        $html = $this->renderComponent('<twig:Tabler:NumberInput class="mb-3" data-controller="cart" />');

        self::assertHtmlSame(
            '<div class="number-input mb-3" data-bs-toggle="number-input" data-controller="cart">' . self::DECREMENT . '<input type="text" class="form-control">' . self::INCREMENT . '</div>',
            $html,
        );
    }
}
