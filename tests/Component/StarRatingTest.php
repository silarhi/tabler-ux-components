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

final class StarRatingTest extends ComponentTestCase
{
    public function testDefault(): void
    {
        $star = '<i class="ti ti-star" aria-hidden="true"></i>';

        self::assertHtmlSame(
            '<div class="stars" role="img" aria-label="4 out of 5">'
            . str_repeat('<span class="star text-yellow">' . $star . '</span>', 4)
            . '<span class="star">' . $star . '</span>'
            . '</div>',
            $this->renderComponent('<twig:Tabler:StarRating value="4" />'),
        );
    }

    public function testMaxVariantIconAndLabel(): void
    {
        $heart = '<i class="ti ti-heart-filled" aria-hidden="true"></i>';

        self::assertHtmlSame(
            '<div class="stars mb-1" role="img" aria-label="1 of 3 hearts">'
            . '<span class="star text-red">' . $heart . '</span>'
            . '<span class="star">' . $heart . '</span>'
            . '<span class="star">' . $heart . '</span>'
            . '</div>',
            $this->renderComponent('<twig:Tabler:StarRating value="1" max="3" variant="red" icon="heart-filled" class="mb-1" aria-label="1 of 3 hearts" />'),
        );
    }

    public function testComposed(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:StarRating aria-label="1 out of 2">
                <twig:Tabler:StarRating:Star active variant="orange" />
                <twig:Tabler:StarRating:Star>*</twig:Tabler:StarRating:Star>
            </twig:Tabler:StarRating>
            TWIG);

        self::assertHtmlSame(
            '<div class="stars" role="img" aria-label="1 out of 2">'
            . '<span class="star text-orange"><i class="ti ti-star" aria-hidden="true"></i></span>'
            . '<span class="star">*</span>'
            . '</div>',
            $html,
        );
    }

    public function testZeroMaxRendersNoStars(): void
    {
        // Twig's 1..0 is [1, 0]: without a guard this rendered two stars
        self::assertHtmlSame('<div class="stars" role="img" aria-label="0 out of 0"></div>', $this->renderComponent('<twig:Tabler:StarRating max="0" />'));
    }

    public function testFilledStars(): void
    {
        $star = '<i class="ti-filled ti-filled-star" aria-hidden="true"></i>';

        self::assertHtmlSame(
            '<div class="stars" role="img" aria-label="1 out of 2"><span class="star text-yellow">' . $star . '</span><span class="star">' . $star . '</span></div>',
            $this->renderComponent('<twig:Tabler:StarRating value="1" max="2" filled />'),
        );
        self::assertHtmlSame(
            '<span class="star text-red"><i class="ti-filled ti-filled-heart" aria-hidden="true"></i></span>',
            $this->renderComponent('<twig:Tabler:StarRating:Star active variant="red" icon="heart" filled />'),
        );
    }
}
