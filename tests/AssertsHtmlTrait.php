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

/**
 * `assertHtmlSame` collapses all whitespace runs so tests can be readable
 * without obsessing over indentation.
 */
trait AssertsHtmlTrait
{
    protected static function assertHtmlSame(string $expected, string $actual, string $message = ''): void
    {
        self::assertSame(
            self::normalizeHtml($expected),
            self::normalizeHtml($actual),
            $message,
        );
    }

    private static function normalizeHtml(string $html): string
    {
        // Treat all whitespace adjacent to tags as insignificant (collapse runs,
        // drop whitespace between/around tag boundaries). Applied to both the
        // expected and actual strings, so comparisons stay structural without
        // being sensitive to template indentation or nested-component newlines.
        $html = preg_replace('/\s+/', ' ', $html) ?? $html;
        $html = preg_replace('/>\s+</', '><', $html) ?? $html;
        $html = preg_replace('/\s+(\/?>)/', '$1', $html) ?? $html;
        $html = preg_replace('/>\s+/', '>', $html) ?? $html;
        $html = preg_replace('/\s+</', '<', $html) ?? $html;

        return trim($html);
    }
}
