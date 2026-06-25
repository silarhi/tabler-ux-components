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

final class CarouselTest extends ComponentTestCase
{
    public function testComposedDefault(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Carousel id="gallery">
                <twig:Tabler:Carousel:Item active><img src="/1.jpg" alt=""></twig:Tabler:Carousel:Item>
                <twig:Tabler:Carousel:Item><img src="/2.jpg" alt=""></twig:Tabler:Carousel:Item>
            </twig:Tabler:Carousel>
            TWIG);

        self::assertHtmlSame(
            '<div id="gallery" class="carousel slide" data-bs-ride="carousel">'
            . '<div class="carousel-inner">'
            . '<div class="carousel-item active"><img src="/1.jpg" alt=""></div>'
            . '<div class="carousel-item"><img src="/2.jpg" alt=""></div>'
            . '</div>'
            . '</div>',
            $html,
        );
    }

    public function testAllInOneWithIndicatorsAndControls(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:Carousel id="hero" controls indicators="2">
                <twig:Tabler:Carousel:Item active><img src="/1.jpg" alt=""></twig:Tabler:Carousel:Item>
                <twig:Tabler:Carousel:Item><img src="/2.jpg" alt=""></twig:Tabler:Carousel:Item>
            </twig:Tabler:Carousel>
            TWIG);

        self::assertHtmlSame(
            '<div id="hero" class="carousel slide" data-bs-ride="carousel">'
            . '<div class="carousel-indicators">'
            . '<button type="button" data-bs-target="#hero" data-bs-slide-to="0" aria-label="Slide 1" aria-current="true" class="active"></button>'
            . '<button type="button" data-bs-target="#hero" data-bs-slide-to="1" aria-label="Slide 2"></button>'
            . '</div>'
            . '<div class="carousel-inner">'
            . '<div class="carousel-item active"><img src="/1.jpg" alt=""></div>'
            . '<div class="carousel-item"><img src="/2.jpg" alt=""></div>'
            . '</div>'
            . '<a class="carousel-control-prev" data-bs-target="#hero" role="button" data-bs-slide="prev">'
            . '<span class="carousel-control-prev-icon" aria-hidden="true"></span>'
            . '<span class="visually-hidden">Previous</span></a>'
            . '<a class="carousel-control-next" data-bs-target="#hero" role="button" data-bs-slide="next">'
            . '<span class="carousel-control-next-icon" aria-hidden="true"></span>'
            . '<span class="visually-hidden">Next</span></a>'
            . '</div>',
            $html,
        );
    }

    public function testFadeWithoutAutoplay(): void
    {
        // Booleans must be passed as real values (not the HTML "false" string),
        // so use the {% component %} tag to disable `ride`.
        $html = $this->renderComponent(<<<TWIG
            {% component 'Tabler:Carousel' with {id: 'x', fade: true, ride: false} %}
                {% block content %}<twig:Tabler:Carousel:Item active>A</twig:Tabler:Carousel:Item>{% endblock %}
            {% endcomponent %}
            TWIG);

        self::assertHtmlSame(
            '<div id="x" class="carousel slide carousel-fade">'
            . '<div class="carousel-inner"><div class="carousel-item active">A</div></div>'
            . '</div>',
            $html,
        );
    }

    public function testIndicatorsWithDotsAppearance(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Carousel:Indicators target="hero" count="2" appearance="dots" />');

        self::assertHtmlSame(
            '<div class="carousel-indicators carousel-indicators-dot">'
            . '<button type="button" data-bs-target="#hero" data-bs-slide-to="0" aria-label="Slide 1" aria-current="true" class="active"></button>'
            . '<button type="button" data-bs-target="#hero" data-bs-slide-to="1" aria-label="Slide 2"></button>'
            . '</div>',
            $html,
        );
    }

    public function testThumbnailIndicator(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Carousel:Indicator target="hero" slideTo="1" image="/thumb.jpg" />');

        self::assertHtmlSame(
            '<button type="button" data-bs-target="#hero" data-bs-slide-to="1" aria-label="Slide 2"'
            . ' style="background-image: url(/thumb.jpg)" class="ratio ratio-4x3"></button>',
            $html,
        );
    }

    public function testControl(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Carousel:Control target="hero" direction="next" />');

        self::assertHtmlSame(
            '<a class="carousel-control-next" data-bs-target="#hero" role="button" data-bs-slide="next">'
            . '<span class="carousel-control-next-icon" aria-hidden="true"></span>'
            . '<span class="visually-hidden">Next</span></a>',
            $html,
        );
    }

    public function testCaptionWithBackground(): void
    {
        $html = $this->renderComponent('<twig:Tabler:Carousel:Caption background><h3>Label</h3></twig:Tabler:Carousel:Caption>');

        self::assertHtmlSame(
            '<div class="carousel-caption-background"></div>'
            . '<div class="carousel-caption"><h3>Label</h3></div>',
            $html,
        );
    }
}
