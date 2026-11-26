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

namespace Silarhi\TablerUxComponents\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Adds the `icon`, `icon_position` and `loader` options: the Tabler form theme renders the input in an
 * `InputIcon` (`.input-icon`), with the icon, or a spinner, at the start or the end of the field.
 */
final class InputIconTypeExtension extends AbstractTypeExtension
{
    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->define('icon')
            ->default(null)
            ->allowedTypes('string', 'null')
            ->info('A Tabler icon name, or a name with an icon set prefix (lucide:search), shown in the field.');

        $resolver
            ->define('icon_position')
            ->default('end')
            ->allowedValues('start', 'end')
            ->info('Where the icon or the spinner goes in the field.');

        $resolver
            ->define('loader')
            ->default(false)
            ->allowedTypes('bool')
            ->info('Whether to show a spinner in the field instead of the icon.');
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['tabler_icon'] = $options['icon'];
        $view->vars['tabler_icon_position'] = $options['icon_position'];
        $view->vars['tabler_loader'] = $options['loader'];
    }
}
