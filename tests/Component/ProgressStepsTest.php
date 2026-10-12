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

final class ProgressStepsTest extends ComponentTestCase
{
    public function testCountAndActive(): void
    {
        $html = $this->renderComponent('<twig:Tabler:ProgressSteps count="3" active="2" aria-label="Setup progress" />');

        self::assertHtmlSame(
            '<ol class="progress-steps" aria-label="Setup progress">'
            . '<li class="progress-steps-item bg-primary"><span class="visually-hidden">Step 1</span></li>'
            . '<li class="progress-steps-item bg-primary" aria-current="step"><span class="visually-hidden">Step 2</span></li>'
            . '<li class="progress-steps-item"><span class="visually-hidden">Step 3</span></li>'
            . '</ol>',
            $html,
        );
    }

    public function testLabelsAndVariant(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:ProgressSteps labels="{{ labels }}" active="1" variant="green" />',
            ['labels' => ['Account', 'Billing']],
        );

        self::assertHtmlSame(
            '<ol class="progress-steps">'
            . '<li class="progress-steps-item bg-green" aria-current="step"><span class="visually-hidden">Account</span></li>'
            . '<li class="progress-steps-item"><span class="visually-hidden">Billing</span></li>'
            . '</ol>',
            $html,
        );
    }

    public function testComposed(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:ProgressSteps class="w-50">
                <twig:Tabler:ProgressSteps:Item variant="orange" current label="One" />
                <twig:Tabler:ProgressSteps:Item />
            </twig:Tabler:ProgressSteps>
            TWIG);

        self::assertHtmlSame(
            '<ol class="progress-steps w-50">'
            . '<li class="progress-steps-item bg-orange" aria-current="step"><span class="visually-hidden">One</span></li>'
            . '<li class="progress-steps-item"></li>'
            . '</ol>',
            $html,
        );
    }
}
