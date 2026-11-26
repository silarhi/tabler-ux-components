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
            . '<button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Menu</button>'
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
            . '<button type="button" class="btn" data-bs-toggle="dropdown" aria-expanded="false">•••</button>'
            . '<div class="dropdown-menu dropdown-menu-end">'
            . '<a href="#" class="dropdown-item active">Selected</a>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testToggleIsAButtonThatDoesNotSubmitForms(): void
    {
        self::assertHtmlSame(
            '<form><button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="actions">Actions</button></form>',
            $this->renderComponent('<form><twig:Tabler:Dropdown:Toggle id="actions">Actions</twig:Tabler:Dropdown:Toggle></form>'),
        );
    }

    public function testItemTagForCheckboxesAndButtons(): void
    {
        // A checkbox inside an <a> is invalid HTML: render the item as a <label>
        self::assertHtmlSame(
            '<label class="dropdown-item"><span class="dropdown-item-indicator"><input type="checkbox"></span>Archived</label>',
            $this->renderComponent('<twig:Tabler:Dropdown:Item tag="label" href="/ignored"><twig:Tabler:Dropdown:Indicator><input type="checkbox"></twig:Tabler:Dropdown:Indicator>Archived</twig:Tabler:Dropdown:Item>'),
        );
        self::assertHtmlSame(
            '<button type="button" class="dropdown-item disabled" disabled>Retry</button>',
            $this->renderComponent('<twig:Tabler:Dropdown:Item tag="button" disabled>Retry</twig:Tabler:Dropdown:Item>'),
        );
    }

    public function testAllInOne(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:Dropdown label="Actions" icon="settings" variant="primary" direction="up" class="ms-auto" items="{{ items }}" />',
            ['items' => [
                ['header' => 'Invoice #1042'],
                ['label' => 'Edit', 'href' => '/edit', 'icon' => 'pencil', 'active' => true],
                ['label' => 'Comments', 'href' => '/comments', 'badge' => 3],
                ['divider' => true],
                ['label' => 'Delete', 'disabled' => true],
            ]],
        );

        self::assertHtmlSame(
            '<div class="dropdown dropup ms-auto">'
            . '<button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti ti-settings icon"></i>Actions</button>'
            . '<div class="dropdown-menu">'
            . '<div class="dropdown-header">Invoice #1042</div>'
            . '<a href="/edit" class="dropdown-item active"><i class="ti ti-pencil dropdown-item-icon"></i>Edit</a>'
            . '<a href="/comments" class="dropdown-item">Comments <span class="badge text-bg-primary ms-auto">3</span></a>'
            . '<div class="dropdown-divider"></div>'
            . '<a href="#" class="dropdown-item disabled" aria-disabled="true">Delete</a>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testAllInOneDefaults(): void
    {
        // Without `variant`, the toggle is a plain .btn; without `items`, there is no menu
        self::assertHtmlSame(
            '<div class="dropdown"><button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Menu</button></div>',
            $this->renderComponent('<twig:Tabler:Dropdown label="Menu" />'),
        );
        self::assertHtmlSame('<div class="dropdown"></div>', $this->renderComponent('<twig:Tabler:Dropdown />'));
    }

    public function testMenuItemsEscapeLabels(): void
    {
        self::assertHtmlSame(
            '<div class="dropdown-menu dropdown-menu-end"><div class="dropdown-header">&lt;b&gt;</div><a href="#" class="dropdown-item">&lt;i&gt;</a></div>',
            $this->renderComponent('<twig:Tabler:Dropdown:Menu end items="{{ [{header: \'<b>\'}, {label: \'<i>\'}] }}" />'),
        );
    }

    public function testToggleAndMenuBlocksOverride(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Dropdown label="Actions" items="{{ [{label: 'Edit', href: '/edit'}] }}">
                <twig:block name="menu">
                    <twig:Tabler:Dropdown:Menu end items="{{ [{label: 'Own', href: '/own'}] }}" />
                </twig:block>
            </twig:Tabler:Dropdown>
            TWIG);

        // The `toggle` block keeps its default
        self::assertHtmlSame(
            '<div class="dropdown">'
            . '<button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Actions</button>'
            . '<div class="dropdown-menu dropdown-menu-end"><a href="/own" class="dropdown-item">Own</a></div>'
            . '</div>',
            $html,
        );
    }
}
