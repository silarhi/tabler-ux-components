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

use Silarhi\TablerUxComponents\DependencyInjection\HtmlExtensionPass;
use Silarhi\TablerUxComponents\Form\Extension\ChoiceStyleTypeExtension;
use Silarhi\TablerUxComponents\Form\Extension\InputIconTypeExtension;
use Silarhi\TablerUxComponents\Form\Extension\NumberStepperTypeExtension;
use Silarhi\TablerUxComponents\Form\Extension\SwitchTypeExtension;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\Form\FormTypeExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Twig\Extra\Html\HtmlExtension;

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
 * It registers twig/html-extra's HtmlExtension (`html_cva()`, which the
 * components use) unless the application already does, as TwigExtraBundle
 * does. With symfony/form, it also registers the form type extensions behind
 * the options of the Tabler form themes (templates/form/).
 *
 * Only a kernel loads this class: without one, register the templates and the
 * extensions in a plain Twig environment (see the README).
 */
final class TablerUxComponentsBundle extends AbstractBundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        // After the autoconfiguration (100) and before TwigBundle collects the extensions (0)
        $container->addCompilerPass(new HtmlExtensionPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 1);
    }

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
        $services = $container->services();
        // Removed by HtmlExtensionPass when the application registers one (TwigExtraBundle)
        $services->set(HtmlExtensionPass::SERVICE_ID, HtmlExtension::class)->tag('twig.extension');

        if (!interface_exists(FormTypeExtensionInterface::class)) {
            return;
        }

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
