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

namespace Silarhi\TablerUxComponents\Tests;

use function count;
use function dirname;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

use function sprintf;
use function strlen;

/**
 * Guards the escaping rules every component template follows.
 *
 * Props are text and are always escaped; markup only comes in through blocks
 * and sub-components. A captured `{% set %}…{% endset %}` block is already
 * escaped and marked safe, so no template ever needs `|raw` — or a way around
 * autoescaping — and any occurrence is a bug waiting to become an XSS.
 *
 * An image URL printed in a CSS `url()` goes through the same backslash
 * escaping (see BackgroundImageTest), so it cannot close the url() and add
 * declarations of its own.
 *
 * Every template also trims its output, so a component used in running text
 * (`Click <twig:Tabler:Badge>New</twig:Tabler:Badge>.`) adds no space around it.
 */
final class TemplateConventionsTest extends TestCase
{
    /** `url(` followed by a variable and the |replace({…}) map that escapes it */
    private const CSS_URL = '/url\\((?:\\{\\{ |\' ~ )\\w+(\\|replace\\(\\{.*?\\}\\))/';

    private const FORBIDDEN = [
        '/\|\s*raw\b/' => 'the |raw filter',
        '/\{%-?\s*autoescape\s+false\b/' => 'an {% autoescape false %} section',
    ];

    /**
     * @return iterable<string, array{string}>
     */
    public static function templateProvider(): iterable
    {
        $root = dirname(__DIR__) . '/templates/components';
        $templates = [];

        /** @var SplFileInfo $file */
        foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS)) as $file) {
            if (str_ends_with($file->getFilename(), '.twig')) {
                $templates[substr($file->getPathname(), strlen($root) + 1)] = $file->getPathname();
            }
        }

        ksort($templates);

        foreach ($templates as $name => $path) {
            yield $name => [$path];
        }
    }

    #[DataProvider('templateProvider')]
    public function testTemplateDoesNotBypassEscaping(string $path): void
    {
        // Doc comments may quote the forbidden syntax to explain it; only the code counts.
        $code = preg_replace('/\{#.*?#\}/s', '', (string) file_get_contents($path)) ?? '';

        foreach (self::FORBIDDEN as $pattern => $what) {
            self::assertDoesNotMatchRegularExpression($pattern, $code, sprintf('Use a block or a sub-component instead of %s.', $what));
        }
    }

    #[DataProvider('templateProvider')]
    public function testTemplateTrimsItsOutput(string $path): void
    {
        // The blank lines between the {% props %} and {% set %} tags, and the final newline, would otherwise be output
        $code = trim(preg_replace('/^\{#.*?#\}/s', '', (string) file_get_contents($path)) ?? '');

        self::assertStringStartsWith('{% apply trim %}', $code, 'Wrap the template, after its header comment, in {% apply trim %}…{% endapply %}.');
        self::assertStringEndsWith('{% endapply %}', $code, 'Wrap the template, after its header comment, in {% apply trim %}…{% endapply %}.');
    }

    #[DataProvider('templateProvider')]
    public function testCssUrlsAreEscaped(string $path): void
    {
        $code = self::code($path);
        preg_match_all(self::CSS_URL, $code, $matches);

        self::assertSame(substr_count($code, 'url('), count($matches[1]), 'Print the value of url() through the |replace({…}) map of Avatar.html.twig.');
        foreach ($matches[1] as $map) {
            self::assertSame(self::cssUrlEscapeMap(), $map, 'Use the same |replace({…}) map as Avatar.html.twig in url().');
        }
    }

    private static function cssUrlEscapeMap(): string
    {
        preg_match(self::CSS_URL, self::code(dirname(__DIR__) . '/templates/components/Tabler/Avatar.html.twig'), $match);

        return $match[1] ?? '';
    }

    /**
     * The template without its comments: doc comments may quote syntax to explain it; only the code counts.
     */
    private static function code(string $path): string
    {
        return preg_replace('/\{#.*?#\}/s', '', (string) file_get_contents($path)) ?? '';
    }
}
