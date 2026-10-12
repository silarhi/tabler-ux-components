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

final class LegendTest extends ComponentTestCase
{
    public function testAllInOne(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Legend variant="blue" label="Allowed" value="339.0k" />');

        self::assertHtmlSame(
            '<span class="legend legend-blue"><span class="legend-dot"></span>Allowed<span class="legend-value">339.0k</span></span>',
            $html,
        );
    }

    public function testLargeWithUnit(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Legend variant="primary" size="lg" label="P99" value="124" unit="ms" />');

        self::assertHtmlSame(
            '<span class="legend legend-lg legend-primary"><span class="legend-dot"></span>P99<span class="legend-value">124<span class="legend-unit">ms</span></span></span>',
            $html,
        );
    }

    public function testButtonOffAndLinkActive(): void
    {
        self::assertHtmlSame(
            '<button type="button" class="legend legend-teal legend-off" data-series="rate"><span class="legend-dot"></span>Rate limited</button>',
            $this->renderComponent('<twig:Tabler:Legend variant="teal" label="Rate limited" button off data-series="rate" />'),
        );
        self::assertHtmlSame(
            '<a href="?status=passed" class="legend legend-green active"><span class="legend-dot"></span>Passed</a>',
            $this->renderComponent('<twig:Tabler:Legend variant="green" label="Passed" href="?status=passed" active />'),
        );
    }

    public function testComposedInList(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Legend:List vertical divided>
                <twig:Tabler:Legend variant="red">
                    <twig:Tabler:Legend:Dot />
                    Denied
                    <twig:Tabler:Legend:Value>1.2<twig:Tabler:Legend:Unit>k</twig:Tabler:Legend:Unit></twig:Tabler:Legend:Value>
                </twig:Tabler:Legend>
            </twig:Tabler:Legend:List>
            TWIG);

        self::assertHtmlSame(
            '<div class="legend-list legend-list-vertical legend-list-divided">'
            . '<span class="legend legend-red"><span class="legend-dot"></span>Denied<span class="legend-value">1.2<span class="legend-unit">k</span></span></span>'
            . '</div>',
            $html,
        );
    }

    public function testStandaloneDot(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Legend:Dot variant="azure" />');

        self::assertHtmlSame('<span class="legend-dot legend-azure"></span>', $html);
    }
}
