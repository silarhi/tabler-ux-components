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

final class AccordionTest extends ComponentTestCase
{
    public function testAllInOneItems(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:Accordion id="faq" items="{{ items }}" />',
            ['items' => [
                ['title' => 'Account details', 'text' => 'Update your profile.', 'open' => true],
                ['title' => 'Security', 'text' => 'Two-factor.', 'id' => 'sec'],
            ]],
        );

        self::assertHtmlSame(
            '<div class="accordion" id="faq">'
            . '<div class="accordion-item">'
            . '<h3 class="accordion-header">'
            . '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq-1" aria-controls="faq-1" aria-expanded="true">'
            . 'Account details<span class="accordion-button-toggle"><i class="ti ti-chevron-down" aria-hidden="true"></i></span>'
            . '</button>'
            . '</h3>'
            . '<div id="faq-1" class="accordion-collapse collapse show" data-bs-parent="#faq"><div class="accordion-body">Update your profile.</div></div>'
            . '</div>'
            . '<div class="accordion-item">'
            . '<h3 class="accordion-header">'
            . '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sec" aria-controls="sec" aria-expanded="false">'
            . 'Security<span class="accordion-button-toggle"><i class="ti ti-chevron-down" aria-hidden="true"></i></span>'
            . '</button>'
            . '</h3>'
            . '<div id="sec" class="accordion-collapse collapse" data-bs-parent="#faq"><div class="accordion-body">Two-factor.</div></div>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testInlineItemsLiteral(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Accordion id="faq" items="{{ [
                {title: 'One', text: 'First.'},
            ] }}" />
            TWIG);

        self::assertStringContainsString('data-bs-target="#faq-1"', $html);
        self::assertStringContainsString('class="accordion-body">First.</div>', $html);
    }

    public function testModifiersAlwaysOpenAndPlus(): void
    {
        $html = $this->renderComponent(
            '<twig:Tabler:Accordion id="acc" flush inverted tabs alwaysOpen plus items="{{ items }}" class="mb-3" />',
            ['items' => [['title' => 'Billing', 'icon' => 'credit-card']]],
        );

        self::assertHtmlSame(
            '<div class="accordion accordion-flush accordion-inverted accordion-tabs mb-3" id="acc">'
            . '<div class="accordion-item">'
            . '<h3 class="accordion-header">'
            . '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#acc-1" aria-controls="acc-1" aria-expanded="false">'
            . '<span class="accordion-button-icon"><i class="ti ti-credit-card" aria-hidden="true"></i></span>'
            . 'Billing'
            . '<span class="accordion-button-toggle accordion-button-toggle-plus"><i class="ti ti-plus" aria-hidden="true"></i></span>'
            . '</button>'
            . '</h3>'
            . '<div id="acc-1" class="accordion-collapse collapse"></div>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testItemBlocksOverride(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Accordion:Item id="hooks" parent="faq" title="Webhooks" level="2" toggleIcon="caret-down" class="bg-surface">
                <twig:block name="title">Web<em>hooks</em></twig:block>
                <twig:block name="body">
                    <twig:Tabler:Accordion:Body>Manage <strong>URLs</strong>.</twig:Tabler:Accordion:Body>
                </twig:block>
            </twig:Tabler:Accordion:Item>
            TWIG);

        self::assertHtmlSame(
            '<div class="accordion-item bg-surface">'
            . '<h2 class="accordion-header">'
            . '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#hooks" aria-controls="hooks" aria-expanded="false">'
            . 'Web<em>hooks</em><span class="accordion-button-toggle"><i class="ti ti-caret-down" aria-hidden="true"></i></span>'
            . '</button>'
            . '</h2>'
            . '<div id="hooks" class="accordion-collapse collapse" data-bs-parent="#faq"><div class="accordion-body">Manage <strong>URLs</strong>.</div></div>'
            . '</div>',
            $html,
        );
    }

    public function testComposed(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Accordion id="faq">
                <twig:Tabler:Accordion:Item>
                    <twig:Tabler:Accordion:Header>
                        <twig:Tabler:Accordion:Button target="faq-api" open>
                            <twig:block name="icon"><twig:Tabler:Accordion:Icon>*</twig:Tabler:Accordion:Icon></twig:block>
                            API access
                            <twig:block name="toggle"><twig:Tabler:Accordion:Toggle plus /></twig:block>
                        </twig:Tabler:Accordion:Button>
                    </twig:Tabler:Accordion:Header>
                    <twig:Tabler:Accordion:Collapse id="faq-api" parent="faq" open>
                        <twig:Tabler:Accordion:Body>Generate tokens.</twig:Tabler:Accordion:Body>
                    </twig:Tabler:Accordion:Collapse>
                </twig:Tabler:Accordion:Item>
            </twig:Tabler:Accordion>
            TWIG);

        self::assertHtmlSame(
            '<div class="accordion" id="faq">'
            . '<div class="accordion-item">'
            . '<h3 class="accordion-header">'
            . '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq-api" aria-controls="faq-api" aria-expanded="true">'
            . '<span class="accordion-button-icon">*</span>'
            . 'API access'
            . '<span class="accordion-button-toggle accordion-button-toggle-plus"><i class="ti ti-plus" aria-hidden="true"></i></span>'
            . '</button>'
            . '</h3>'
            . '<div id="faq-api" class="accordion-collapse collapse show" data-bs-parent="#faq"><div class="accordion-body">Generate tokens.</div></div>'
            . '</div>'
            . '</div>',
            $html,
        );
    }
}
