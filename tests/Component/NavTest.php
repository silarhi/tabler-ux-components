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

final class NavTest extends ComponentTestCase
{
    public function testDefaultNav(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Nav><twig:Tabler:Nav:Item href="/">Home</twig:Tabler:Nav:Item></twig:Tabler:Nav>');

        self::assertHtmlSame(
            '<ul class="nav"><li class="nav-item"><a class="nav-link" href="/">Home</a></li></ul>',
            $html,
        );
    }

    public function testPillsWithItemStates(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Nav variant="pills">
                <twig:Tabler:Nav:Item href="/" active>Active</twig:Tabler:Nav:Item>
                <twig:Tabler:Nav:Item href="/link">Link</twig:Tabler:Nav:Item>
                <twig:Tabler:Nav:Item disabled>Disabled</twig:Tabler:Nav:Item>
            </twig:Tabler:Nav>
            TWIG);

        self::assertHtmlSame(
            '<ul class="nav nav-pills">'
            . '<li class="nav-item"><a class="nav-link active" href="/" aria-current="page">Active</a></li>'
            . '<li class="nav-item"><a class="nav-link" href="/link">Link</a></li>'
            . '<li class="nav-item"><a class="nav-link disabled" aria-disabled="true">Disabled</a></li>'
            . '</ul>',
            $html,
        );
    }

    public function testVerticalUnderline(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Nav variant="underline" vertical><twig:Tabler:Nav:Item href="/">One</twig:Tabler:Nav:Item></twig:Tabler:Nav>');

        self::assertHtmlSame(
            '<ul class="nav nav-underline flex-column"><li class="nav-item"><a class="nav-link" href="/">One</a></li></ul>',
            $html,
        );
    }

    public function testFillForwardsExtraAttributes(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Nav fill class="mb-3" data-controller="nav"><twig:Tabler:Nav:Item href="/">One</twig:Tabler:Nav:Item></twig:Tabler:Nav>');

        self::assertHtmlSame(
            '<ul class="nav nav-fill mb-3" data-controller="nav"><li class="nav-item"><a class="nav-link" href="/">One</a></li></ul>',
            $html,
        );
    }
}
