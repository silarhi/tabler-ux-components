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
 * Tabler 1.6 modifiers on navigation, feedback and layout components.
 */
final class ModifiersTest extends ComponentTestCase
{
    public function testTabsStyles(): void
    {
        self::assertHtmlSame(
            '<ul class="nav nav-underline nav-bordered nav-fill" data-bs-toggle="tabs" role="tablist"></ul>',
            $this->renderComponent('<twig:Tabler:Tabs underline bordered fill />'),
        );
        self::assertHtmlSame(
            '<ul class="nav nav-tabs" data-bs-toggle="tabs" role="tablist"></ul>',
            $this->renderComponent('<twig:Tabler:Tabs />'),
        );
    }

    public function testSegmentedControlVerticalAndSize(): void
    {
        self::assertHtmlSame(
            '<nav class="nav nav-segmented nav-segmented-vertical nav-sm" role="tablist"></nav>',
            $this->renderComponent('<twig:Tabler:SegmentedControl vertical size="sm" />'),
        );
    }

    public function testProgressStripedAnimatedSeparated(): void
    {
        self::assertHtmlSame(
            '<div class="progress"><div class="progress-bar bg-primary progress-bar-striped" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div></div>',
            $this->renderComponent('<twig:Tabler:Progress value="40" striped />'),
        );
        self::assertHtmlSame(
            '<div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>',
            $this->renderComponent('<twig:Tabler:Progress:Bar value="10" variant="success" striped animated />'),
        );
        self::assertStringContainsString(
            'class="progress progress-separated"',
            $this->renderComponent('<twig:Tabler:Progress separated />'),
        );
    }

    public function testPaginationSizeAndNamedPager(): void
    {
        self::assertHtmlSame('<ul class="pagination pagination-sm"></ul>', $this->renderComponent('<twig:Tabler:Pagination size="sm" />'));
        self::assertHtmlSame(
            '<li class="page-item page-next"><a class="page-link" href="/install" rel="next">'
            . '<div class="page-item-subtitle">next</div><div class="page-item-title">Installation</div>'
            . '</a></li>',
            $this->renderComponent('<twig:Tabler:Pagination:Item href="/install" direction="next" subtitle="next" title="Installation" />'),
        );
    }

    public function testDropdownDirectionMenuItemAndToggle(): void
    {
        self::assertHtmlSame('<div class="dropdown dropend"></div>', $this->renderComponent('<twig:Tabler:Dropdown direction="end" />'));
        self::assertHtmlSame(
            '<div class="dropdown-menu dropdown-menu-arrow dropdown-menu-dark dropdown-menu-scrollable dropdown-menu-card"></div>',
            $this->renderComponent('<twig:Tabler:Dropdown:Menu arrow dark scrollable card />'),
        );
        self::assertHtmlSame(
            '<a href="/settings" class="dropdown-item"><i class="ti ti-settings dropdown-item-icon"></i>Settings</a>',
            $this->renderComponent('<twig:Tabler:Dropdown:Item href="/settings" icon="settings">Settings</twig:Tabler:Dropdown:Item>'),
        );
        self::assertHtmlSame(
            '<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More"></button>',
            $this->renderComponent('<twig:Tabler:Dropdown:Toggle variant="primary" split aria-label="More" />'),
        );
    }

    public function testDropdownTextAndColumns(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Dropdown:Columns>
                <twig:Tabler:Dropdown:Column><twig:Tabler:Dropdown:Text>Signed in</twig:Tabler:Dropdown:Text></twig:Tabler:Dropdown:Column>
            </twig:Tabler:Dropdown:Columns>
            TWIG);

        self::assertHtmlSame(
            '<div class="dropdown-menu-columns"><div class="dropdown-menu-column"><span class="dropdown-item-text">Signed in</span></div></div>',
            $html,
        );
    }

    public function testModalBlurAndFullscreen(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Modal id="m" size="fullscreen" blur />');

        self::assertHtmlSame(
            '<div class="modal modal-blur" tabindex="-1" id="m"><div class="modal-dialog modal-fullscreen" role="document"><div class="modal-content"></div></div></div>',
            $html,
        );
    }

    public function testButtonLinkFloatingAndAnimatedIcon(): void
    {
        self::assertHtmlSame(
            '<button type="button" class="btn btn-link">More</button>',
            $this->renderComponent('<twig:Tabler:Button appearance="link">More</twig:Tabler:Button>'),
        );
        self::assertHtmlSame(
            '<button type="button" class="btn btn-floating btn-animate-icon btn-animate-icon-rotate btn-primary">+</button>',
            $this->renderComponent('<twig:Tabler:Button floating animateIcon="rotate">+</twig:Tabler:Button>'),
        );
    }

    public function testIconSizeAndFilled(): void
    {
        self::assertHtmlSame(
            '<i class="ti icon icon-lg ti-heart-filled"></i>',
            $this->renderComponent('<twig:Tabler:Icon name="heart" size="lg" filled />'),
        );
    }

    public function testBreadcrumbBulletsDividerSpacelessTrackingSquares(): void
    {
        self::assertStringContainsString('class="breadcrumb breadcrumb-bullets"', $this->renderComponent('<twig:Tabler:Breadcrumb separator="bullets" />'));
        self::assertHtmlSame('<div class="hr-text hr-text-spaceless">or</div>', $this->renderComponent('<twig:Tabler:Divider spaceless>or</twig:Tabler:Divider>'));
        self::assertHtmlSame('<div class="tracking tracking-squares"></div>', $this->renderComponent('<twig:Tabler:Tracking squares />'));
    }

    public function testEmptyBorderedWithHeaderAndImg(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Empty bordered>
                <twig:Tabler:Empty:Header>404</twig:Tabler:Empty:Header>
                <twig:Tabler:Empty:Img><img src="/x.svg" alt=""></twig:Tabler:Empty:Img>
            </twig:Tabler:Empty>
            TWIG);

        self::assertHtmlSame(
            '<div class="empty empty-bordered"><div class="empty-header">404</div><div class="empty-img"><img src="/x.svg" alt=""></div></div>',
            $html,
        );
    }

    public function testToastContainer(): void
    {
        self::assertHtmlSame(
            '<div class="toast-container position-fixed p-3 bottom-0 end-0"></div>',
            $this->renderComponent('<twig:Tabler:Toast:Container placement="bottom-end" />'),
        );
        self::assertHtmlSame('<div class="toast-container"></div>', $this->renderComponent('<twig:Tabler:Toast:Container />'));
    }

    public function testCardModifiers(): void
    {
        self::assertHtmlSame(
            '<div class="card card-borderless card-stacked card-active card-rotate-start card-link card-link-pop"></div>',
            $this->renderComponent('<twig:Tabler:Card borderless stacked active rotate="start" link="pop" />'),
        );
        self::assertHtmlSame(
            '<div class="card card-transparent card-inactive"></div>',
            $this->renderComponent('<twig:Tabler:Card transparent inactive />'),
        );
    }

    public function testCardParts(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Card>
                <twig:Tabler:Card:Img src="/c.jpg" alt="Coffee" />
                <twig:Tabler:Card:Stamp icon="bell" variant="yellow" size="lg" />
                <twig:Tabler:Card:Body scrollable><twig:Tabler:Card:Meta>Today</twig:Tabler:Card:Meta></twig:Tabler:Card:Body>
                <twig:Tabler:Card:Btn href="/more">More</twig:Tabler:Card:Btn>
                <twig:Tabler:Card:Progress value="94" variant="danger" label="94% used" />
            </twig:Tabler:Card>
            TWIG);

        self::assertHtmlSame(
            '<div class="card">'
            . '<img src="/c.jpg" alt="Coffee" class="card-img-top">'
            . '<div class="card-stamp card-stamp-lg" aria-hidden="true"><div class="card-stamp-icon bg-yellow"><i class="ti ti-bell"></i></div></div>'
            . '<div class="card-body card-body-scrollable"><div class="card-meta">Today</div></div>'
            . '<a href="/more" class="card-btn">More</a>'
            . '<div class="progress card-progress"><div class="progress-bar bg-danger" role="progressbar" style="width: 94%" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100" aria-label="94% used"></div></div>'
            . '</div>',
            $html,
        );
    }

    public function testAvatarListBrandAndUpload(): void
    {
        self::assertHtmlSame(
            '<div class="avatar-list avatar-list-stacked avatar-list-sm"><span class="avatar">JL<span class="avatar-brand" style="background-image: url(/gh.svg)"></span></span></div>',
            $this->renderComponent('<twig:Tabler:Avatar:List stacked size="sm"><twig:Tabler:Avatar>JL<twig:Tabler:Avatar:Brand image="/gh.svg" /></twig:Tabler:Avatar></twig:Tabler:Avatar:List>'),
        );
        self::assertHtmlSame(
            '<a href="/picture" class="avatar avatar-upload avatar-xl" aria-label="Upload photo"><i class="ti ti-plus"></i><span class="avatar-upload-text">Add</span></a>',
            $this->renderComponent('<twig:Tabler:Avatar:Upload href="/picture" size="xl" icon="plus" text="Add" aria-label="Upload photo" />'),
        );
    }
}
