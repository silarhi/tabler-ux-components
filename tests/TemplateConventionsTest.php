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
 *
 * Every template also trims its output, so a component used in running text
 * (`Click <twig:Tabler:Badge>New</twig:Tabler:Badge>.`) adds no space before
 * it, then ends with one line break (see testTemplateTrimsItsOutput()).
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

    #[DataProvider('templateProvider')]
    public function testTemplateTrimsItsOutput(string $path): void
    {
        // The blank lines between the {% props %} and {% set %} tags would otherwise be output. The file's final
        // newline is: Twig drops the one after "%}" but not after "~%}". It stands in for the newline Twig drops
        // after the {% endcomponent %} a </twig:Tabler:…> closing tag compiles to, so components on consecutive
        // lines stay apart; drop the "~" once ux-twig-component keeps that newline itself.
        $code = (string) preg_replace('/^\{#.*?#\}\n/s', '', (string) file_get_contents($path));
        $message = 'Wrap the template, after its header comment, in {% apply trim %}…{% endapply ~%} and end the file with a newline.';

        self::assertStringStartsWith('{% apply trim %}', $code, $message);
        self::assertStringEndsWith("\n{% endapply ~%}\n", $code, $message);
    }
}
