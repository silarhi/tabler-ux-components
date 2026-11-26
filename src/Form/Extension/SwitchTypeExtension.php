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

use function is_array;
use function is_string;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Adds the `switch` option to checkboxes, rendered as a toggle switch (`.form-switch`) by the Bootstrap 5 form
 * themes and the Tabler ones that build on them.
 */
final class SwitchTypeExtension extends AbstractTypeExtension
{
    public static function getExtendedTypes(): iterable
    {
        return [CheckboxType::class];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->define('switch')
            ->default(false)
            ->allowedTypes('bool')
            ->info('Whether to render the checkbox as a toggle switch.');
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        if (true !== $options['switch']) {
            return;
        }

        $labelAttr = is_array($view->vars['label_attr'] ?? null) ? $view->vars['label_attr'] : [];
        $class = is_string($labelAttr['class'] ?? null) ? $labelAttr['class'] : '';
        if (!str_contains($class, 'checkbox-switch')) {
            $labelAttr['class'] = trim($class . ' checkbox-switch');
        }
        $view->vars['label_attr'] = $labelAttr;
    }
}
