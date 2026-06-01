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

final class CompositionComponentsTest extends ComponentTestCase
{
    public function testEmptyAllInOne(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Empty title="No results found" subtitle="Try again." />');

        self::assertHtmlSame(
            '<div class="empty">'
            . '<p class="empty-title">No results found</p>'
            . '<p class="empty-subtitle text-secondary">Try again.</p>'
            . '</div>',
            $html,
        );
    }

    public function testEmptyComposed(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Empty>
                <twig:Tabler:Empty:Title>Nothing yet</twig:Tabler:Empty:Title>
                <twig:Tabler:Empty:Action><twig:Tabler:Button variant="primary">New</twig:Tabler:Button></twig:Tabler:Empty:Action>
            </twig:Tabler:Empty>
            TWIG);

        self::assertHtmlSame(
            '<div class="empty">'
            . '<p class="empty-title">Nothing yet</p>'
            . '<div class="empty-action"><button type="button" class="btn btn-primary">New</button></div>'
            . '</div>',
            $html,
        );
    }

    public function testTracking(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Tracking>
                <twig:Tabler:Tracking:Block variant="success" />
                <twig:Tabler:Tracking:Block variant="danger" tooltip="Down" />
            </twig:Tabler:Tracking>
            TWIG);

        self::assertHtmlSame(
            '<div class="tracking">'
            . '<div class="tracking-block bg-success"></div>'
            . '<div class="tracking-block bg-danger" data-bs-toggle="tooltip" data-bs-title="Down"></div>'
            . '</div>',
            $html,
        );
    }

    public function testSwitchIconComposed(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:SwitchIcon animation="fade">
                <twig:Tabler:SwitchIcon:A>A</twig:Tabler:SwitchIcon:A>
                <twig:Tabler:SwitchIcon:B>B</twig:Tabler:SwitchIcon:B>
            </twig:Tabler:SwitchIcon>
            TWIG);

        self::assertHtmlSame(
            '<button class="switch-icon switch-icon-fade" data-bs-toggle="switch-icon">'
            . '<span class="switch-icon-a">A</span>'
            . '<span class="switch-icon-b">B</span>'
            . '</button>',
            $html,
        );
    }

    public function testSwitchIconAllInOne(): void
    {
        $html = $this->renderComponent('<twig:Tabler:SwitchIcon iconA="moon" iconB="sun" />');

        self::assertHtmlSame(
            '<button class="switch-icon" data-bs-toggle="switch-icon">'
            . '<span class="switch-icon-a"><i class="ti ti-moon"></i></span>'
            . '<span class="switch-icon-b"><i class="ti ti-sun"></i></span>'
            . '</button>',
            $html,
        );
    }

    public function testSteps(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Step counter>
                <twig:Tabler:Step:Item href="#">One</twig:Tabler:Step:Item>
                <twig:Tabler:Step:Item active>Two</twig:Tabler:Step:Item>
            </twig:Tabler:Step>
            TWIG);

        self::assertHtmlSame(
            '<div class="steps steps-counter">'
            . '<a href="#" class="step-item">One</a>'
            . '<span class="step-item active">Two</span>'
            . '</div>',
            $html,
        );
    }

    public function testTimeline(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Timeline simple>
                <twig:Tabler:Timeline:Event title="Backup done" time="1 day ago" text="Latest backup ready." />
            </twig:Tabler:Timeline>
            TWIG);

        self::assertHtmlSame(
            '<ul class="timeline timeline-simple">'
            . '<li class="timeline-event">'
            . '<div class="timeline-event-icon"></div>'
            . '<div class="card timeline-event-card"><div class="card-body">'
            . '<div class="text-secondary float-end">1 day ago</div>'
            . '<h4>Backup done</h4>'
            . 'Latest backup ready.'
            . '</div></div>'
            . '</li>'
            . '</ul>',
            $html,
        );
    }
}
