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

final class MiscComponentsTest extends ComponentTestCase
{
    public function testRibbon(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Ribbon variant="success" position="top-start">NEW</twig:Tabler:Ribbon>');

        self::assertHtmlSame('<div class="ribbon bg-success ribbon-top ribbon-start">NEW</div>', $html);
    }

    public function testRibbonBookmark(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Ribbon variant="orange" bookmark>★</twig:Tabler:Ribbon>');

        // unknown color falls through to no color class; bookmark class still applies
        self::assertHtmlSame('<div class="ribbon ribbon-bookmark">★</div>', $html);
    }

    public function testPlaceholder(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Placeholder width="9" />');

        self::assertHtmlSame('<div class="placeholder col-9"></div>', $html);
    }

    public function testPlaceholderSized(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Placeholder width="6" size="xs" />');

        self::assertHtmlSame('<div class="placeholder placeholder-xs col-6"></div>', $html);
    }

    public function testTooltip(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Tooltip title="More info">Hover</twig:Tabler:Tooltip>');

        self::assertHtmlSame('<span data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="More info">Hover</span>', $html);
    }

    public function testPopover(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Popover title="Heads up" content="Details here." placement="bottom">Click</twig:Tabler:Popover>');

        self::assertHtmlSame('<span data-bs-toggle="popover" data-bs-placement="bottom" data-bs-title="Heads up" data-bs-content="Details here.">Click</span>', $html);
    }

    public function testTableResponsiveWrapper(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Table hover striped>
                <thead><tr><th>Name</th></tr></thead>
                <tbody><tr><td>Jane</td></tr></tbody>
            </twig:Tabler:Table>
            TWIG);

        self::assertHtmlSame(
            '<div class="table-responsive"><table class="table table-striped table-hover">'
            . '<thead><tr><th>Name</th></tr></thead><tbody><tr><td>Jane</td></tr></tbody>'
            . '</table></div>',
            $html,
        );
    }

    public function testTableNonResponsive(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            {% component 'Tabler:Table' with {responsive: false, vcenter: true} %}{% block content %}<tbody><tr><td>x</td></tr></tbody>{% endblock %}{% endcomponent %}
            TWIG);

        self::assertHtmlSame('<table class="table table-vcenter"><tbody><tr><td>x</td></tr></tbody></table>', $html);
    }
}
