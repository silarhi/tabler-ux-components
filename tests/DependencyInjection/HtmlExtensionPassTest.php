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

namespace Silarhi\TablerUxComponents\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Silarhi\TablerUxComponents\DependencyInjection\HtmlExtensionPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Twig\Extension\CoreExtension;
use Twig\Extra\Html\HtmlExtension;

/**
 * Needs symfony/dependency-injection: the "PHPUnit without the bundle dependencies" CI job removes it and excludes
 * this group.
 */
#[Group('bundle')]
final class HtmlExtensionPassTest extends TestCase
{
    public function testKeepsTheExtensionWhenTheApplicationHasNone(): void
    {
        $container = $this->createContainer();
        $container->register('app.twig.extension', CoreExtension::class)->addTag('twig.extension');

        (new HtmlExtensionPass())->process($container);

        self::assertTrue($container->hasDefinition(HtmlExtensionPass::SERVICE_ID));
    }

    public function testDropsTheExtensionWhenTwigExtraBundleRegistersOne(): void
    {
        $container = $this->createContainer();
        $container->register('twig.extension.html', HtmlExtension::class)->addTag('twig.extension');

        (new HtmlExtensionPass())->process($container);

        self::assertFalse($container->hasDefinition(HtmlExtensionPass::SERVICE_ID));
    }

    public function testDropsTheExtensionWhenTheApplicationRegistersOneByItsClass(): void
    {
        $container = $this->createContainer();
        $container->setParameter('app.html_extension.class', HtmlExtension::class);
        $container->register(HtmlExtension::class)->addTag('twig.extension');
        $container->register('app.html_extension', '%app.html_extension.class%')->addTag('twig.extension');

        (new HtmlExtensionPass())->process($container);

        self::assertFalse($container->hasDefinition(HtmlExtensionPass::SERVICE_ID));
    }

    public function testIgnoresAnUntaggedExtension(): void
    {
        $container = $this->createContainer();
        $container->register('app.html_extension', HtmlExtension::class);

        (new HtmlExtensionPass())->process($container);

        self::assertTrue($container->hasDefinition(HtmlExtensionPass::SERVICE_ID));
    }

    private function createContainer(): ContainerBuilder
    {
        $container = new ContainerBuilder();
        $container->register(HtmlExtensionPass::SERVICE_ID, HtmlExtension::class)->addTag('twig.extension');

        return $container;
    }
}
