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
}
