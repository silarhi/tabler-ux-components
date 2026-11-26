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

use Silarhi\TablerUxComponents\Form\Extension\ChoiceStyleTypeExtension;
use Silarhi\TablerUxComponents\Form\Extension\InputIconTypeExtension;
use Silarhi\TablerUxComponents\Form\Extension\NumberStepperTypeExtension;
use Silarhi\TablerUxComponents\Form\Extension\SwitchTypeExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Form\FormTypeExtensionInterface;
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
 * With symfony/form, it also registers the form type extensions behind the
 * options of the Tabler form themes (templates/form/).
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
        if (!interface_exists(FormTypeExtensionInterface::class)) {
            return;
        }

        $services = $container->services();
        foreach ([
            ChoiceStyleTypeExtension::class,
            InputIconTypeExtension::class,
            NumberStepperTypeExtension::class,
            SwitchTypeExtension::class,
        ] as $extension) {
            $services->set($extension)->tag('form.type_extension');
        }
    }
}
