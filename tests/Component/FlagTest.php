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

use PHPUnit\Framework\Attributes\DataProvider;
use Silarhi\TablerUxComponents\Tests\ComponentTestCase;

use function sprintf;

final class FlagTest extends ComponentTestCase
{
    public function testDecorativeFlagIsHidden(): void
    {
        self::assertHtmlSame(
            '<span class="flag flag-country-us" aria-hidden="true"></span>',
            $this->renderComponent('<twig:Tabler:Flag code="us" />'),
        );
    }

    public function testLabelNamesTheFlagAndCodeIsLowercased(): void
    {
        self::assertHtmlSame(
            '<span class="flag flag-country-fr" role="img" aria-label="France"></span>',
            $this->renderComponent('<twig:Tabler:Flag code="FR" label="France" />'),
        );
    }

    public function testSlugCode(): void
    {
        self::assertHtmlSame(
            '<span class="flag flag-country-european-union" aria-hidden="true"></span>',
            $this->renderComponent('<twig:Tabler:Flag code="european-union" />'),
        );
    }

    #[DataProvider('provideSizes')]
    public function testSizes(string $size): void
    {
        self::assertHtmlSame(
            sprintf('<span class="flag flag-%s flag-country-pl" aria-hidden="true"></span>', $size),
            $this->renderComponent(sprintf('<twig:Tabler:Flag code="pl" size="%s" />', $size)),
        );
    }

    /**
     * @return iterable<array{string}>
     */
    public static function provideSizes(): iterable
    {
        foreach (['xxs', 'xs', 'sm', 'md', 'lg', 'xl', '2xl'] as $size) {
            yield $size => [$size];
        }
    }

    public function testMergesAttributes(): void
    {
        self::assertHtmlSame(
            '<span class="flag flag-sm flag-country-de me-2" aria-hidden="true" data-lang="de"></span>',
            $this->renderComponent('<twig:Tabler:Flag code="de" size="sm" class="me-2" data-lang="de" />'),
        );
    }
}
