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

final class ProgressTest extends ComponentTestCase
{
    public function testSingleBarFromValue(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Progress value="38" />');

        self::assertHtmlSame(
            '<div class="progress"><div class="progress-bar bg-primary" role="progressbar" style="width: 38%" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100"></div></div>',
            $html,
        );
    }

    public function testSizeColorAndLabel(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Progress value="57" variant="success" size="sm" label="57% complete" />');

        self::assertHtmlSame(
            '<div class="progress progress-sm"><div class="progress-bar bg-success" role="progressbar" style="width: 57%" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100"><span class="visually-hidden">57% complete</span></div></div>',
            $html,
        );
    }

    public function testIndeterminate(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Progress indeterminate size="sm" />');

        self::assertHtmlSame(
            '<div class="progress progress-sm"><div class="progress-bar bg-primary progress-bar-indeterminate" role="progressbar"></div></div>',
            $html,
        );
    }

    public function testComposedStackedBars(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Progress>
                <twig:Tabler:Progress:Bar value="30" variant="primary" />
                <twig:Tabler:Progress:Bar value="20" variant="success" />
            </twig:Tabler:Progress>
            TWIG);

        self::assertHtmlSame(
            '<div class="progress">'
            . '<div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>'
            . '<div class="progress-bar bg-success" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>'
            . '</div>',
            $html,
        );
    }
}
