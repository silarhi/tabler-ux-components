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

final class PaginationTest extends ComponentTestCase
{
    public function testPages(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Pagination>
                <twig:Tabler:Pagination:Item disabled>«</twig:Tabler:Pagination:Item>
                <twig:Tabler:Pagination:Item href="?page=1">1</twig:Tabler:Pagination:Item>
                <twig:Tabler:Pagination:Item href="?page=2" active>2</twig:Tabler:Pagination:Item>
            </twig:Tabler:Pagination>
            TWIG);

        self::assertHtmlSame(
            '<ul class="pagination">'
            . '<li class="page-item disabled"><span class="page-link">«</span></li>'
            . '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>'
            . '<li class="page-item active" aria-current="page"><a class="page-link" href="?page=2">2</a></li>'
            . '</ul>',
            $html,
        );
    }

    public function testOutlineCircle(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Pagination outline circle>
                <twig:Tabler:Pagination:Item href="#">1</twig:Tabler:Pagination:Item>
            </twig:Tabler:Pagination>
            TWIG);

        self::assertHtmlSame(
            '<ul class="pagination pagination-outline pagination-circle">'
            . '<li class="page-item"><a class="page-link" href="#">1</a></li>'
            . '</ul>',
            $html,
        );
    }
}
