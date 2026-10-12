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

final class ButtonGroupTest extends ComponentTestCase
{
    public function testGroupOfButtons(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:ButtonGroup aria-label="Alignment">
                <twig:Tabler:Button variant="default">Left</twig:Tabler:Button>
                <twig:Tabler:Button variant="default">Right</twig:Tabler:Button>
            </twig:Tabler:ButtonGroup>
            TWIG);

        self::assertHtmlSame(
            '<div class="btn-group" role="group" aria-label="Alignment">'
            . '<button type="button" class="btn">Left</button>'
            . '<button type="button" class="btn">Right</button>'
            . '</div>',
            $html,
        );
    }

    public function testVerticalAndSizes(): void
    {
        self::assertHtmlSame(
            '<div class="btn-group-vertical btn-group-lg extra" role="group"></div>',
            $this->renderComponent('<twig:Tabler:ButtonGroup vertical size="lg" class="extra" />'),
        );
        self::assertHtmlSame(
            '<div class="btn-group btn-group-sm" role="toolbar"></div>',
            $this->renderComponent('<twig:Tabler:ButtonGroup size="sm" role="toolbar" />'),
        );
    }

    public function testRadioToggles(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:ButtonGroup aria-label="Period">
                <twig:Tabler:ButtonGroup:Toggle id="period-day" name="period" value="day" checked>Day</twig:Tabler:ButtonGroup:Toggle>
                <twig:Tabler:ButtonGroup:Toggle id="period-week" name="period" value="week" label="Week" />
            </twig:Tabler:ButtonGroup>
            TWIG);

        self::assertHtmlSame(
            '<div class="btn-group" role="group" aria-label="Period">'
            . '<input type="radio" class="btn-check" id="period-day" name="period" value="day" checked autocomplete="off">'
            . '<label class="btn" for="period-day">Day</label>'
            . '<input type="radio" class="btn-check" id="period-week" name="period" value="week" autocomplete="off">'
            . '<label class="btn" for="period-week">Week</label>'
            . '</div>',
            $html,
        );
    }

    public function testCheckboxToggleWithColorAndAttributes(): void
    {
        $html = $this->renderComponent('<twig:Tabler:ButtonGroup:Toggle id="bold" type="checkbox" variant="primary" appearance="outline" disabled class="px-3" data-format="bold">Bold</twig:Tabler:ButtonGroup:Toggle>');

        self::assertHtmlSame(
            '<input type="checkbox" class="btn-check" id="bold" disabled autocomplete="off" data-format="bold">'
            . '<label class="btn btn-outline-primary px-3" for="bold">Bold</label>',
            $html,
        );
    }

    public function testButtonList(): void
    {
        self::assertHtmlSame(
            '<div class="btn-list"><button type="button" class="btn btn-primary">Save</button></div>',
            $this->renderComponent('<twig:Tabler:ButtonList><twig:Tabler:Button>Save</twig:Tabler:Button></twig:Tabler:ButtonList>'),
        );
        self::assertHtmlSame(
            '<div class="btn-list btn-list-center mt-3"></div>',
            $this->renderComponent('<twig:Tabler:ButtonList center class="mt-3" />'),
        );
    }

    public function testButtonToolbar(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:ButtonToolbar aria-label="Editor">
                <twig:Tabler:ButtonGroup aria-label="History"><twig:Tabler:Button variant="default">Undo</twig:Tabler:Button></twig:Tabler:ButtonGroup>
            </twig:Tabler:ButtonToolbar>
            TWIG);

        self::assertHtmlSame(
            '<div class="btn-toolbar" role="toolbar" aria-label="Editor">'
            . '<div class="btn-group" role="group" aria-label="History"><button type="button" class="btn">Undo</button></div>'
            . '</div>',
            $html,
        );
    }

    public function testToggleLabelAttributesGoToTheLabel(): void
    {
        // A tooltip belongs on the visible label; everything else stays on the focusable input
        self::assertHtmlSame(
            '<input type="radio" class="btn-check" id="bold" autocomplete="off" aria-label="Bold">'
            . '<label class="btn btn-icon" for="bold" title="Bold (Ctrl+B)" data-bs-toggle="tooltip">B</label>',
            $this->renderComponent('<twig:Tabler:ButtonGroup:Toggle id="bold" class="btn-icon" aria-label="Bold" label:title="Bold (Ctrl+B)" label:data-bs-toggle="tooltip">B</twig:Tabler:ButtonGroup:Toggle>'),
        );
    }
}
