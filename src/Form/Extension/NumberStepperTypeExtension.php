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
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Adds the `stepper` option to number and integer fields: the Tabler form theme renders them in a `NumberInput`,
 * between a decrease and an increase button (Tabler 1.7+).
 */
final class NumberStepperTypeExtension extends AbstractTypeExtension
{
    public static function getExtendedTypes(): iterable
    {
        return [IntegerType::class, NumberType::class];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->define('stepper')
            ->default(false)
            ->allowedTypes('bool')
            ->info('Whether to render the field between a decrease and an increase button (NumberInput).');
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['tabler_stepper'] = $options['stepper'];
    }
}
