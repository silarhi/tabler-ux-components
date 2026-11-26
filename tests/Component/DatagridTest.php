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

final class DatagridTest extends ComponentTestCase
{
    public function testHorizontal(): void
    {
        self::assertHtmlSame(
            '<div class="datagrid datagrid-horizontal"><div class="datagrid-item"><div class="datagrid-title">Port</div><div class="datagrid-content">3306</div></div></div>',
            $this->renderComponent('<twig:Tabler:Datagrid horizontal><twig:Tabler:Datagrid:Item title="Port" text="3306" /></twig:Tabler:Datagrid>'),
        );
    }

    #[DataProvider('provideCols')]
    public function testCols(string $cols): void
    {
        self::assertHtmlSame(
            sprintf('<div class="datagrid datagrid-cols-%s"></div>', $cols),
            $this->renderComponent(sprintf('<twig:Tabler:Datagrid cols="%s" />', $cols)),
        );
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideCols(): iterable
    {
        foreach (['1', '2', '3', '4'] as $cols) {
            yield $cols => [$cols];
        }
    }

    public function testIntegerColsAndAttributesMerge(): void
    {
        self::assertHtmlSame(
            '<div class="datagrid datagrid-horizontal datagrid-cols-2 mb-3" id="details"></div>',
            $this->renderComponent('<twig:Tabler:Datagrid horizontal cols="{{ 2 }}" class="mb-3" id="details" />'),
        );
    }
}
