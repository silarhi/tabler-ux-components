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

final class ImageLabelTest extends ComponentTestCase
{
    public function testAllInOne(): void
    {
        self::assertHtmlSame(
            '<div class="img-labeled"><img src="/book.jpg" alt="A book"><span class="img-label">AI</span></div>',
            $this->renderComponent('<twig:Tabler:ImageLabel src="/book.jpg" alt="A book" label="AI" />'),
        );
    }

    public function testAllInOneWithIconPositionAndVariant(): void
    {
        self::assertHtmlSame(
            '<div class="img-labeled extra" id="video"><img src="/video.jpg" alt="Intro">'
            . '<span class="img-label img-label-top-start bg-danger text-danger-fg"><i class="ti ti-player-play"></i> 1:24</span></div>',
            $this->renderComponent('<twig:Tabler:ImageLabel src="/video.jpg" alt="Intro" label="1:24" icon="player-play" position="top-start" variant="danger" class="extra" id="video" />'),
        );
    }

    public function testWithoutLabelRendersOnlyTheImage(): void
    {
        self::assertHtmlSame(
            '<div class="img-labeled"><img src="/book.jpg" alt=""></div>',
            $this->renderComponent('<twig:Tabler:ImageLabel src="/book.jpg" />'),
        );
    }

    public function testComposedWithSeveralLabels(): void
    {
        $html = $this->renderComponent(<<<TWIG
            <twig:Tabler:ImageLabel>
                <twig:Tabler:ImageLabel:Image src="/live.jpg" alt="Live" class="rounded" width="320" />
                <twig:Tabler:ImageLabel:Label position="top-start" variant="danger">Live</twig:Tabler:ImageLabel:Label>
                <twig:Tabler:ImageLabel:Label icon="crown" label="Premium" iconOnly position="top-end" />
                <twig:Tabler:ImageLabel:Label>AI<span class="visually-hidden"> generated</span></twig:Tabler:ImageLabel:Label>
            </twig:Tabler:ImageLabel>
            TWIG);

        self::assertHtmlSame(
            '<div class="img-labeled">'
            . '<img src="/live.jpg" alt="Live" class="rounded" width="320">'
            . '<span class="img-label img-label-top-start bg-danger text-danger-fg">Live</span>'
            . '<span class="img-label img-label-icon img-label-top-end"><i class="ti ti-crown"></i><span class="visually-hidden">Premium</span></span>'
            . '<span class="img-label">AI<span class="visually-hidden"> generated</span></span>'
            . '</div>',
            $html,
        );
    }

    #[DataProvider('providePositions')]
    public function testPositions(string $position, string $class): void
    {
        self::assertHtmlSame(
            sprintf('<span class="%s">New</span>', $class),
            $this->renderComponent(sprintf('<twig:Tabler:ImageLabel:Label position="%s" label="New" />', $position)),
        );
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function providePositions(): iterable
    {
        yield 'top-start' => ['top-start', 'img-label img-label-top-start'];
        yield 'top-end' => ['top-end', 'img-label img-label-top-end'];
        yield 'bottom-start' => ['bottom-start', 'img-label img-label-bottom-start'];
        yield 'bottom-end' => ['bottom-end', 'img-label'];
    }

    #[DataProvider('provideVariants')]
    public function testVariants(string $variant): void
    {
        self::assertHtmlSame(
            sprintf('<span class="img-label bg-%1$s text-%1$s-fg">New</span>', $variant),
            $this->renderComponent(sprintf('<twig:Tabler:ImageLabel:Label variant="%s">New</twig:Tabler:ImageLabel:Label>', $variant)),
        );
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideVariants(): iterable
    {
        foreach (['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark', 'light'] as $variant) {
            yield $variant => [$variant];
        }
    }

    public function testLabelMergesAttributes(): void
    {
        self::assertHtmlSame(
            '<span class="img-label fs-3" style="--tblr-img-label-offset: 0.75rem">Sponsored</span>',
            $this->renderComponent('<twig:Tabler:ImageLabel:Label class="fs-3" style="--tblr-img-label-offset: 0.75rem">Sponsored</twig:Tabler:ImageLabel:Label>'),
        );
    }
}
