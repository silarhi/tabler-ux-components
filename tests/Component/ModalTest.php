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

final class ModalTest extends ComponentTestCase
{
    public function testAllInOneTitleAndText(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Modal id="confirm" title="Delete item?" text="This cannot be undone." />');

        self::assertHtmlSame(<<<HTML
            <div class="modal" tabindex="-1" id="confirm">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete item?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">This cannot be undone.</div>
                    </div>
                </div>
            </div>
            HTML, $html);
    }

    public function testFooterProp(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Modal id="m" title="Hi" text="Body" footer="Footer text" />');

        self::assertHtmlSame(<<<HTML
            <div class="modal" tabindex="-1" id="m">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Hi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">Body</div>
                        <div class="modal-footer">Footer text</div>
                    </div>
                </div>
            </div>
            HTML, $html);
    }

    public function testNonDismissibleHidesCloseButton(): void
    {
        // A real boolean false must be passed via the {% component %} syntax;
        // `dismissible="false"` in HTML syntax would pass the truthy string "false".
        $html = $this->renderComponent(
            <<<'TWIG'
            {% component 'Tabler:Modal' with {id: 'm', title: 'Locked', dismissible: false} %}{% endcomponent %}
            TWIG,
        );

        self::assertHtmlSame(<<<HTML
            <div class="modal" tabindex="-1" id="m">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Locked</h5>
                        </div>
                    </div>
                </div>
            </div>
            HTML, $html);
    }

    public function testSizeCenteredScrollable(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Modal id="m" size="lg" centered scrollable text="Body" />');

        self::assertHtmlSame(<<<HTML
            <div class="modal" tabindex="-1" id="m">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-body">Body</div>
                    </div>
                </div>
            </div>
            HTML, $html);
    }

    public function testStatusBar(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Modal id="m" status="danger" text="!" />');

        self::assertHtmlSame(<<<HTML
            <div class="modal" tabindex="-1" id="m">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-status bg-danger"></div>
                        <div class="modal-body">!</div>
                    </div>
                </div>
            </div>
            HTML, $html);
    }

    public function testStaticBackdrop(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Modal id="m" staticBackdrop text="x" />');

        self::assertHtmlSame(<<<HTML
            <div class="modal" tabindex="-1" id="m" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">x</div>
                    </div>
                </div>
            </div>
            HTML, $html);
    }

    public function testComposedMode(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Modal id="edit">
                <twig:Tabler:Modal:Header>
                    <twig:Tabler:Modal:Title>Edit</twig:Tabler:Modal:Title>
                    <twig:Tabler:Modal:Close />
                </twig:Tabler:Modal:Header>
                <twig:Tabler:Modal:Body>Form</twig:Tabler:Modal:Body>
                <twig:Tabler:Modal:Footer><twig:Tabler:Button variant="primary">Save</twig:Tabler:Button></twig:Tabler:Modal:Footer>
            </twig:Tabler:Modal>
            TWIG);

        self::assertHtmlSame(<<<HTML
            <div class="modal" tabindex="-1" id="edit">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">Form</div>
                        <div class="modal-footer"><button type="button" class="btn btn-primary">Save</button></div>
                    </div>
                </div>
            </div>
            HTML, $html);
    }
}
