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

final class ToastTest extends ComponentTestCase
{
    public function testPoliteStatusByDefault(): void
    {
        self::assertHtmlSame(
            '<div class="toast" role="status" aria-live="polite" aria-atomic="true"><div class="toast-body">Saved.</div></div>',
            $this->renderComponent('<twig:Tabler:Toast text="Saved." />'),
        );
    }

    public function testUrgentIsAnAssertiveAlert(): void
    {
        self::assertHtmlSame(
            '<div class="toast show extra" role="alert" aria-live="assertive" aria-atomic="true" id="error"><div class="toast-body">Payment failed.</div></div>',
            $this->renderComponent('<twig:Tabler:Toast show urgent text="Payment failed." class="extra" id="error" />'),
        );
    }
}
