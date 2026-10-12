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

final class SignalTest extends ComponentTestCase
{
    public function testLabelledSignalIsAnImage(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Signal value="2" variant="orange" aria-label="Priority: high" />');

        self::assertHtmlSame(
            '<span class="signal signal-orange" role="img" aria-label="Priority: high">'
            . '<span class="signal-bar active"></span>'
            . '<span class="signal-bar active"></span>'
            . '<span class="signal-bar"></span>'
            . '</span>',
            $html,
        );
    }

    public function testUnlabelledSignalIsHiddenAndHonoursMax(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Signal value="1" max="4" />');

        self::assertHtmlSame(
            '<span class="signal" aria-hidden="true">'
            . '<span class="signal-bar active"></span>'
            . '<span class="signal-bar"></span>'
            . '<span class="signal-bar"></span>'
            . '<span class="signal-bar"></span>'
            . '</span>',
            $html,
        );
    }

    public function testComposedBars(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Signal variant="primary" aria-label="Level 1 of 2">
                <twig:Tabler:Signal:Bar active />
                <twig:Tabler:Signal:Bar class="opacity-50" />
            </twig:Tabler:Signal>
            TWIG);

        self::assertHtmlSame(
            '<span class="signal signal-primary" role="img" aria-label="Level 1 of 2">'
            . '<span class="signal-bar active"></span>'
            . '<span class="signal-bar opacity-50"></span>'
            . '</span>',
            $html,
        );
    }

    public function testComposedBarsIgnoreValueAndMax(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Signal value="3" max="4" aria-label="Level 1 of 2">
                <twig:Tabler:Signal:Bar active />
                <twig:Tabler:Signal:Bar />
            </twig:Tabler:Signal>
            TWIG);

        self::assertHtmlSame(
            '<span class="signal" role="img" aria-label="Level 1 of 2">'
            . '<span class="signal-bar active"></span>'
            . '<span class="signal-bar"></span>'
            . '</span>',
            $html,
        );
    }
}
