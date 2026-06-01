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

final class DropdownTest extends ComponentTestCase
{
    public function testFullDropdown(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Dropdown>
                <twig:Tabler:Dropdown:Toggle variant="primary">Menu</twig:Tabler:Dropdown:Toggle>
                <twig:Tabler:Dropdown:Menu>
                    <twig:Tabler:Dropdown:Header>Actions</twig:Tabler:Dropdown:Header>
                    <twig:Tabler:Dropdown:Item href="/edit">Edit</twig:Tabler:Dropdown:Item>
                    <twig:Tabler:Dropdown:Divider />
                    <twig:Tabler:Dropdown:Item href="/delete" disabled>Delete</twig:Tabler:Dropdown:Item>
                </twig:Tabler:Dropdown:Menu>
            </twig:Tabler:Dropdown>
            TWIG);

        self::assertHtmlSame(
            '<div class="dropdown">'
            . '<a href="#" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Menu</a>'
            . '<div class="dropdown-menu">'
            . '<div class="dropdown-header">Actions</div>'
            . '<a href="/edit" class="dropdown-item">Edit</a>'
            . '<div class="dropdown-divider"></div>'
            . '<a href="/delete" class="dropdown-item disabled" aria-disabled="true">Delete</a>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testToggleNoCaretAndMenuEnd(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Dropdown>
                <twig:Tabler:Dropdown:Toggle noCaret>•••</twig:Tabler:Dropdown:Toggle>
                <twig:Tabler:Dropdown:Menu end>
                    <twig:Tabler:Dropdown:Item href="#" active>Selected</twig:Tabler:Dropdown:Item>
                </twig:Tabler:Dropdown:Menu>
            </twig:Tabler:Dropdown>
            TWIG);

        self::assertHtmlSame(
            '<div class="dropdown">'
            . '<a href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">•••</a>'
            . '<div class="dropdown-menu dropdown-menu-end">'
            . '<a href="#" class="dropdown-item active">Selected</a>'
            . '</div>'
            . '</div>',
            $html,
        );
    }
}
