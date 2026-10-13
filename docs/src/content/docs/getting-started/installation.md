---
title: Installation
description: Install Tabler UX Components in a Symfony application and load Tabler on the front-end.
sidebar:
    order: 1
---

## Requirements

| Dependency                                                                                    | Version         |
| --------------------------------------------------------------------------------------------- | --------------- |
| PHP                                                                                           | 8.2+            |
| Symfony (`framework-bundle`, `twig-bundle`)                                                   | 6.4 / 7.x / 8.x |
| [Symfony UX Twig Component](https://symfony.com/bundles/ux-twig-component/current/index.html) | 2.21+ / 3.x     |
| Twig (`twig/twig`)                                                                            | 3.15+ / 4.x     |
| Twig extensions (`twig/extra-bundle`, `twig/html-extra`)                                      | 3.12+ / 4.x     |

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

The components live under `components/Tabler/` and are resolved by Twig Component's anonymous component finder. On
**ux-twig-component v3**, `twig_component.defaults` and `twig_component.anonymous_template_directory` must be configured
explicitly (on v2 they are optional). The Flex recipe already does it:

```yaml
# config/packages/twig_component.yaml
twig_component:
    anonymous_template_directory: 'components/'
    defaults:
        App\Twig\Components\: 'components/'
```

## Front-end

Your app must load [Tabler](https://tabler.io/) **1.6+** (`@tabler/core`): its CSS, and `tabler.js` for the
interactive components (Modal, Dropdown, Carousel, Tabs, Offcanvas, Tooltip, Popover, Clipboard, Sparkline…).

```bash
yarn add @tabler/core @tabler/icons-webfont
```

```js
// assets/app.js
import '@tabler/core/dist/css/tabler.min.css'
import '@tabler/icons-webfont/dist/tabler-icons.min.css'
import '@tabler/core'
```

:::caution
Since Tabler 1.5, `tabler.js` bundles Bootstrap's JavaScript: do not load `bootstrap.js` next to it.
:::

[`Icon`](/components/content/icon/) and the `icon` props expect the [`@tabler/icons-webfont`](https://tabler.io/icons)
font. Filled icons (`<twig:Tabler:Icon filled>`) need its filled font as well, compiled under its own prefix: see
[Filled](/components/content/icon/#filled).

## First component

```twig
<twig:Tabler:Alert variant="success" title="Saved!" description="Your changes are live." />
```

Every component is documented with a live preview, its Twig source and the HTML it renders. Read
[Composition](/getting-started/composition/) first: all components share the same building blocks.
