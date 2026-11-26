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

    public function testAllInOneItems(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:Nav variant="tabs" class="mb-3" items="{{ items }}" />',
            ['items' => [
                ['label' => 'Profile', 'href' => '/settings', 'icon' => 'user', 'active' => true],
                ['label' => 'Notifications', 'href' => '/settings/notifications', 'badge' => 4],
                ['label' => 'Archived <old>', 'disabled' => true],
            ]],
        );

        self::assertHtmlSame(
            '<ul class="nav nav-tabs mb-3">'
            . '<li class="nav-item"><a class="nav-link active" href="/settings" aria-current="page"><span class="nav-link-icon"><i class="ti ti-user"></i></span>Profile</a></li>'
            . '<li class="nav-item"><a class="nav-link" href="/settings/notifications">Notifications <span class="badge text-bg-primary ms-2">4</span></a></li>'
            . '<li class="nav-item"><a class="nav-link disabled" aria-disabled="true">Archived &lt;old&gt;</a></li>'
            . '</ul>',
            $html,
        );
    }

    public function testOverflowWrapsTheNavAndKeepsItems(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Nav variant="tabs" overflow id="sections" items="{{ [{label: \'Overview\', href: \'/\', keep: true}, {label: \'Logs\', href: \'/logs\'}] }}" />');

        // Tabler 1.7 NavOverflow: a `.nav-overflow` wrapper with the data API around the `.nav`; attributes stay on the <ul>
        self::assertHtmlSame(
            '<div class="nav-overflow" data-bs-toggle="nav-overflow">'
            . '<ul class="nav nav-tabs" id="sections">'
            . '<li class="nav-item nav-overflow-keep"><a class="nav-link" href="/">Overview</a></li>'
            . '<li class="nav-item"><a class="nav-link" href="/logs">Logs</a></li>'
            . '</ul>'
            . '</div>',
            $html,
        );
    }

    public function testItemIconAndKeep(): void
    {
        self::assertHtmlSame(
            '<li class="nav-item nav-overflow-keep"><a class="nav-link" href="/" data-turbo="false"><span class="nav-link-icon"><i class="ti ti-home"></i></span>Home</a></li>',
            $this->renderComponent('<twig:Tabler:Nav:Item href="/" icon="home" keep data-turbo="false">Home</twig:Tabler:Nav:Item>'),
        );
    }

    public function testContentOverridesItems(): void
    {
        self::assertHtmlSame(
            '<ul class="nav"><li class="nav-item"><a class="nav-link" href="/own">Own</a></li></ul>',
            $this->renderComponent('<twig:Tabler:Nav items="{{ [{label: \'Ignored\'}] }}"><twig:Tabler:Nav:Item href="/own">Own</twig:Tabler:Nav:Item></twig:Tabler:Nav>'),
        );
    }
}
