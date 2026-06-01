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

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Twig\Environment;

/**
 * Base class for component tests.
 *
 * Renders Twig template strings against the booted test kernel so each test
 * exercises the real component-resolution pipeline (template paths, anonymous
 * component discovery, html_cva, attribute forwarding, …).
 *
 * `assertHtmlSame` collapses all whitespace runs so tests can be readable
 * without obsessing over indentation.
 */
abstract class ComponentTestCase extends KernelTestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        self::ensureKernelShutdown();
    }

    /**
     * @param array<string, mixed> $context
     */
    protected function renderComponent(string $template, array $context = []): string
    {
        /** @var Environment $twig */
        $twig = self::getContainer()->get('twig');

        return $twig->createTemplate($template)->render($context);
    }

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
