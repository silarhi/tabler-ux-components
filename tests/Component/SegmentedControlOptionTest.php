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

final class SegmentedControlOptionTest extends ComponentTestCase
{
    public function testRadioGroup(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:SegmentedControl role="radiogroup" aria-label="Period">
                <twig:Tabler:SegmentedControl:Option id="period-day" name="period" value="day" label="Day" checked />
                <twig:Tabler:SegmentedControl:Option id="period-week" name="period" value="week" icon="calendar">Week</twig:Tabler:SegmentedControl:Option>
            </twig:Tabler:SegmentedControl>
            TWIG);

        self::assertHtmlSame(
            '<nav class="nav nav-segmented" role="radiogroup" aria-label="Period">'
            . '<input type="radio" class="nav-link-input btn-check d-block" id="period-day" name="period" value="day" checked autocomplete="off">'
            . '<label class="nav-link" for="period-day">Day</label>'
            . '<input type="radio" class="nav-link-input btn-check d-block" id="period-week" name="period" value="week" autocomplete="off">'
            . '<label class="nav-link" for="period-week"><i class="ti ti-calendar nav-link-icon"></i>Week</label>'
            . '</nav>',
            $html,
        );
    }

    public function testCheckboxDisabledAndAttributes(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:SegmentedControl:Option id="o" type="checkbox" label="Bold" disabled class="px-3" label:title="Bold text" data-x="1" autocomplete="on" />',
        );

        self::assertHtmlSame(
            '<input type="checkbox" class="nav-link-input btn-check d-block" id="o" disabled autocomplete="on" data-x="1">'
            . '<label class="nav-link px-3" for="o" title="Bold text">Bold</label>',
            $html,
        );
    }

    public function testSegmentedControlKeepsTheTablistRoleByDefault(): void
    {
        $html = $this->renderComponent('<twig:Tabler:SegmentedControl />');

        self::assertHtmlSame('<nav class="nav nav-segmented" role="tablist"></nav>', $html);
    }
}
