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

namespace Silarhi\TablerUxComponents\DependencyInjection;

use function is_a;
use function is_string;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Twig\Extra\Html\HtmlExtension;

/**
 * Drops the bundle's HtmlExtension (`html_cva()`) when the application already registers one, as TwigExtraBundle does:
 * Twig refuses an extension registered twice.
 *
 * @internal
 */
final class HtmlExtensionPass implements CompilerPassInterface
{
    public const SERVICE_ID = 'tabler_ux_components.twig.html_extension';

    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(self::SERVICE_ID)) {
            return;
        }

        foreach (array_keys($container->findTaggedServiceIds('twig.extension')) as $id) {
            if (self::SERVICE_ID === $id) {
                continue;
            }

            $class = $container->getParameterBag()->resolveValue($container->findDefinition($id)->getClass() ?? $id);
            if (is_string($class) && is_a($class, HtmlExtension::class, true)) {
                $container->removeDefinition(self::SERVICE_ID);

                return;
            }
        }
    }
}
