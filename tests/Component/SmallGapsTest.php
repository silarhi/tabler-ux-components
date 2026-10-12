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
 * The last Tabler 1.6 classes: action buttons, card parts, stacked progress, table cells, plain lists.
 */
final class SmallGapsTest extends ComponentTestCase
{
    public function testActionButtonsGroup(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:ButtonActions>
                <twig:Tabler:Button appearance="action" href="/edit" aria-label="Edit"><i class="ti ti-edit"></i></twig:Tabler:Button>
                <twig:Tabler:Button appearance="action" aria-label="Delete"><i class="ti ti-trash"></i></twig:Tabler:Button>
            </twig:Tabler:ButtonActions>
            TWIG);

        self::assertHtmlSame(
            '<div class="btn-actions">'
            . '<a href="/edit" class="btn btn-action" role="button" aria-label="Edit"><i class="ti ti-edit"></i></a>'
            . '<button type="button" class="btn btn-action" aria-label="Delete"><i class="ti ti-trash"></i></button>'
            . '</div>',
            $html,
        );
    }

    public function testCardImageOverlayCoverAndCode(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Card>
                <twig:Tabler:Card:Img src="/desk.jpg" position="full" />
                <twig:Tabler:Card:ImgOverlay dark>Over</twig:Tabler:Card:ImgOverlay>
                <twig:Tabler:Card:Cover image="/books.jpg" blurred class="text-white">Reading</twig:Tabler:Card:Cover>
                <twig:Tabler:Card:Code><pre>code</pre></twig:Tabler:Card:Code>
            </twig:Tabler:Card>
            TWIG);

        self::assertHtmlSame(
            '<div class="card">'
            . '<img src="/desk.jpg" alt="" class="card-img">'
            . '<div class="card-img-overlay card-img-overlay-dark">Over</div>'
            . '<div class="card-cover card-cover-blurred text-white" style="background-image: url(/books.jpg)"><div class="position-relative">Reading</div></div>'
            . '<div class="card-code"><pre>code</pre></div>'
            . '</div>',
            $html,
        );
    }

    public function testCardTabsAndCardTable(): void
    {
        self::assertHtmlSame('<div class="card-tabs"></div>', $this->renderComponent('<twig:Tabler:Card:Tabs />'));
        self::assertHtmlSame(
            '<table class="table card-table"></table>',
            $this->renderComponent('<twig:Tabler:Table responsive="{{ false }}" card />'),
        );
    }

    public function testTableCell(): void
    {
        self::assertHtmlSame('<td data-label="Name">Jane</td>', $this->renderComponent('<twig:Tabler:Table:Cell label="Name">Jane</twig:Tabler:Table:Cell>'));
        self::assertHtmlSame(
            '<td class="td-truncate"><div class="text-truncate">Long</div></td>',
            $this->renderComponent('<twig:Tabler:Table:Cell truncate>Long</twig:Tabler:Table:Cell>'),
        );
    }

    public function testProgressStacked(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Progress:Stacked separated>
                <twig:Tabler:Progress:Segment value="15" label="Photos" />
                <twig:Tabler:Progress:Segment value="30" variant="success" striped />
            </twig:Tabler:Progress:Stacked>
            TWIG);

        self::assertHtmlSame(
            '<div class="progress-stacked progress-separated">'
            . '<div class="progress" style="width: 15%" role="progressbar" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100" aria-label="Photos"><div class="progress-bar bg-primary"></div></div>'
            . '<div class="progress" style="width: 30%" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" aria-label="30% of total"><div class="progress-bar bg-success progress-bar-striped"></div></div>'
            . '</div>',
            $html,
        );
    }

    public function testDropdownIndicator(): void
    {
        self::assertHtmlSame(
            '<span class="dropdown-item-indicator"><span class="avatar avatar-xs">FR</span></span>',
            $this->renderComponent('<twig:Tabler:Dropdown:Indicator><span class="avatar avatar-xs">FR</span></twig:Tabler:Dropdown:Indicator>'),
        );
    }

    public function testLists(): void
    {
        self::assertHtmlSame(
            '<ul class="list-separated"><li>One</li></ul>',
            $this->renderComponent('<twig:Tabler:List separated><twig:Tabler:List:Item>One</twig:Tabler:List:Item></twig:Tabler:List>'),
        );
        self::assertHtmlSame(
            '<ol class="list-inline list-inline-dots"><li class="list-inline-item">Docs</li></ol>',
            $this->renderComponent('<twig:Tabler:List inline dots ordered><twig:Tabler:List:Item inline>Docs</twig:Tabler:List:Item></twig:Tabler:List>'),
        );
    }

    public function testListItemsFollowTheInlineOfTheirList(): void
    {
        self::assertHtmlSame(
            '<ul class="list-inline list-inline-dots"><li class="list-inline-item">Docs</li><li class="list-inline-item">License</li></ul>',
            $this->renderComponent('<twig:Tabler:List inline dots>{% for name in ["Docs", "License"] %}<twig:Tabler:List:Item>{{ name }}</twig:Tabler:List:Item>{% endfor %}</twig:Tabler:List>'),
        );
        // An explicit `inline` wins over the list's
        self::assertHtmlSame(
            '<ul class="list-inline"><li class="list-inline-item">Docs</li><li>Below</li></ul>',
            $this->renderComponent('<twig:Tabler:List inline><twig:Tabler:List:Item>Docs</twig:Tabler:List:Item><twig:Tabler:List:Item inline="{{ false }}">Below</twig:Tabler:List:Item></twig:Tabler:List>'),
        );
        self::assertHtmlSame(
            '<li class="list-inline-item">Docs</li>',
            $this->renderComponent('<twig:Tabler:List:Item inline>Docs</twig:Tabler:List:Item>'),
        );
        self::assertHtmlSame('<li>Docs</li>', $this->renderComponent('<twig:Tabler:List:Item>Docs</twig:Tabler:List:Item>'));
    }

    public function testNestedListResetsTheInlineOfItsItems(): void
    {
        self::assertHtmlSame(
            '<ul class="list-inline"><li class="list-inline-item">Docs<ul class="list-unstyled"><li>Install</li></ul></li></ul>',
            $this->renderComponent('<twig:Tabler:List inline><twig:Tabler:List:Item>Docs<twig:Tabler:List unstyled><twig:Tabler:List:Item>Install</twig:Tabler:List:Item></twig:Tabler:List></twig:Tabler:List:Item></twig:Tabler:List>'),
        );
    }

    public function testAvatarCover(): void
    {
        self::assertHtmlSame('<span class="avatar avatar-xl avatar-cover">JL</span>', $this->renderComponent('<twig:Tabler:Avatar size="xl" cover>JL</twig:Tabler:Avatar>'));
    }

    public function testCoverKeepsAUserStyleAndItsContentAboveTheOverlay(): void
    {
        self::assertHtmlSame(
            '<div class="card-cover" style="background-image: url(/c.jpg); height: 6rem"><div class="position-relative"><h3>Hi</h3></div></div>',
            $this->renderComponent('<twig:Tabler:Card:Cover image="/c.jpg" style="height: 6rem"><h3>Hi</h3></twig:Tabler:Card:Cover>'),
        );
    }

    public function testSegmentFillHasNoRoleAndKeepsAUserStyle(): void
    {
        // The segment is the progressbar: a second, unnamed one inside it would be announced twice
        self::assertHtmlSame(
            '<div class="progress" style="width: 30%; transition: none" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" aria-label="30% of total">'
            . '<div class="progress-bar bg-success progress-bar-striped progress-bar-animated"></div></div>',
            $this->renderComponent('<twig:Tabler:Progress:Segment value="30" variant="success" animated style="transition: none" />'),
        );
    }
}
