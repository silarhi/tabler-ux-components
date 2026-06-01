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

final class DividerTest extends ComponentTestCase
{
    public function testPlainRuleWhenEmpty(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Divider />');

        self::assertHtmlSame('<hr class="hr">', $html);
    }

    public function testTextDivider(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Divider>See also</twig:Tabler:Divider>');

        self::assertHtmlSame('<div class="hr-text">See also</div>', $html);
    }

    public function testPositionAndColor(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Divider position="start" variant="primary">Section</twig:Tabler:Divider>');

        self::assertHtmlSame('<div class="hr-text hr-text-start text-primary">Section</div>', $html);
    }
}
