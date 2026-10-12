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

final class SparklineTest extends ComponentTestCase
{
    public function testDefaultLine(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Sparkline values="3,4,2,6" variant="primary" aria-label="Weekly trend" />');

        self::assertHtmlSame(
            '<span class="sparkline text-primary" data-bs-toggle="sparkline" data-bs-values="3,4,2,6" role="img" aria-label="Weekly trend"></span>',
            $html,
        );
    }

    public function testArrayValuesAndBarOptions(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:Sparkline values="{{ values }}" type="bar" size="lg" barGap="4" barRadius="0" threshold="2" disabled />',
            ['values' => [1, -2, 3]],
        );

        self::assertHtmlSame(
            '<span class="sparkline sparkline-lg sparkline-disabled" data-bs-toggle="sparkline" data-bs-type="bar" data-bs-values="1,-2,3" data-bs-threshold="2" data-bs-bar-gap="4" data-bs-bar-radius="0"></span>',
            $html,
        );
    }

    public function testLineWithFillSpotAndRange(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Sparkline values="1,2" fill spot="last" min="0" max="100" />');

        self::assertHtmlSame(
            '<span class="sparkline" data-bs-toggle="sparkline" data-bs-values="1,2" data-bs-fill="auto" data-bs-spot="last" data-bs-min="0" data-bs-max="100"></span>',
            $html,
        );
    }

    public function testCircleIsSquare(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Sparkline values="72" type="circle" label="auto" variant="green" />');

        self::assertHtmlSame(
            '<span class="sparkline sparkline-square text-green" data-bs-toggle="sparkline" data-bs-type="circle" data-bs-values="72" data-bs-label="auto" data-bs-width="40" data-bs-height="40"></span>',
            $html,
        );
    }
}
