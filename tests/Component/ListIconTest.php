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

final class ListIconTest extends ComponentTestCase
{
    public function testIconList(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:List icon>
                <twig:Tabler:List:Item icon="check">Unlimited projects</twig:Tabler:List:Item>
                <twig:Tabler:List:Item icon="x" variant="danger">No custom domain</twig:Tabler:List:Item>
            </twig:Tabler:List>
            TWIG);

        self::assertHtmlSame(
            '<ul class="list-icon">'
            . '<li><i class="ti ti-check"></i> Unlimited projects</li>'
            . '<li><i class="ti text-danger ti-x"></i> No custom domain</li>'
            . '</ul>',
            $html,
        );
    }

    public function testInlineIconListDoesNotUseListInline(): void
    {
        self::assertHtmlSame(
            '<ul class="list-icon list-icon-inline"><li><i class="ti ti-check"></i> Fast</li></ul>',
            $this->renderComponent('<twig:Tabler:List icon inline dots><twig:Tabler:List:Item icon="check">Fast</twig:Tabler:List:Item></twig:Tabler:List>'),
        );
    }

    public function testVariantColorsTheMarkersAndMergesTheStyle(): void
    {
        self::assertHtmlSame(
            '<ol class="list-icon mb-0" style="--tblr-list-icon-color: var(--tblr-success); gap: 1rem" id="plan"><li>Fast</li></ol>',
            $this->renderComponent('<twig:Tabler:List icon ordered variant="success" class="mb-0" style="gap: 1rem" id="plan"><twig:Tabler:List:Item>Fast</twig:Tabler:List:Item></twig:Tabler:List>'),
        );
    }

    public function testVariantWithoutIconIsIgnored(): void
    {
        self::assertHtmlSame(
            '<ul class="" style="gap: 1rem"><li>Fast</li></ul>',
            $this->renderComponent('<twig:Tabler:List variant="success" style="gap: 1rem"><twig:Tabler:List:Item>Fast</twig:Tabler:List:Item></twig:Tabler:List>'),
        );
    }

    public function testItemIconBlock(): void
    {
        self::assertHtmlSame(
            '<li class="extra"><span class="status-dot"></span>Online</li>',
            $this->renderComponent('<twig:Tabler:List:Item icon="check" class="extra"><twig:block name="icon"><span class="status-dot"></span></twig:block>Online</twig:Tabler:List:Item>'),
        );
    }
}
