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

final class TrendingTest extends ComponentTestCase
{
    public function testUp(): void
    {
        self::assertHtmlSame(
            '<span class="d-inline-flex align-items-center lh-1 text-green"><span class="visually-hidden">Increased by</span>25%<i class="ti ti-arrow-up ms-0" aria-hidden="true"></i></span>',
            $this->renderComponent('<twig:Tabler:Trending value="25" />'),
        );
    }

    public function testDownWithNumericValue(): void
    {
        self::assertHtmlSame(
            '<span class="d-inline-flex align-items-center lh-1 text-red"><span class="visually-hidden">Decreased by</span>-12%<i class="ti ti-arrow-down ms-0" aria-hidden="true"></i></span>',
            $this->renderComponent('<twig:Tabler:Trending value="{{ value }}" />', ['value' => -12]),
        );
    }

    public function testNeutralWithClass(): void
    {
        self::assertHtmlSame(
            '<span class="d-inline-flex align-items-center lh-1 text-secondary h2 m-0"><span class="visually-hidden">No change,</span>0.0%<i class="ti ti-minus ms-0" aria-hidden="true"></i></span>',
            $this->renderComponent('<twig:Tabler:Trending value="0.0" class="h2 m-0" />'),
        );
    }

    public function testUnitDirectionAndLabel(): void
    {
        self::assertHtmlSame(
            '<span class="d-inline-flex align-items-center lh-1 text-green"><span class="visually-hidden">Up</span>+4.2K<i class="ti ti-arrow-up ms-0" aria-hidden="true"></i></span>',
            $this->renderComponent('<twig:Tabler:Trending value="+4.2K" unit="" label="Up" />'),
        );
        self::assertHtmlSame(
            '<span class="d-inline-flex align-items-center lh-1 text-red"><span class="visually-hidden">Decreased by</span>3 ms<i class="ti ti-arrow-down ms-0" aria-hidden="true"></i></span>',
            $this->renderComponent('<twig:Tabler:Trending value="3" unit=" ms" direction="down" />'),
        );
    }

    public function testComposedIcon(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Trending value="7">
                <twig:block name="icon"><twig:Tabler:Icon name="trending-up" class="ms-1" /></twig:block>
            </twig:Tabler:Trending>
            TWIG);

        self::assertHtmlSame(
            '<span class="d-inline-flex align-items-center lh-1 text-green"><span class="visually-hidden">Increased by</span>7%<i class="ti ti-trending-up ms-1"></i></span>',
            $html,
        );
    }
}
