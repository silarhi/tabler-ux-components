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

/**
 * The Tabler 1.7 list group additions: item slots, sizes, selectable and nested items.
 */
final class ListGroupSlotsTest extends ComponentTestCase
{
    public function testItemSlotsAllInOne(): void
    {
        self::assertHtmlSame(
            '<div class="list-group-item">'
            . '<span class="list-group-item-media"><i class="ti ti-user"></i></span>'
            . '<span class="list-group-item-content"><span class="list-group-item-title">Paweł Kuna</span><span class="list-group-item-description">UI Designer</span></span>'
            . '<span class="list-group-item-meta">2 h</span>'
            . '</div>',
            $this->renderComponent('<twig:Tabler:ListGroup:Item icon="user" title="Paweł Kuna" description="UI Designer" meta="2 h" />'),
        );
    }

    public function testSlotsAreSpansInALinkButtonOrLabel(): void
    {
        self::assertHtmlSame(
            '<a href="/users/1" class="list-group-item list-group-item-action">'
            . '<span class="list-group-item-content"><span class="list-group-item-title">Paweł Kuna</span></span>'
            . '<span class="list-group-item-meta">2 h</span>'
            . '</a>',
            $this->renderComponent('<twig:Tabler:ListGroup:Item href="/users/1" title="Paweł Kuna" meta="2 h" />'),
        );
        self::assertHtmlSame(
            '<label class="list-group-item">'
            . '<span class="list-group-item-content"><span class="list-group-item-title">Email</span><span class="list-group-item-description">Every morning</span></span>'
            . '</label>',
            $this->renderComponent('<twig:Tabler:ListGroup:Item tag="label" title="Email" description="Every morning" />'),
        );
    }

    public function testComposedSlots(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:ListGroup:Item>
                <twig:Tabler:ListGroup:Media><span class="avatar"></span></twig:Tabler:ListGroup:Media>
                <twig:Tabler:ListGroup:Content>
                    <twig:Tabler:ListGroup:Title href="/builds/42">Build failed</twig:Tabler:ListGroup:Title>
                    <twig:Tabler:ListGroup:Description class="text-wrap">The last deploy did not finish</twig:Tabler:ListGroup:Description>
                </twig:Tabler:ListGroup:Content>
                <twig:Tabler:ListGroup:Meta>3 d</twig:Tabler:ListGroup:Meta>
                <twig:Tabler:ListGroup:Actions tag="div"><button type="button" class="btn btn-sm">Follow</button></twig:Tabler:ListGroup:Actions>
            </twig:Tabler:ListGroup:Item>
            TWIG);

        self::assertHtmlSame(
            '<div class="list-group-item">'
            . '<span class="list-group-item-media"><span class="avatar"></span></span>'
            . '<span class="list-group-item-content">'
            . '<a href="/builds/42" class="list-group-item-title">Build failed</a>'
            . '<span class="list-group-item-description text-wrap">The last deploy did not finish</span>'
            . '</span>'
            . '<span class="list-group-item-meta">3 d</span>'
            . '<div class="list-group-item-actions"><button type="button" class="btn btn-sm">Follow</button></div>'
            . '</div>',
            $html,
        );
    }

    public function testComposedSlotsInAButtonItem(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:ListGroup:Item button>
                <twig:Tabler:ListGroup:Media>M</twig:Tabler:ListGroup:Media>
                <twig:Tabler:ListGroup:Content title="Projects" />
                <twig:Tabler:ListGroup:Meta>2</twig:Tabler:ListGroup:Meta>
            </twig:Tabler:ListGroup:Item>
            TWIG);

        self::assertHtmlSame(
            '<button type="button" class="list-group-item list-group-item-action">'
            . '<span class="list-group-item-media">M</span>'
            . '<span class="list-group-item-content"><span class="list-group-item-title">Projects</span></span>'
            . '<span class="list-group-item-meta">2</span>'
            . '</button>',
            $html,
        );
    }

    public function testItemSlotBlocks(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:ListGroup:Item tag="label" title="Push">
                <twig:block name="media"><twig:Tabler:ListGroup:Media><twig:Tabler:ListGroup:Check name="push" checked /></twig:Tabler:ListGroup:Media></twig:block>
                <twig:block name="actions"><twig:Tabler:ListGroup:Actions tag="span">On</twig:Tabler:ListGroup:Actions></twig:block>
            </twig:Tabler:ListGroup:Item>
            TWIG);

        self::assertHtmlSame(
            '<label class="list-group-item">'
            . '<span class="list-group-item-media"><input type="checkbox" class="form-check-input list-group-selectable-check m-0" name="push" checked></span>'
            . '<span class="list-group-item-content"><span class="list-group-item-title">Push</span></span>'
            . '<span class="list-group-item-actions">On</span>'
            . '</label>',
            $html,
        );
    }

    public function testItemsWithSlots(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:ListGroup tag="ul" items="{{ items }}" />',
            ['items' => [
                ['title' => 'Paweł Kuna', 'description' => 'UI Designer', 'icon' => 'user'],
                ['label' => 'Plain'],
            ]],
        );

        self::assertHtmlSame(
            '<ul class="list-group">'
            . '<li class="list-group-item"><span class="list-group-item-media"><i class="ti ti-user"></i></span>'
            . '<span class="list-group-item-content"><span class="list-group-item-title">Paweł Kuna</span><span class="list-group-item-description">UI Designer</span></span></li>'
            . '<li class="list-group-item">Plain</li>'
            . '</ul>',
            $html,
        );
    }

    public function testSizesAndSelectable(): void
    {
        self::assertHtmlSame(
            '<div class="list-group list-group-sm"></div>',
            $this->renderComponent('<twig:Tabler:ListGroup size="sm" />'),
        );
        self::assertHtmlSame(
            '<div class="list-group list-group-lg list-group-selectable extra"></div>',
            $this->renderComponent('<twig:Tabler:ListGroup size="lg" selectable class="extra" />'),
        );
    }

    public function testCheck(): void
    {
        self::assertHtmlSame(
            '<input type="radio" class="form-check-input list-group-selectable-check m-0 me-2" name="plan" value="pro">',
            $this->renderComponent('<twig:Tabler:ListGroup:Check type="radio" name="plan" value="pro" class="me-2" />'),
        );
    }

    public function testNested(): void
    {
        self::assertHtmlSame(
            '<div class="list-group-nested"><a href="/a" class="list-group-item list-group-item-action">A</a></div>',
            $this->renderComponent('<twig:Tabler:ListGroup:Nested><twig:Tabler:ListGroup:Item href="/a" label="A" /></twig:Tabler:ListGroup:Nested>'),
        );
        self::assertHtmlSame(
            '<div class="list-group-nested collapse show extra" id="projects"></div>',
            $this->renderComponent('<twig:Tabler:ListGroup:Nested collapse show class="extra" id="projects" />'),
        );
        self::assertHtmlSame(
            '<div class="list-group-nested"></div>',
            $this->renderComponent('<twig:Tabler:ListGroup:Nested show />'),
            '`show` needs `collapse`',
        );
    }

    public function testActionsStaysALinkByDefault(): void
    {
        self::assertHtmlSame(
            '<a href="#" class="list-group-item-actions" aria-label="Star"></a>',
            $this->renderComponent('<twig:Tabler:ListGroup:Actions aria-label="Star" />'),
        );
    }

    public function testSlotTagOverride(): void
    {
        self::assertHtmlSame(
            '<div class="list-group-item-title extra">T</div><div class="list-group-item-description">D</div><div class="list-group-item-media">M</div><div class="list-group-item-meta">2 h</div><div class="list-group-item-content"></div>',
            $this->renderComponent('<twig:Tabler:ListGroup:Title tag="div" class="extra">T</twig:Tabler:ListGroup:Title><twig:Tabler:ListGroup:Description tag="div">D</twig:Tabler:ListGroup:Description><twig:Tabler:ListGroup:Media tag="div">M</twig:Tabler:ListGroup:Media><twig:Tabler:ListGroup:Meta tag="div">2 h</twig:Tabler:ListGroup:Meta><twig:Tabler:ListGroup:Content tag="div" />'),
        );
    }
}
