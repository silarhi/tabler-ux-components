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

final class BreadcrumbTest extends ComponentTestCase
{
    public function testTrail(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Breadcrumb>
                <twig:Tabler:Breadcrumb:Item href="/">Home</twig:Tabler:Breadcrumb:Item>
                <twig:Tabler:Breadcrumb:Item href="/library">Library</twig:Tabler:Breadcrumb:Item>
                <twig:Tabler:Breadcrumb:Item active>Data</twig:Tabler:Breadcrumb:Item>
            </twig:Tabler:Breadcrumb>
            TWIG);

        self::assertHtmlSame(
            '<nav aria-label="breadcrumbs"><ol class="breadcrumb">'
            . '<li class="breadcrumb-item"><a href="/">Home</a></li>'
            . '<li class="breadcrumb-item"><a href="/library">Library</a></li>'
            . '<li class="breadcrumb-item active" aria-current="page">Data</li>'
            . '</ol></nav>',
            $html,
        );
    }

    public function testSeparatorAndMuted(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Breadcrumb separator="dots" muted>
                <twig:Tabler:Breadcrumb:Item active>Only</twig:Tabler:Breadcrumb:Item>
            </twig:Tabler:Breadcrumb>
            TWIG);

        self::assertHtmlSame(
            '<nav aria-label="breadcrumbs"><ol class="breadcrumb breadcrumb-dots breadcrumb-muted">'
            . '<li class="breadcrumb-item active" aria-current="page">Only</li>'
            . '</ol></nav>',
            $html,
        );
    }

    public function testAllInOneItemsMakeTheLastOneActive(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:Breadcrumb items="{{ items }}" separator="arrows" class="mb-3" />',
            ['items' => [
                ['label' => 'Home', 'href' => '/', 'icon' => 'home'],
                ['label' => 'Library & co', 'href' => '/library'],
                ['label' => 'Data', 'href' => '/library/data'],
            ]],
        );

        // The last crumb is the current page: no link, even with an href
        self::assertHtmlSame(
            '<nav aria-label="breadcrumbs"><ol class="breadcrumb breadcrumb-arrows mb-3">'
            . '<li class="breadcrumb-item"><a href="/"><i class="ti ti-home me-1"></i>Home</a></li>'
            . '<li class="breadcrumb-item"><a href="/library">Library &amp; co</a></li>'
            . '<li class="breadcrumb-item active" aria-current="page">Data</li>'
            . '</ol></nav>',
            $html,
        );
    }

    public function testItemsExplicitActiveWins(): void
    {
        // Once an entry sets `active`, the last crumb is no longer active by default
        self::assertHtmlSame(
            '<nav aria-label="breadcrumbs"><ol class="breadcrumb">'
            . '<li class="breadcrumb-item active" aria-current="page">Home</li>'
            . '<li class="breadcrumb-item"><a href="/next">Next</a></li>'
            . '</ol></nav>',
            $this->renderComponent('<twig:Tabler:Breadcrumb items="{{ [{label: \'Home\', href: \'/\', active: true}, {label: \'Next\', href: \'/next\'}] }}" />'),
        );
        self::assertStringNotContainsString('aria-current', $this->renderComponent('<twig:Tabler:Breadcrumb items="{{ [{label: \'Home\', href: \'/\'}, {label: \'Next\', href: \'/next\', active: false}] }}" />'));
    }

    public function testItemIconWithoutLink(): void
    {
        self::assertHtmlSame(
            '<li class="breadcrumb-item active" aria-current="page"><i class="ti ti-folder me-1"></i>Data</li>',
            $this->renderComponent('<twig:Tabler:Breadcrumb:Item icon="folder" active>Data</twig:Tabler:Breadcrumb:Item>'),
        );
    }

    public function testContentOverridesItems(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Breadcrumb items="{{ [{label: \'Ignored\'}] }}"><twig:Tabler:Breadcrumb:Item active>Own</twig:Tabler:Breadcrumb:Item></twig:Tabler:Breadcrumb>');

        self::assertHtmlSame('<nav aria-label="breadcrumbs"><ol class="breadcrumb"><li class="breadcrumb-item active" aria-current="page">Own</li></ol></nav>', $html);
    }
}
