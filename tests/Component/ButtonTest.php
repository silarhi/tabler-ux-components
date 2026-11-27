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

use DOMDocument;
use DOMElement;
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

    public function testDefaultVariantRendersNeutralButtons(): void
    {
        self::assertHtmlSame(
            '<button type="button" class="btn">Cancel</button>',
            $this->renderComponent('<twig:Tabler:Button variant="default">Cancel</twig:Tabler:Button>'),
        );
        self::assertHtmlSame(
            '<button type="button" class="btn btn-outline">Cancel</button>',
            $this->renderComponent('<twig:Tabler:Button variant="default" appearance="outline">Cancel</twig:Tabler:Button>'),
        );
        self::assertHtmlSame(
            '<button type="button" class="btn btn-ghost">Cancel</button>',
            $this->renderComponent('<twig:Tabler:Button variant="default" appearance="ghost">Cancel</twig:Tabler:Button>'),
        );
    }

    public function testExtraLargeSize(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button size="xl">Go</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-xl btn-primary">Go</button>', $html);
    }

    public function testLeadingAndTrailingIcons(): void
    {
        self::assertHtmlSame(
            '<button type="button" class="btn btn-primary"><i class="ti ti-plus icon" aria-hidden="true"></i>New user</button>',
            $this->renderComponent('<twig:Tabler:Button icon="plus">New user</twig:Tabler:Button>'),
        );
        self::assertHtmlSame(
            '<a href="/next" class="btn" role="button">Next<i class="ti ti-arrow-right icon icon-end" aria-hidden="true"></i></a>',
            $this->renderComponent('<twig:Tabler:Button href="/next" variant="default" iconEnd="arrow-right">Next</twig:Tabler:Button>'),
        );
    }

    public function testIconOnlyNeedsNoChildren(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button variant="danger" icon="trash" iconOnly aria-label="Delete" />');

        self::assertHtmlSame('<button type="button" class="btn btn-icon btn-danger" aria-label="Delete"><i class="ti ti-trash icon" aria-hidden="true"></i></button>', $html);
    }

    public function testIconWithAnimation(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button variant="default" icon="refresh" animateIcon="rotate">Sync</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-animate-icon btn-animate-icon-rotate"><i class="ti ti-refresh icon" aria-hidden="true"></i>Sync</button>', $html);
    }

    public function testPrefixedIconRendersSvg(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button icon="lucide:circle-check">Done</twig:Tabler:Button>');

        $document = new DOMDocument();
        self::assertTrue(@$document->loadHTML($html));
        $svg = $document->getElementsByTagName('svg')->item(0);
        self::assertInstanceOf(DOMElement::class, $svg);
        self::assertSame('icon', $svg->getAttribute('class'));
        self::assertMatchesRegularExpression('#</svg>\s*Done</button>\s*$#', $html);
    }

    public function testIconBlocksCanBeOverridden(): void
    {
        $html = $this->renderComponent(<<<'TWIG'
            <twig:Tabler:Button icon="plus" iconEnd="x">
                <twig:block name="icon"><span class="icon">+</span></twig:block>
                <twig:block name="iconEnd"></twig:block>
                Add
            </twig:Tabler:Button>
            TWIG);

        self::assertHtmlSame('<button type="button" class="btn btn-primary"><span class="icon">+</span>Add</button>', $html);
    }

    public function testModalTrigger(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button modal="confirm">Delete</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirm" aria-controls="confirm">Delete</button>', $html);
    }

    public function testOffcanvasTriggerOnLink(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button href="#menu" offcanvas="menu">Menu</twig:Tabler:Button>');

        self::assertHtmlSame('<a href="#menu" class="btn btn-primary" role="button" data-bs-toggle="offcanvas" data-bs-target="#menu" aria-controls="menu">Menu</a>', $html);
    }

    public function testCollapseTrigger(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button collapse="filters">Filters</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target="#filters" aria-controls="filters" aria-expanded="false">Filters</button>', $html);
    }

    public function testFirstTriggerWins(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button modal="a" offcanvas="b" collapse="c">X</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#a" aria-controls="a">X</button>', $html);
    }

    public function testExplicitAttributesWinOverTriggers(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button collapse="filters" aria-expanded="true" data-bs-target=".filters" data-foo="bar">Filters</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-primary" data-bs-toggle="collapse" data-bs-target=".filters" aria-controls="filters" aria-expanded="true" data-foo="bar">Filters</button>', $html);
    }

    public function testTooltip(): void
    {
        self::assertHtmlSame(
            '<button type="button" class="btn btn-primary" data-bs-toggle="tooltip" title="Save the draft">Save</button>',
            $this->renderComponent('<twig:Tabler:Button tooltip="Save the draft">Save</twig:Tabler:Button>'),
        );
        self::assertHtmlSame(
            '<button type="button" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" title="Settings" aria-label="Settings"><i class="ti ti-settings icon" aria-hidden="true"></i></button>',
            $this->renderComponent('<twig:Tabler:Button icon="settings" iconOnly tooltip="Settings" />'),
        );
        self::assertHtmlSame(
            '<button type="button" class="btn btn-icon btn-primary" data-bs-toggle="tooltip" title="Settings" aria-label="Open the settings"><i class="ti ti-settings icon" aria-hidden="true"></i></button>',
            $this->renderComponent('<twig:Tabler:Button icon="settings" iconOnly tooltip="Settings" aria-label="Open the settings" />'),
        );
    }

    public function testTriggerTakesPrecedenceOverTooltip(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button modal="confirm" tooltip="Asks first">Delete</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirm" aria-controls="confirm" title="Asks first">Delete</button>', $html);
    }

    public function testTriggerKeepsDisabledAndClassMerge(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button modal="confirm" icon="trash" class="ms-auto" disabled>Delete</twig:Tabler:Button>');

        self::assertHtmlSame('<button type="button" class="btn btn-primary ms-auto" data-bs-toggle="modal" data-bs-target="#confirm" aria-controls="confirm" disabled><i class="ti ti-trash icon" aria-hidden="true"></i>Delete</button>', $html);
    }

    public function testLabelTagForAFileInput(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button tag="label" icon="upload"><input type="file" name="import" class="visually-hidden">Import</twig:Tabler:Button>');

        self::assertHtmlSame('<label class="btn btn-primary"><i class="ti ti-upload icon" aria-hidden="true"></i><input type="file" name="import" class="visually-hidden">Import</label>', $html);
    }

    public function testLabelAndSpanTagsGetNoTypeHrefNorRole(): void
    {
        self::assertHtmlSame(
            '<label class="btn btn-secondary">Import</label>',
            $this->renderComponent('<twig:Tabler:Button tag="label" variant="secondary" type="submit" href="/import">Import</twig:Tabler:Button>'),
        );
        self::assertHtmlSame(
            '<span class="btn btn-outline">Draft</span>',
            $this->renderComponent('<twig:Tabler:Button tag="span" variant="default" appearance="outline">Draft</twig:Tabler:Button>'),
        );
    }

    public function testDisabledLabelAndSpanGetClassAndAria(): void
    {
        self::assertHtmlSame(
            '<label class="btn disabled btn-primary" aria-disabled="true">Import</label>',
            $this->renderComponent('<twig:Tabler:Button tag="label" disabled>Import</twig:Tabler:Button>'),
        );
        self::assertHtmlSame(
            '<span class="btn disabled btn-primary" aria-disabled="true">Draft</span>',
            $this->renderComponent('<twig:Tabler:Button tag="span" disabled>Draft</twig:Tabler:Button>'),
        );
    }

    public function testExplicitTagWinsOverHref(): void
    {
        self::assertHtmlSame(
            '<button type="button" class="btn btn-primary">Save</button>',
            $this->renderComponent('<twig:Tabler:Button tag="button" href="/save">Save</twig:Tabler:Button>'),
        );
        self::assertHtmlSame(
            '<a href="/profile" class="btn disabled btn-primary" role="button" aria-disabled="true" tabindex="-1">Profile</a>',
            $this->renderComponent('<twig:Tabler:Button tag="a" href="/profile" disabled>Profile</twig:Tabler:Button>'),
        );
    }

    public function testLabelTagKeepsTooltipAndAttributes(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Button tag="label" for="avatar" tooltip="PNG or JPEG" class="mb-0">Upload</twig:Tabler:Button>');

        self::assertHtmlSame('<label class="btn btn-primary mb-0" data-bs-toggle="tooltip" title="PNG or JPEG" for="avatar">Upload</label>', $html);
    }
}
