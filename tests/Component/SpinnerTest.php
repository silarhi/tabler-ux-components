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

final class SpinnerTest extends ComponentTestCase
{
    public function testDefaultBorderSpinner(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Spinner />');

        self::assertHtmlSame('<div class="spinner-border" role="status"></div>', $html);
    }

    public function testColorAndSize(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Spinner variant="primary" size="sm" />');

        self::assertHtmlSame('<div class="spinner-border text-primary spinner-border-sm" role="status"></div>', $html);
    }

    public function testGrowTypeSmall(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Spinner type="grow" size="sm" variant="success" />');

        self::assertHtmlSame('<div class="spinner-grow text-success spinner-grow-sm" role="status"></div>', $html);
    }

    public function testLabel(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Spinner label="Loading…" />');

        self::assertHtmlSame('<div class="spinner-border" role="status"><span class="visually-hidden">Loading…</span></div>', $html);
    }
}
