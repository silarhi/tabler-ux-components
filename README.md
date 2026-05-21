# Tabler UX Components

Tabler-flavored Twig UX components for Symfony, following the [shadcn/ui](https://ui.shadcn.com/) composition pattern: every component offers a single all-in-one entry point **and** dedicated sub-components for fine-grained composition.

Built on:

- [Symfony UX Twig Component](https://github.com/symfony/ux-twig-component)
- [`twig/html-extra`](https://twig.symfony.com/doc/3.x/functions/html_cva) — `html_cva()` for variant composition (CVA, à la shadcn)
- [Tabler](https://tabler.io/) + Bootstrap 5

## Installation

```bash
composer require silarhi/tabler-ux-components
```

If your app uses Symfony Flex, the bundle is registered automatically. Otherwise add it to `config/bundles.php`:

```php
return [
    // ...
    Silarhi\TablerUxComponents\TablerUxComponentsBundle::class => ['all' => true],
];
```

Make sure your front-end pulls in Tabler's CSS so the `alert-*` classes resolve.

## Components

### Alert

#### All-in-one usage

```twig
<twig:Tabler:Alert type="success" title="Saved!" description="Your changes are live." />
```

#### Composed usage (with icon)

```twig
<twig:Tabler:Alert type="success">
    <twig:Tabler:Alert:Icon>
        <i class="ti ti-check"></i>
    </twig:Tabler:Alert:Icon>
    <twig:Tabler:Alert:Title>Saved!</twig:Tabler:Alert:Title>
    <twig:Tabler:Alert:Description>
        Your changes are <strong>live</strong>.
    </twig:Tabler:Alert:Description>
</twig:Tabler:Alert>
```

#### Props

| Prop          | Type     | Default     | Description                                                  |
| ------------- | -------- | ----------- | ------------------------------------------------------------ |
| `type`        | string   | `'info'`    | `primary`, `secondary`, `success`, `danger`, `warning`, `info` |
| `style`       | string   | `'default'` | `default` or `important` (filled background)                 |
| `title`       | string?  | `null`      | Optional title; skip when using `<twig:Alert:Title>`         |
| `description` | string?  | `null`      | Optional description; skip when using `<twig:Alert:Description>` |
| `dismissible` | bool     | `false`     | Adds a Bootstrap close button                                |

Extra attributes (e.g. `class`, `data-*`) are forwarded to the root `<div>`.

#### Sub-components

| Tag                                | Purpose                                                    |
| ---------------------------------- | ---------------------------------------------------------- |
| `<twig:Tabler:Alert:Icon>`         | Slot wrapper; put any icon markup inside (Tabler Icons, SVG, ux-icons) |
| `<twig:Tabler:Alert:Title>`        | Renders `<h4 class="alert-title">`                         |
| `<twig:Tabler:Alert:Description>`  | Renders `<div class="text-secondary">`                     |
| `<twig:Tabler:Alert:Dismiss>`      | The close button (rendered automatically when `dismissible`) |

#### Blocks (one per prop)

Each prop has a matching block whose default renders the sub-component with the prop value. Override any block to take fine-grained control while still using the sub-component (and its attributes):

```twig
<twig:Tabler:Alert type="success" title="Saved!">
    <twig:block name="title">
        <twig:Tabler:Alert:Title class="display-6">Custom heading</twig:Tabler:Alert:Title>
    </twig:block>
</twig:Tabler:Alert>
```

| Block         | Default content                                                       |
| ------------- | --------------------------------------------------------------------- |
| `icon`        | empty                                                                 |
| `title`       | `<twig:Tabler:Alert:Title>{{ title }}</twig:Tabler:Alert:Title>` (if `title` prop is set) |
| `description` | `<twig:Tabler:Alert:Description>{{ description }}</twig:Tabler:Alert:Description>` (if `description` prop is set) |
| `content`     | wraps `icon`, `title`, `description`. Replace it to compose freely.   |
| `dismiss`     | `<twig:Tabler:Alert:Dismiss />` (if `dismissible` prop is true)       |

## Design pattern

Each component follows the shadcn composition layout:

```
templates/components/Tabler/
    Alert.html.twig              # Main — all props + block-mirrored sub-components
    Alert/
        Icon.html.twig           # <twig:Tabler:Alert:Icon>
        Title.html.twig          # <twig:Tabler:Alert:Title>
        Description.html.twig    # <twig:Tabler:Alert:Description>
        Dismiss.html.twig        # <twig:Tabler:Alert:Dismiss>
```

Variants are declared with `html_cva()`, which mirrors shadcn's CVA:

```twig
{% set alert = html_cva(
    base: 'alert',
    variants: {
        type: { success: 'alert-success', danger: 'alert-danger', ... },
        style: { default: '', important: 'alert-important' },
        dismissible: { on: 'alert-dismissible', off: '' },
    },
    compound_variants: [
        { style: ['important'], class: 'text-white' },
    ],
) %}

{# Boolean-as-variant: pass through a string key #}
<div class="{{ alert.apply({type, style, dismissible: dismissible ? 'on' : 'off'}, attributes.render('class')) }}">
```

## Roadmap

- [x] Alert
- [ ] Button
- [ ] Badge
- [ ] Card
- [ ] Modal
- [ ] Dropdown

## License

MIT
