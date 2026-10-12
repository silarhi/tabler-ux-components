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

final class ListGroupTest extends ComponentTestCase
{
    public function testAllInOneItems(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:ListGroup tag="nav" items="{{ items }}" />',
            ['items' => [
                ['label' => 'Profile', 'href' => '/profile', 'active' => true],
                ['label' => 'Billing', 'href' => '/billing', 'disabled' => true],
                ['label' => 'Alerts', 'variant' => 'warning'],
            ]],
        );

        self::assertHtmlSame(
            '<nav class="list-group">'
            . '<a href="/profile" class="list-group-item list-group-item-action active" aria-current="true">Profile</a>'
            . '<a class="list-group-item list-group-item-action disabled" aria-disabled="true" tabindex="-1">Billing</a>'
            . '<div class="list-group-item list-group-item-warning">Alerts</div>'
            . '</nav>',
            $html,
        );
    }

    public function testNumberedListItems(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:ListGroup tag="ol" numbered items="{{ items }}" />',
            ['items' => [['label' => 'Create an account'], ['label' => 'Confirm your email']]],
        );

        self::assertHtmlSame(
            '<ol class="list-group list-group-numbered">'
            . '<li class="list-group-item">Create an account</li>'
            . '<li class="list-group-item">Confirm your email</li>'
            . '</ol>',
            $html,
        );
    }

    public function testModifiers(): void
    {
        self::assertHtmlSame(
            '<div class="list-group list-group-flush list-group-hoverable list-group-transparent list-group-horizontal card-list-group extra"></div>',
            $this->renderComponent('<twig:Tabler:ListGroup flush hoverable transparent horizontal card class="extra" />'),
        );
        self::assertHtmlSame(
            '<ul class="list-group list-group-horizontal-md"></ul>',
            $this->renderComponent('<twig:Tabler:ListGroup tag="ul" horizontal="md" />'),
        );
    }

    public function testComposed(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:ListGroup flush hoverable>
                <twig:Tabler:ListGroup:Header>Today</twig:Tabler:ListGroup:Header>
                <twig:Tabler:ListGroup:Item>
                    Build failed
                    <twig:Tabler:ListGroup:Actions href="/fav" show aria-label="Add to favorites">*</twig:Tabler:ListGroup:Actions>
                </twig:Tabler:ListGroup:Item>
                <twig:Tabler:ListGroup:Item button active data-id="2">Pick</twig:Tabler:ListGroup:Item>
                <twig:Tabler:ListGroup:Item button disabled>Locked</twig:Tabler:ListGroup:Item>
                <twig:Tabler:ListGroup:Item href="/x" action="{{ false }}">Plain link</twig:Tabler:ListGroup:Item>
                <twig:Tabler:ListGroup:Item active disabled>Static</twig:Tabler:ListGroup:Item>
            </twig:Tabler:ListGroup>
            TWIG);

        self::assertHtmlSame(
            '<div class="list-group list-group-flush list-group-hoverable">'
            . '<div class="list-group-header">Today</div>'
            . '<div class="list-group-item">Build failed<a href="/fav" class="list-group-item-actions show" aria-label="Add to favorites">*</a></div>'
            . '<button type="button" class="list-group-item list-group-item-action active" aria-current="true" data-id="2">Pick</button>'
            . '<button type="button" class="list-group-item list-group-item-action disabled" disabled>Locked</button>'
            . '<a href="/x" class="list-group-item">Plain link</a>'
            . '<div class="list-group-item active disabled" aria-current="true" aria-disabled="true">Static</div>'
            . '</div>',
            $html,
        );
    }

    public function testListHeader(): void
    {
        self::assertHtmlSame(
            '<li class="list-group-header">Yesterday</li>',
            $this->renderComponent('<twig:Tabler:ListGroup:Header tag="li">Yesterday</twig:Tabler:ListGroup:Header>'),
        );
    }

    public function testHrefWinsOverButton(): void
    {
        // A link never gets the button-only type and disabled attributes
        self::assertHtmlSame(
            '<a href="/a" class="list-group-item list-group-item-action">A</a>',
            $this->renderComponent('<twig:Tabler:ListGroup:Item href="/a" button>A</twig:Tabler:ListGroup:Item>'),
        );
        self::assertHtmlSame(
            '<a class="list-group-item list-group-item-action disabled" aria-disabled="true" tabindex="-1">A</a>',
            $this->renderComponent('<twig:Tabler:ListGroup:Item href="/a" button disabled>A</twig:Tabler:ListGroup:Item>'),
        );
    }
}
