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
 */
final class TemplateConventionsTest extends TestCase
{
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
}
