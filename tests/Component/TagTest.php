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

final class TagTest extends ComponentTestCase
{
    public function testDefault(): void
    {
        self::assertHtmlSame(
            '<span class="tag">Label</span>',
            $this->renderComponent('<twig:Tabler:Tag label="Label" />'),
        );
    }

    public function testIconAndDismissible(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Tag label="Featured" icon="star" dismissible />');

        self::assertHtmlSame(
            '<span class="tag"><i class="ti ti-star tag-icon" aria-hidden="true"></i>Featured<button type="button" class="btn-close" aria-label="Remove Featured"></button></span>',
            $html,
        );
    }

    public function testAvatarStatusAndBadge(): void
    {
        self::assertHtmlSame(
            '<span class="tag"><span class="avatar avatar-xs tag-avatar" style="background-image: url(/a.jpg)"></span>Alex P.</span>',
            $this->renderComponent('<twig:Tabler:Tag label="Alex P." avatar="/a.jpg" />'),
        );
        self::assertHtmlSame(
            '<span class="tag"><span class="badge badge-dot bg-green" aria-hidden="true"></span>Online</span>',
            $this->renderComponent('<twig:Tabler:Tag label="Online" status="green" />'),
        );
        self::assertHtmlSame(
            '<span class="tag">Notifications<span class="badge tag-badge">12</span></span>',
            $this->renderComponent('<twig:Tabler:Tag label="Notifications" badge="12" />'),
        );
    }

    public function testCheckbox(): void
    {
        self::assertHtmlSame(
            '<span class="tag"><input type="checkbox" class="form-check-input tag-check" checked aria-label="Selected">Selected</span>',
            $this->renderComponent('<twig:Tabler:Tag label="Selected" checkbox checked />'),
        );
        self::assertHtmlSame(
            '<input type="checkbox" class="form-check-input tag-check" name="labels[]" value="bug">',
            $this->renderComponent('<twig:Tabler:Tag:Check name="labels[]" value="bug" />'),
        );
        self::assertHtmlSame(
            '<span class="tag"><input type="checkbox" class="form-check-input tag-check"></span>',
            $this->renderComponent('<twig:Tabler:Tag checkbox />'),
        );
    }

    public function testComposedInList(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Tag:List class="mb-2">
                <twig:Tabler:Tag class="extra">
                    <twig:Tabler:Tag:Avatar>AP</twig:Tabler:Tag:Avatar>
                    Alex P.
                    <twig:Tabler:Tag:Badge>3</twig:Tabler:Tag:Badge>
                    <twig:Tabler:Tag:Close aria-label="Remove Alex" />
                </twig:Tabler:Tag>
                <twig:Tabler:Tag label="Beta" dismissible>
                    <twig:block name="close"><twig:Tabler:Tag:Close /></twig:block>
                </twig:Tabler:Tag>
            </twig:Tabler:Tag:List>
            TWIG);

        self::assertHtmlSame(
            '<div class="tag-list mb-2">'
            . '<span class="tag extra"><span class="avatar avatar-xs tag-avatar">AP</span>Alex P.<span class="badge tag-badge">3</span><button type="button" class="btn-close" aria-label="Remove Alex"></button></span>'
            . '<span class="tag">Beta<button type="button" class="btn-close" aria-label="Remove"></button></span>'
            . '</div>',
            $html,
        );
    }

    public function testAvatarConsumerStyleMergesWithImage(): void
    {
        self::assertHtmlSame(
            '<span class="avatar avatar-xs tag-avatar" style="background-image: url(/a.jpg); background-position: top"></span>',
            $this->renderComponent('<twig:Tabler:Tag:Avatar image="/a.jpg" style="background-position: top" />'),
        );
    }
}
