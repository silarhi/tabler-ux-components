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
use function is_callable;
use function is_string;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\ChoiceList\ChoiceListInterface;
use Symfony\Component\Form\ChoiceList\View\ChoiceGroupView;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Adds the `choice_style` and `choice_icon` options to expanded choices: the Tabler form theme renders their radios
 * or checkboxes as a `SegmentedControl` (`segmented`) or a `Selectgroup` (`selectgroup`, `pills`, `boxes`).
 */
final class ChoiceStyleTypeExtension extends AbstractTypeExtension
{
    public const STYLES = ['segmented', 'selectgroup', 'pills', 'boxes'];

    public static function getExtendedTypes(): iterable
    {
        return [ChoiceType::class];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->define('choice_style')
            ->default(null)
            ->allowedValues(null, ...self::STYLES)
            ->info('How an expanded choice is rendered: segmented, selectgroup, pills or boxes; null for the Bootstrap checks.');

        $resolver
            ->define('choice_icon')
            ->default(null)
            ->allowedTypes('array', 'callable', 'null')
            ->info('The icon of each choice, as an array keyed like the choices (as choice_attr) or a callable(choice, key, value).');
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['tabler_choice_style'] = true === $options['expanded'] ? $options['choice_style'] : null;
        $view->vars['tabler_choice_icons'] = [];

        $icon = $options['choice_icon'];
        $choices = $view->vars['choices'] ?? null;
        if (!is_array($icon) && !is_callable($icon) || !is_array($choices)) {
            return;
        }

        // The keys of the `choices` option, by choice value, as `choice_attr` gets them
        $choiceList = $form->getConfig()->getAttribute('choice_list');
        $keys = $choiceList instanceof ChoiceListInterface ? $choiceList->getOriginalKeys() : [];

        $icons = [];
        foreach (self::flatten($choices) as $choice) {
            $key = $keys[$choice->value] ?? $choice->value;
            $name = is_callable($icon) ? $icon($choice->data, $key, $choice->value) : ($icon[$key] ?? null);
            if (is_string($name) && '' !== $name) {
                $icons[$choice->value] = $name;
            }
        }

        $view->vars['tabler_choice_icons'] = $icons;
    }

    /**
     * @param array<mixed> $choices
     *
     * @return iterable<ChoiceView>
     */
    private static function flatten(array $choices): iterable
    {
        foreach ($choices as $choice) {
            if ($choice instanceof ChoiceGroupView) {
                yield from self::flatten($choice->choices);
            } elseif ($choice instanceof ChoiceView) {
                yield $choice;
            }
        }
    }
}
