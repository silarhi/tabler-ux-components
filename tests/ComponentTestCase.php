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
 */
abstract class ComponentTestCase extends KernelTestCase
{
    use AssertsHtmlTrait;

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
}
