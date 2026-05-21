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

namespace Silarhi\TablerUxComponents;

use function dirname;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

/**
 * Tabler-flavored Twig UX components for Symfony.
 *
 * Components live under templates/components/Tabler/ and are invoked
 * with the `Tabler:` prefix, e.g. <twig:Tabler:Alert>.
 *
 * The bundle prepends its templates/ dir as a non-namespaced Twig path
 * so ux-twig-component's anonymous component finder discovers everything
 * under components/Tabler/.
 */
final class TablerUxComponentsBundle extends AbstractBundle
{
    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->extension('twig', [
            'paths' => [
                dirname(__DIR__) . '/templates' => null,
            ],
        ]);
    }
}
