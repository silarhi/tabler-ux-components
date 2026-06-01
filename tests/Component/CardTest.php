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

final class CardTest extends ComponentTestCase
{
    public function testAllInOneTitleAndText(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Card title="Stats" text="42 active users" />');

        self::assertHtmlSame(<<<HTML
            <div class="card">
                <div class="card-header"><h3 class="card-title">Stats</h3></div>
                <div class="card-body">42 active users</div>
            </div>
            HTML, $html);
    }

    public function testFooterProp(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Card title="Stats" text="42 users" footer="Updated today" />');

        self::assertHtmlSame(<<<HTML
            <div class="card">
                <div class="card-header"><h3 class="card-title">Stats</h3></div>
                <div class="card-body">42 users</div>
                <div class="card-footer">Updated today</div>
            </div>
            HTML, $html);
    }

    public function testSizeVariant(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Card size="sm" text="Compact" />');

        self::assertHtmlSame(<<<HTML
            <div class="card card-sm">
                <div class="card-body">Compact</div>
            </div>
            HTML, $html);
    }

    public function testStatusBorder(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Card status="success" text="Done" />');

        self::assertHtmlSame(<<<HTML
            <div class="card">
                <div class="card-status-top bg-success"></div>
                <div class="card-body">Done</div>
            </div>
            HTML, $html);
    }

    public function testStatusStartPosition(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Card status="danger" statusPosition="start" text="!" />');

        self::assertHtmlSame(<<<HTML
            <div class="card">
                <div class="card-status-start bg-danger"></div>
                <div class="card-body">!</div>
            </div>
            HTML, $html);
    }

    public function testRendersAnchorWhenHrefGiven(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Card href="/post/1" title="Post" />');

        self::assertHtmlSame(<<<HTML
            <a class="card" href="/post/1">
                <div class="card-header"><h3 class="card-title">Post</h3></div>
            </a>
            HTML, $html);
    }

    public function testComposedMode(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Card>
                <twig:Tabler:Card:Header>
                    <twig:Tabler:Card:Title>Danger zone</twig:Tabler:Card:Title>
                    <twig:Tabler:Card:Actions><twig:Tabler:Button variant="danger" size="sm">Delete</twig:Tabler:Button></twig:Tabler:Card:Actions>
                </twig:Tabler:Card:Header>
                <twig:Tabler:Card:Body>This cannot be undone.</twig:Tabler:Card:Body>
                <twig:Tabler:Card:Footer>Edited 3 days ago</twig:Tabler:Card:Footer>
            </twig:Tabler:Card>
            TWIG);

        self::assertHtmlSame(<<<HTML
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danger zone</h3>
                    <div class="card-actions"><button type="button" class="btn btn-sm btn-danger">Delete</button></div>
                </div>
                <div class="card-body">This cannot be undone.</div>
                <div class="card-footer">Edited 3 days ago</div>
            </div>
            HTML, $html);
    }

    public function testConsumerClassMerges(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Card class="shadow" text="x" />');

        self::assertHtmlSame(<<<HTML
            <div class="card shadow">
                <div class="card-body">x</div>
            </div>
            HTML, $html);
    }
}
