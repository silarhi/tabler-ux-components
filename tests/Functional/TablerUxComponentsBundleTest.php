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

namespace Silarhi\TablerUxComponents\Tests\Functional;

use Silarhi\TablerUxComponents\DependencyInjection\HtmlExtensionPass;
use Silarhi\TablerUxComponents\Tests\ComponentTestCase;
use Silarhi\TablerUxComponents\Tests\Fixtures\TestKernel;
use Twig\Environment;
use Twig\Extra\Html\HtmlExtension;

/**
 * The kernel wiring of the bundle: its templates and `html_cva()`, with or without TwigExtraBundle.
 */
final class TablerUxComponentsBundleTest extends ComponentTestCase
{
    public function testRegistersHtmlCvaWithoutTwigExtraBundle(): void
    {
        self::bootKernel(['environment' => TestKernel::WITHOUT_TWIG_EXTRA_BUNDLE]);

        self::assertTrue(self::getContainer()->has(HtmlExtensionPass::SERVICE_ID));
        self::assertTrue($this->getTwig()->hasExtension(HtmlExtension::class));
        self::assertHtmlSame(
            '<div class="alert alert-success alert-important text-white" role="alert"></div>',
            $this->renderComponent('<twig:Tabler:Alert variant="success" important />'),
        );
    }

    public function testLeavesHtmlCvaToTwigExtraBundle(): void
    {
        self::bootKernel();

        self::assertFalse(self::getContainer()->has(HtmlExtensionPass::SERVICE_ID));
        self::assertTrue($this->getTwig()->hasExtension(HtmlExtension::class));
        self::assertHtmlSame(
            '<div class="alert alert-success alert-important text-white" role="alert"></div>',
            $this->renderComponent('<twig:Tabler:Alert variant="success" important />'),
        );
    }

    public function testPrependsTheTemplatesAndTheirNamespace(): void
    {
        self::bootKernel(['environment' => TestKernel::WITHOUT_TWIG_EXTRA_BUNDLE]);

        $loader = $this->getTwig()->getLoader();
        self::assertTrue($loader->exists('components/Tabler/Alert.html.twig'));
        self::assertTrue($loader->exists('@TablerUxComponents/form/tabler_layout.html.twig'));
    }

    private function getTwig(): Environment
    {
        /** @var Environment $twig */
        $twig = self::getContainer()->get('twig');

        return $twig;
    }
}
