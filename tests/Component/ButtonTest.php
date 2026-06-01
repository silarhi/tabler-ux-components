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

final class ButtonTest extends ComponentTestCase
{
    public function testRendersButtonByDefault(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button>Save</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-primary">Save</button>', $html);
    }

    public function testRendersAnchorWhenHrefGiven(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button href="/profile" variant="secondary">Profile</twig:Tabler:Button>');

        self::assertHtmlSame('<a href="/profile" class="btn btn-secondary" role="button">Profile</a>', $html);
    }

    public function testOutlineAppearance(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button variant="danger" appearance="outline">Delete</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-outline-danger">Delete</button>', $html);
    }

    public function testGhostAppearance(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button variant="info" appearance="ghost">Info</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-ghost-info">Info</button>', $html);
    }

    public function testSizeAndModifiers(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button variant="success" size="lg" pill>Go</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-lg btn-pill btn-success">Go</button>', $html);
    }

    public function testDisabledButtonGetsAttribute(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button disabled>Nope</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-primary" disabled>Nope</button>', $html);
    }

    public function testDisabledAnchorGetsClassAndAria(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button href="#" disabled>Nope</twig:Tabler:Button>');

        self::assertHtmlSame('<a href="#" class="btn disabled btn-primary" role="button" aria-disabled="true" tabindex="-1">Nope</a>', $html);
    }

    public function testSubmitType(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button type="submit" variant="primary">Submit</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="submit" class="btn btn-primary">Submit</button>', $html);
    }

    public function testConsumerClassMerges(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button variant="primary" class="me-2">X</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-primary me-2">X</button>', $html);
    }
}
