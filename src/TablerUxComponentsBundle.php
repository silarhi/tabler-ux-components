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

use Silarhi\TablerUxComponents\Twig\EnvironmentConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

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
 *
 * It also replaces ux-twig-component's lexer with one that keeps the line
 * break after a </twig:Tabler:…> closing tag (see Twig\ComponentLexer).
 */
final class TablerUxComponentsBundle extends AbstractBundle
{
    public function prependExtension(ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->extension('twig', [
            'paths' => [
                __DIR__ . '/../templates' => null,
            ],
        ]);
    }

    /**
     * @param array<mixed> $config
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        // A lower priority than ux-twig-component's own decorator (2.x) wraps it, so this lexer is set last
        $container->services()
            ->set('silarhi_tabler_ux_components.twig.environment_configurator', EnvironmentConfigurator::class)
            ->decorate('twig.configurator.environment', priority: -10)
            ->args([[service('.inner'), 'configure']]);
    }
}
