---
title: Form theme
description: Render Symfony forms with Tabler's markup, input icons, number steppers, segmented controls and select groups.
sidebar:
    order: 3
---

The bundle ships two [Symfony form themes](https://symfony.com/doc/current/form/form_themes.html) built on Symfony's
Bootstrap 5 themes, so every field keeps the Bootstrap markup Tabler styles, plus:

- Tabler's hints (`<small class="form-hint">`) for the `help` option;
- form options for Tabler's widgets: `icon`, `stepper`, `choice_style` and `switch`, rendered with the components of
  this bundle ([InputIcon](/components/forms/input-icon/), [NumberInput](/components/forms/number-input/),
  [SegmentedControl](/components/actions/segmented-control/#in-a-form), [Selectgroup](/components/forms/selectgroup/)),
  so a field looks the same in a Symfony form and in a hand-written one.

The form themes need `symfony/form`; the options are added by form type extensions that the bundle registers when it is
installed. They are not part of the Symfony UX Toolkit kit, which only installs components.

## Setup

Pick a theme for every form of the app:

```yaml
# config/packages/twig.yaml
twig:
    form_themes: ['@TablerUxComponents/form/tabler_layout.html.twig']
```

`tabler_horizontal_layout.html.twig` puts the labels in a column beside their fields (`col-sm-2`, then `col-sm-10`), as
Symfony's `bootstrap_5_horizontal_layout.html.twig` does. Override its `form_label_class` and `form_group_class` blocks
to change the widths. A theme can also apply to a single form:

```twig
{% form_theme form '@TablerUxComponents/form/tabler_horizontal_layout.html.twig' %}

{{ form(form) }}
```

Everything else is Symfony's Bootstrap 5 theme: `row_attr: {class: 'form-floating'}` for floating labels,
`label_attr: {class: 'checkbox-inline'}` for inline checks, input groups, validation messages… Required fields get
Tabler's red asterisk from the `required` class Symfony adds to their label.

## Input icons

`icon` puts an icon in the field, at the end, or at the start with `icon_position: 'start'`. It takes a Tabler icon name,
or a name with an icon set prefix (`lucide:search`) with [Symfony UX Icons](/components/content/icon/). `loader: true`
shows a spinner instead, for a field that is checking its value.

```php
$builder
    ->add('email', EmailType::class, ['icon' => 'mail', 'icon_position' => 'start'])
    ->add('search', SearchType::class, ['icon' => 'search', 'help' => 'Search by name or email.'])
    ->add('username', TextType::class, ['loader' => true]);
```

```html
<div class="mb-3">
    <label for="form_email" class="form-label required">Email</label>
    <div class="input-icon">
        <span class="input-icon-addon"><i class="ti ti-mail"></i></span>
        <input type="email" id="form_email" name="form[email]" required="required" class="form-control" />
    </div>
</div>
```

Any field rendered as a single input takes it: text, email, password, search, URL, a date or a time with
`widget: 'single_text'`… Hidden fields ignore it.

## Number stepper

`stepper: true` on an `IntegerType` or a `NumberType` renders the field between a decrease and an increase button, with
Tabler's number input (`data-bs-toggle="number-input"`, Tabler 1.7+). `tabler.js` keeps the value within the `min` and
`max` attributes and rounds it to `step`:

```php
$builder->add('seats', IntegerType::class, [
    'stepper' => true,
    'attr' => ['min' => 1, 'max' => 20],
]);
```

```html
<div class="number-input" data-bs-toggle="number-input">
    <button type="button" class="btn btn-icon" data-bs-number-input-action="decrement" aria-label="Decrease"></button>
    <input type="number" id="form_seats" name="form[seats]" required="required" min="1" max="20" class="form-control" />
    <button type="button" class="btn btn-icon" data-bs-number-input-action="increment" aria-label="Increase"></button>
</div>
```

A disabled field disables its buttons too. The stepper takes the place of an `icon`.

## Segmented controls and select groups

`choice_style` changes how an expanded `ChoiceType` (`expanded: true`, and its subtypes such as `EnumType`) renders its
radios, or its checkboxes with `multiple: true`:

| `choice_style` | Renders                                                                                         |
| -------------- | ----------------------------------------------------------------------------------------------- |
| `segmented`    | A [SegmentedControl](/components/actions/segmented-control/#in-a-form) of radio segments        |
| `selectgroup`  | A [Selectgroup](/components/forms/selectgroup/): options styled as buttons (`form-selectgroup`) |
| `pills`        | A Selectgroup of pills (`form-selectgroup-pills`)                                               |
| `boxes`        | A Selectgroup of boxes with a check mark (`form-selectgroup-boxes`)                             |

Without `choice_style`, or on a choice that is not expanded, the field keeps Bootstrap's checks or `<select>`.

```php
$builder
    ->add('period', ChoiceType::class, [
        'choices' => ['Day' => 'day', 'Week' => 'week', 'Month' => 'month'],
        'expanded' => true,
        'choice_style' => 'segmented',
        'choice_icon' => ['Day' => 'sun', 'Week' => 'calendar-week', 'Month' => 'calendar'],
    ])
    ->add('tags', ChoiceType::class, [
        'choices' => ['Bug' => 'bug', 'Feature' => 'feature', 'Docs' => 'docs'],
        'expanded' => true,
        'multiple' => true,
        'choice_style' => 'pills',
    ]);
```

```html
<fieldset class="mb-3">
    <legend class="col-form-label required">Period</legend>
    <nav class="nav nav-segmented" role="radiogroup" id="form_period">
        <input
            type="radio"
            class="nav-link-input btn-check d-block"
            id="form_period_0"
            name="form[period]"
            value="day"
            required
            autocomplete="off"
        />
        <label class="nav-link" for="form_period_0"><i class="ti ti-sun nav-link-icon"></i>Day</label>
        <!-- … -->
    </nav>
</fieldset>
```

`choice_icon` gives each choice an icon: an array keyed like the `choices` option (as `choice_attr`), or a callable
receiving the choice, its key and its value, like `choice_attr`'s. The labels are translated with
`choice_translation_domain`, and `choice_attr` goes on each input. The field's `attr` goes on the control:
`attr: {class: 'w-100 nav-sm'}` stretches a segmented control and makes it small, `attr: {class:
'form-selectgroup-vertical'}` stacks a select group.

## Switches

`switch: true` on a `CheckboxType` renders it as a toggle switch (`form-check form-switch`). It adds Symfony's
`checkbox-switch` label class, so it works with the Bootstrap 5 themes too.

```php
$builder->add('notifications', CheckboxType::class, ['switch' => true, 'required' => false]);
```

## Options

| Option          | Types                       | Default | Description                                                           |
| --------------- | --------------------------- | ------- | --------------------------------------------------------------------- |
| `icon`          | every field                 | `null`  | An icon in the field (`InputIcon`)                                    |
| `icon_position` | every field                 | `'end'` | `start` or `end`                                                      |
| `loader`        | every field                 | `false` | A spinner in the field instead of the icon                            |
| `stepper`       | `IntegerType`, `NumberType` | `false` | Decrease and increase buttons (`NumberInput`, Tabler 1.7+)            |
| `choice_style`  | `ChoiceType`                | `null`  | `segmented`, `selectgroup`, `pills` or `boxes`, when `expanded`       |
| `choice_icon`   | `ChoiceType`                | `null`  | The icon of each choice: an array keyed like `choices`, or a callable |
| `switch`        | `CheckboxType`              | `false` | A toggle switch (`form-switch`)                                       |

The theme blocks are in `templates/form/tabler_widgets.html.twig`, shared by both themes: override them in your own form
theme, used after the Tabler one, to change a widget.
