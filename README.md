<p align="center">
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://img.shields.io/github/license/silarhi/tabler-ux-components?style=for-the-badge&color=6f42c1&labelColor=1a1a2e">
        <img src="https://img.shields.io/github/license/silarhi/tabler-ux-components?style=for-the-badge&color=6f42c1" alt="License">
    </picture>
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://img.shields.io/badge/php-%3E%3D8.2-777bb4?style=for-the-badge&labelColor=1a1a2e">
        <img src="https://img.shields.io/badge/php-%3E%3D8.2-777bb4?style=for-the-badge" alt="PHP Version">
    </picture>
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://img.shields.io/github/actions/workflow/status/silarhi/tabler-ux-components/continuous-integration.yml?style=for-the-badge&label=CI&color=20c997&labelColor=1a1a2e">
        <img src="https://img.shields.io/github/actions/workflow/status/silarhi/tabler-ux-components/continuous-integration.yml?style=for-the-badge&label=CI&color=20c997"
            alt="CI Status">
    </picture>
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://img.shields.io/endpoint?url=https%3A%2F%2Fraw.githubusercontent.com%2Fsilarhi%2Ftabler-ux-components%2Fbadges%2Fcoverage.json&style=for-the-badge&labelColor=1a1a2e">
        <img src="https://img.shields.io/endpoint?url=https%3A%2F%2Fraw.githubusercontent.com%2Fsilarhi%2Ftabler-ux-components%2Fbadges%2Fcoverage.json&style=for-the-badge" alt="Coverage">
    </picture>
</p>

<h1 align="center">Tabler UX Components</h1>

<p align="center">
    <strong>Tabler-flavored Twig UX components for Symfony.</strong><br>
    Built on the <a href="https://ui.shadcn.com/">shadcn/ui</a> composition pattern: one all-in-one tag per component, plus sub-components when you need control.
</p>

---

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Components](#components)
    - [Alert](#alert)
    - [Button](#button)
    - [Badge](#badge)
    - [Card](#card)
    - [Modal](#modal)
    - [Avatar / Spinner / Status / Divider](#avatar--spinner--status--divider)
    - [Progress](#progress)
    - [Breadcrumb / Pagination](#breadcrumb--pagination)
    - [Dropdown](#dropdown)
    - [Carousel](#carousel)
    - [Nav](#nav)
    - [More components](#more-components)
    - [Layout: PageHeader / Navbar / Prose](#layout-pageheader--navbar--prose)
    - [Not included](#not-included)
- [Design Pattern](#design-pattern)
- [Testing & Quality](#testing--quality)
- [Contributing](#contributing)
- [License](#license)

---

## Features

- **shadcn composition** — an all-in-one entry point (`<twig:Tabler:Card title="…" />`) plus, where it makes sense, dedicated sub-components (`<twig:Tabler:Card:Header>`, `<twig:Tabler:Card:Body>`, …).
- **Block-mirrored props** — on composite components, each prop has a matching Twig block; override one block without rewriting the rest.
- **`html_cva()` variants** — classes are declared with [`html_cva()`](https://twig.symfony.com/doc/3.x/functions/html_cva.html) from `twig/html-extra`, Twig's take on shadcn's CVA.
- **Plain Tabler markup** — components render Tabler / Bootstrap 5 classes; Modal, Dropdown, Carousel, Tabs and Offcanvas use Bootstrap's own `data-bs-*` JavaScript.
- **Attribute forwarding** — extra attributes (`class`, `id`, `data-*`, …) are merged onto the root element.
- **Template-only** — anonymous Twig components, no PHP classes to register or configure.

## Requirements

| Dependency                                                                                    | Version         |
| --------------------------------------------------------------------------------------------- | --------------- |
| PHP                                                                                           | 8.2+            |
| Symfony (`framework-bundle`, `twig-bundle`)                                                   | 6.4 / 7.x / 8.x |
| [Symfony UX Twig Component](https://symfony.com/bundles/ux-twig-component/current/index.html) | 2.21+ / 3.x     |
| Twig (`twig/twig`, `twig/extra-bundle`, `twig/html-extra`)                                    | 3.12+ / 4.x     |

On the front-end, your app must load [Tabler](https://tabler.io/)'s CSS (and Bootstrap's JS for the interactive components). `Icon` and the `icon` props expect the [`@tabler/icons-webfont`](https://tabler.io/icons) font.

## Installation

The package is not published on Packagist: add the GitHub repository, then require it.

```bash
composer config repositories.tabler-ux-components vcs https://github.com/silarhi/tabler-ux-components
composer require silarhi/tabler-ux-components:dev-main
```

If your app uses Symfony Flex, the bundle is registered automatically. Otherwise add it to `config/bundles.php`:

```php
return [
    // ...
    Silarhi\TablerUxComponents\TablerUxComponentsBundle::class => ['all' => true],
];
```

The components live under `components/Tabler/` and are resolved by Twig Component's anonymous component finder. On **ux-twig-component v3**, `twig_component.defaults` and `twig_component.anonymous_template_directory` must be configured explicitly (on v2 they are optional) — the Flex recipe already does it:

```yaml
# config/packages/twig_component.yaml
twig_component:
    anonymous_template_directory: 'components/'
    defaults:
        App\Twig\Components\: 'components/'
```

## Components

### Alert

#### All-in-one usage

```twig
<twig:Tabler:Alert variant="success" title="Saved!" description="Your changes are live." />
```

#### Composed usage (with icon)

```twig
<twig:Tabler:Alert variant="success">
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

| Prop          | Type    | Default  | Description                                                                    |
| ------------- | ------- | -------- | ------------------------------------------------------------------------------ |
| `variant`     | string  | `'info'` | `primary`, `secondary`, `success`, `danger`, `warning`, `info`                 |
| `important`   | bool    | `false`  | Filled/solid background (`alert-important`)                                    |
| `icon`        | string? | `null`   | Icon HTML/SVG, rendered raw inside `Alert:Icon` — keep it developer-controlled |
| `title`       | string? | `null`   | Optional title; skip when using `<twig:Tabler:Alert:Title>`                    |
| `description` | string? | `null`   | Optional description; skip when using `<twig:Tabler:Alert:Description>`        |
| `dismissible` | bool    | `false`  | Adds a Bootstrap close button                                                  |

Extra attributes (e.g. `class`, `data-*`) are forwarded to the root `<div>`.

#### Sub-components

| Tag                               | Purpose                                                                |
| --------------------------------- | ---------------------------------------------------------------------- |
| `<twig:Tabler:Alert:Icon>`        | Slot wrapper; put any icon markup inside (Tabler Icons, SVG, ux-icons) |
| `<twig:Tabler:Alert:Title>`       | Renders `<h4 class="alert-title">`                                     |
| `<twig:Tabler:Alert:Description>` | Renders `<div class="text-secondary">`                                 |
| `<twig:Tabler:Alert:Dismiss>`     | The close button (rendered automatically when `dismissible`)           |

#### Blocks (one per prop)

Each prop has a matching block whose default renders the sub-component with the prop value. Override any block to take fine-grained control while still using the sub-component (and its attributes):

```twig
<twig:Tabler:Alert variant="success" title="Saved!">
    <twig:block name="title">
        <twig:Tabler:Alert:Title class="display-6">Custom heading</twig:Tabler:Alert:Title>
    </twig:block>
</twig:Tabler:Alert>
```

| Block         | Default content                                                                                                   |
| ------------- | ----------------------------------------------------------------------------------------------------------------- |
| `icon`        | `<twig:Tabler:Alert:Icon>{{ icon }}</twig:Tabler:Alert:Icon>` (if `icon` prop is set)                             |
| `title`       | `<twig:Tabler:Alert:Title>{{ title }}</twig:Tabler:Alert:Title>` (if `title` prop is set)                         |
| `description` | `<twig:Tabler:Alert:Description>{{ description }}</twig:Tabler:Alert:Description>` (if `description` prop is set) |
| `body`        | a `<div>` wrapping `title` and `description` (only when one of them renders)                                      |
| `dismiss`     | `<twig:Tabler:Alert:Dismiss />` (if `dismissible` prop is true)                                                   |
| `content`     | wraps `icon`, `body` and `dismiss`. Replace it to compose freely.                                                 |

### Button

Renders a `<button>`, or an `<a>` when `href` is set.

```twig
<twig:Tabler:Button variant="primary">Save</twig:Tabler:Button>
<twig:Tabler:Button variant="danger" appearance="outline" size="sm">Delete</twig:Tabler:Button>
<twig:Tabler:Button href="/profile" variant="secondary" appearance="ghost">Profile</twig:Tabler:Button>
```

| Prop         | Type    | Default     | Description                                                              |
| ------------ | ------- | ----------- | ------------------------------------------------------------------------ |
| `variant`    | string  | `'primary'` | `primary` `secondary` `success` `danger` `warning` `info` `dark` `light` |
| `appearance` | string  | `'filled'`  | `filled` `outline` `ghost`                                               |
| `size`       | string  | `'md'`      | `sm` `md` `lg`                                                           |
| `href`       | string? | `null`      | Renders `<a href>` instead of `<button>`                                 |
| `type`       | string  | `'button'`  | `button` `submit` `reset` (ignored for links)                            |
| `pill`       | bool    | `false`     | Fully rounded                                                            |
| `square`     | bool    | `false`     | Remove border radius                                                     |
| `iconOnly`   | bool    | `false`     | Icon-only button (`btn-icon`)                                            |
| `loading`    | bool    | `false`     | Loading state (`btn-loading`)                                            |
| `block`      | bool    | `false`     | Full width (`w-100`)                                                     |
| `disabled`   | bool    | `false`     | `disabled` attribute on `<button>`, `.disabled` class on `<a>`           |

### Badge

Renders a `<span>`, or an `<a>` when `href` is set.

```twig
<twig:Tabler:Badge variant="success">New</twig:Tabler:Badge>
<twig:Tabler:Badge variant="primary" light pill>3</twig:Tabler:Badge>
```

| Prop      | Type    | Default     | Description                                    |
| --------- | ------- | ----------- | ---------------------------------------------- |
| `variant` | string  | `'primary'` | Bootstrap semantic color (primary, success, …) |
| `light`   | bool    | `false`     | Soft/tinted variant (`bg-{color}-lt`)          |
| `pill`    | bool    | `false`     | Fully rounded (`badge-pill`)                   |
| `size`    | string  | `'md'`      | `sm` `md` `lg`                                 |
| `href`    | string? | `null`      | Renders `<a href>` instead of `<span>`         |

### Card

Renders a `<div>`, or an `<a>` when `href` is set.

```twig
{# all-in-one #}
<twig:Tabler:Card title="Stats" text="42 active users" status="success" />

{# composed #}
<twig:Tabler:Card>
    <twig:Tabler:Card:Header>
        <twig:Tabler:Card:Title>Danger zone</twig:Tabler:Card:Title>
        <twig:Tabler:Card:Actions>
            <twig:Tabler:Button variant="danger" size="sm">Delete</twig:Tabler:Button>
        </twig:Tabler:Card:Actions>
    </twig:Tabler:Card:Header>
    <twig:Tabler:Card:Body>This action cannot be undone.</twig:Tabler:Card:Body>
    <twig:Tabler:Card:Footer>Edited 3 days ago</twig:Tabler:Card:Footer>
</twig:Tabler:Card>
```

| Prop             | Type    | Default | Description                           |
| ---------------- | ------- | ------- | ------------------------------------- |
| `size`           | string  | `'md'`  | `sm` `md` `lg` (padding)              |
| `status`         | string? | `null`  | Status border color                   |
| `statusPosition` | string  | `'top'` | `top` `bottom` `start`                |
| `title`          | string? | `null`  | Mirrored by the `header` block        |
| `text`           | string? | `null`  | Mirrored by the `body` block          |
| `footer`         | string? | `null`  | Mirrored by the `footer` block        |
| `href`           | string? | `null`  | Renders `<a href>` instead of `<div>` |

Sub-components: `Card:Header`, `Card:Title`, `Card:Subtitle`, `Card:Body`, `Card:Footer`, `Card:Actions`, `Card:Status`.

Blocks: `content` (wraps the whole card — override to compose freely), `header`, `body`, `footer`.

### Modal

Bootstrap 5 modal markup. Open it with a trigger: `data-bs-toggle="modal" data-bs-target="#<id>"`.

```twig
{# all-in-one #}
<twig:Tabler:Modal id="confirm" title="Delete item?" text="This cannot be undone." />

{# composed #}
<twig:Tabler:Modal id="edit" size="lg" status="primary">
    <twig:Tabler:Modal:Header>
        <twig:Tabler:Modal:Title>Edit profile</twig:Tabler:Modal:Title>
        <twig:Tabler:Modal:Close />
    </twig:Tabler:Modal:Header>
    <twig:Tabler:Modal:Body>…form…</twig:Tabler:Modal:Body>
    <twig:Tabler:Modal:Footer>
        <twig:Tabler:Button variant="primary">Save</twig:Tabler:Button>
    </twig:Tabler:Modal:Footer>
</twig:Tabler:Modal>
```

| Prop             | Type    | Default | Description                                    |
| ---------------- | ------- | ------- | ---------------------------------------------- |
| `id`             | string? | `null`  | DOM id targeted by triggers                    |
| `size`           | string  | `'md'`  | `sm` `md` `lg` `xl` `full`                     |
| `centered`       | bool    | `false` | Vertically center the dialog                   |
| `scrollable`     | bool    | `false` | Scroll the body instead of the page            |
| `status`         | string? | `null`  | Status bar color at the top of the dialog      |
| `title`          | string? | `null`  | Mirrored by the `header` block                 |
| `text`           | string? | `null`  | Mirrored by the `body` block                   |
| `footer`         | string? | `null`  | Mirrored by the `footer` block                 |
| `dismissible`    | bool    | `true`  | Show a close button in the header              |
| `staticBackdrop` | bool    | `false` | Clicking the backdrop does not close the modal |

Sub-components: `Modal:Header`, `Modal:Title`, `Modal:Body`, `Modal:Footer`, `Modal:Close`, `Modal:Status`.

Blocks: `content` (wraps the whole dialog content — override to compose freely), `header`, `body`, `footer`.

> **Note** — to set a boolean prop to `false` in HTML syntax (e.g. disable `dismissible`), use the `{% component %}` tag: `dismissible="false"` passes the truthy string `"false"`.

### Avatar / Spinner / Status / Divider

```twig
<twig:Tabler:Avatar image="/avatars/jane.jpg" rounded />
<twig:Tabler:Avatar variant="primary" size="lg">JL</twig:Tabler:Avatar>

<twig:Tabler:Spinner variant="primary" size="sm" />
<twig:Tabler:Spinner type="grow" variant="success" />

<twig:Tabler:Status variant="success" label="Online" />
<twig:Tabler:Status variant="danger" dot animated label="Live" />

<twig:Tabler:Divider>See also</twig:Tabler:Divider>
<twig:Tabler:Divider position="start" variant="primary">Section</twig:Tabler:Divider>
```

- **Avatar** — `size` (xs–xl), `variant` (tinted bg for initials), `rounded`, `image`.
- **Spinner** — `type` (border/grow), `variant`, `size` (sm/md), `label`.
- **Status** — `variant`, `dot`, `animated`, `label`. The dot and label live inside the `content` block (override `content`, or the `dot` / `label` sub-blocks). Sub-component: `Status:Dot` (`animated`).
- **Divider** — `position` (start/center/end), `variant`. Empty content → plain `<hr>`.

### Progress

```twig
<twig:Tabler:Progress value="57" variant="success" size="sm" label="57% complete" />
<twig:Tabler:Progress indeterminate size="sm" />

{# stacked bars #}
<twig:Tabler:Progress>
    <twig:Tabler:Progress:Bar value="30" variant="primary" />
    <twig:Tabler:Progress:Bar value="20" variant="success" />
</twig:Tabler:Progress>
```

Props: `value`, `variant`, `size` (sm/md), `label`, `indeterminate`. Sub-component: `Progress:Bar`.

### Breadcrumb / Pagination

```twig
<twig:Tabler:Breadcrumb separator="dots">
    <twig:Tabler:Breadcrumb:Item href="/">Home</twig:Tabler:Breadcrumb:Item>
    <twig:Tabler:Breadcrumb:Item active>Data</twig:Tabler:Breadcrumb:Item>
</twig:Tabler:Breadcrumb>

<twig:Tabler:Pagination outline>
    <twig:Tabler:Pagination:Item disabled>«</twig:Tabler:Pagination:Item>
    <twig:Tabler:Pagination:Item href="?page=1" active>1</twig:Tabler:Pagination:Item>
    <twig:Tabler:Pagination:Item href="?page=2">2</twig:Tabler:Pagination:Item>
</twig:Tabler:Pagination>
```

- **Breadcrumb** — `separator` (default/dots/arrows), `muted`. Item props: `href`, `active`.
- **Pagination** — `outline`, `circle`. Item props: `href`, `active`, `disabled`.

### Dropdown

```twig
<twig:Tabler:Dropdown>
    <twig:Tabler:Dropdown:Toggle variant="primary">Menu</twig:Tabler:Dropdown:Toggle>
    <twig:Tabler:Dropdown:Menu>
        <twig:Tabler:Dropdown:Header>Actions</twig:Tabler:Dropdown:Header>
        <twig:Tabler:Dropdown:Item href="/edit">Edit</twig:Tabler:Dropdown:Item>
        <twig:Tabler:Dropdown:Divider />
        <twig:Tabler:Dropdown:Item href="/delete" disabled>Delete</twig:Tabler:Dropdown:Item>
    </twig:Tabler:Dropdown:Menu>
</twig:Tabler:Dropdown>
```

Sub-components: `Dropdown:Toggle` (`variant`, `noCaret`), `Dropdown:Menu` (`end`), `Dropdown:Item` (`href`, `active`, `disabled`), `Dropdown:Divider`, `Dropdown:Header`.

### Carousel

A Bootstrap 5 slideshow. Uses Bootstrap's own bundled JS (`data-bs-ride` / `data-bs-slide`) — the same mechanism as Modal and Dropdown, so **no third-party library is required**. Set an `id` for the controls and indicators to target.

```twig
{# all-in-one — auto indicators + controls #}
<twig:Tabler:Carousel id="hero" controls indicators="3">
    <twig:Tabler:Carousel:Item active><img class="d-block w-100" src="/1.jpg" alt=""></twig:Tabler:Carousel:Item>
    <twig:Tabler:Carousel:Item><img class="d-block w-100" src="/2.jpg" alt=""></twig:Tabler:Carousel:Item>
    <twig:Tabler:Carousel:Item><img class="d-block w-100" src="/3.jpg" alt=""></twig:Tabler:Carousel:Item>
</twig:Tabler:Carousel>

{# composed — thumbnail indicators + captions #}
<twig:Tabler:Carousel id="gallery" fade>
    <twig:block name="indicators">
        <twig:Tabler:Carousel:Indicators target="gallery" appearance="thumb">
            <twig:Tabler:Carousel:Indicator target="gallery" slideTo="0" image="/1.jpg" active />
            <twig:Tabler:Carousel:Indicator target="gallery" slideTo="1" image="/2.jpg" />
        </twig:Tabler:Carousel:Indicators>
    </twig:block>
    <twig:Tabler:Carousel:Item active>
        <img class="d-block w-100" src="/1.jpg" alt="">
        <twig:Tabler:Carousel:Caption background><h3>First slide</h3></twig:Tabler:Carousel:Caption>
    </twig:Tabler:Carousel:Item>
    <twig:Tabler:Carousel:Item><img class="d-block w-100" src="/2.jpg" alt=""></twig:Tabler:Carousel:Item>
</twig:Tabler:Carousel>
```

| Prop             | Type    | Default     | Description                                                                         |
| ---------------- | ------- | ----------- | ----------------------------------------------------------------------------------- |
| `id`             | string? | `null`      | DOM id; **required** for controls/indicators to work                                |
| `fade`           | bool    | `false`     | Cross-fade instead of sliding (`carousel-fade`)                                     |
| `ride`           | bool    | `true`      | Autoplay on load (`data-bs-ride="carousel"`)                                        |
| `controls`       | bool    | `false`     | Render prev/next controls; mirrored by the `controls` block                         |
| `indicators`     | int?    | `null`      | Number of slides → renders that many indicators; mirrored by the `indicators` block |
| `indicatorStyle` | string  | `'default'` | `default` `dots` `thumb` (passed to `Carousel:Indicators`)                          |
| `vertical`       | bool    | `false`     | Place indicators vertically                                                         |

Sub-components: `Carousel:Item` (`active`), `Carousel:Indicators` (`target`, `count`, `appearance`, `vertical`), `Carousel:Indicator` (`target`, `slideTo`, `active`, `image`), `Carousel:Control` (`target`, `direction`, `label`), `Carousel:Caption` (`background`).

Blocks: `indicators`, `controls` (override to compose them), plus the default slot for the slides.

> **Note** — to disable autoplay, `ride` must be a real boolean: use the `{% component %}` tag (`{% component 'Tabler:Carousel' with {id: 'x', ride: false} %}`); `ride="false"` in HTML syntax passes the truthy string `"false"`.

### Nav

A content navigation list (`.nav`) — for static section/filter navigation. For JS tab-switching with panes use `Tabs`; for the app header use `Navbar`.

```twig
<twig:Tabler:Nav variant="pills">
    <twig:Tabler:Nav:Item href="/" active>Overview</twig:Tabler:Nav:Item>
    <twig:Tabler:Nav:Item href="/activity">Activity</twig:Tabler:Nav:Item>
    <twig:Tabler:Nav:Item disabled>Settings</twig:Tabler:Nav:Item>
</twig:Tabler:Nav>
```

- **Nav** — `variant` (`default`/`tabs`/`pills`/`underline`), `vertical`, `fill`, `justified`.
- **Nav:Item** — `href`, `active`, `disabled`.

### More components

```twig
{# Icon (requires @tabler/icons-webfont) #}
<twig:Tabler:Icon name="check" variant="success" />

{# Ribbon — place inside a positioned parent like a card #}
<twig:Tabler:Ribbon variant="success" position="top-start">NEW</twig:Tabler:Ribbon>

{# Placeholder skeleton #}
<twig:Tabler:Placeholder width="9" size="xs" />

{# Tooltip / Popover (require Bootstrap JS init) #}
<twig:Tabler:Tooltip title="More info"><twig:Tabler:Button>Hover</twig:Tabler:Button></twig:Tabler:Tooltip>
<twig:Tabler:Popover title="Heads up" content="Details."><twig:Tabler:Button>Click</twig:Tabler:Button></twig:Tabler:Popover>

{# Table — responsive wrapper + style flags #}
<twig:Tabler:Table hover striped>
    <thead><tr><th>Name</th></tr></thead>
    <tbody><tr><td>Jane</td></tr></tbody>
</twig:Tabler:Table>

{# Empty state #}
<twig:Tabler:Empty title="No results found" subtitle="Try adjusting your search." />

{# Tracking (uptime blocks) #}
<twig:Tabler:Tracking>
    <twig:Tabler:Tracking:Block variant="success" />
    <twig:Tabler:Tracking:Block variant="danger" tooltip="Down" />
</twig:Tabler:Tracking>

{# Steps #}
<twig:Tabler:Step counter>
    <twig:Tabler:Step:Item href="#">One</twig:Tabler:Step:Item>
    <twig:Tabler:Step:Item active>Two</twig:Tabler:Step:Item>
</twig:Tabler:Step>

{# Timeline — all-in-one, or compose with Timeline:Event:Title / :Time / :Body and an icon block #}
<twig:Tabler:Timeline>
    <twig:Tabler:Timeline:Event title="Backup done" time="1 day ago" text="Latest backup ready." />
    <twig:Tabler:Timeline:Event title="New release" time="2 days ago">
        <twig:block name="icon">
            <twig:Tabler:Timeline:Event:Icon><twig:Tabler:Icon name="rocket" /></twig:Tabler:Timeline:Event:Icon>
        </twig:block>
        <twig:block name="body">
            <twig:Tabler:Timeline:Event:Body>Shipped <strong>v2.0</strong>.</twig:Tabler:Timeline:Event:Body>
        </twig:block>
    </twig:Tabler:Timeline:Event>
</twig:Tabler:Timeline>

{# Tabs #}
<twig:Tabler:Tabs>
    <twig:Tabler:Tabs:Item target="home" active>Home</twig:Tabler:Tabs:Item>
    <twig:Tabler:Tabs:Item target="profile">Profile</twig:Tabler:Tabs:Item>
</twig:Tabler:Tabs>
<twig:Tabler:Tabs:Content>
    <twig:Tabler:Tabs:Pane id="home" active>Home content</twig:Tabler:Tabs:Pane>
    <twig:Tabler:Tabs:Pane id="profile">Profile content</twig:Tabler:Tabs:Pane>
</twig:Tabler:Tabs:Content>

{# Toast #}
<twig:Tabler:Toast show>
    <twig:Tabler:Toast:Header><strong class="me-auto">Notice</strong><twig:Tabler:Toast:Close /></twig:Tabler:Toast:Header>
    <twig:Tabler:Toast:Body>Saved.</twig:Tabler:Toast:Body>
</twig:Tabler:Toast>

{# Offcanvas — open with data-bs-toggle="offcanvas" data-bs-target="#menu" #}
<twig:Tabler:Offcanvas id="menu" placement="end" title="Filters" text="…" />

{# Segmented control #}
<twig:Tabler:SegmentedControl fullWidth>
    <twig:Tabler:SegmentedControl:Item active>Day</twig:Tabler:SegmentedControl:Item>
    <twig:Tabler:SegmentedControl:Item>Week</twig:Tabler:SegmentedControl:Item>
</twig:Tabler:SegmentedControl>

{# Datagrid — title/value pairs #}
<twig:Tabler:Datagrid>
    <twig:Tabler:Datagrid:Item title="Registrar" text="Third Party" />
    <twig:Tabler:Datagrid:Item>
        <twig:Tabler:Datagrid:Item:Title>Owner</twig:Tabler:Datagrid:Item:Title>
        <twig:Tabler:Datagrid:Item:Content><twig:Tabler:Avatar size="xs">JL</twig:Tabler:Avatar> Jane</twig:Tabler:Datagrid:Item:Content>
    </twig:Tabler:Datagrid:Item>
</twig:Tabler:Datagrid>

{# SwitchIcon (requires Tabler switch-icon JS) #}
<twig:Tabler:SwitchIcon iconA="moon" iconB="sun" animation="fade" />

{# …or composed #}
<twig:Tabler:SwitchIcon animation="fade">
    <twig:Tabler:SwitchIcon:A><twig:Tabler:Icon name="moon" /></twig:Tabler:SwitchIcon:A>
    <twig:Tabler:SwitchIcon:B><twig:Tabler:Icon name="sun" /></twig:Tabler:SwitchIcon:B>
</twig:Tabler:SwitchIcon>
```

### Layout: PageHeader / Navbar / Prose

```twig
{# Page header #}
<twig:Tabler:PageHeader pretitle="Overview" title="Dashboard">
    <twig:block name="actions">
        <twig:Tabler:PageHeader:Actions>
            <twig:Tabler:Button variant="primary">New</twig:Tabler:Button>
        </twig:Tabler:PageHeader:Actions>
    </twig:block>
</twig:Tabler:PageHeader>

{# Navbar #}
<twig:Tabler:Navbar>
    <twig:Tabler:Navbar:Toggler target="navbar-menu" />
    <twig:Tabler:Navbar:Brand href="/">My App</twig:Tabler:Navbar:Brand>
    <twig:Tabler:Navbar:Nav id="navbar-menu" collapse>
        <twig:Tabler:Navbar:Item href="/" icon="home" active>Home</twig:Tabler:Navbar:Item>
        <twig:Tabler:Navbar:Item href="/profile" icon="user">Profile</twig:Tabler:Navbar:Item>
    </twig:Tabler:Navbar:Nav>
</twig:Tabler:Navbar>

{# Prose — wraps freeform/markdown HTML with Tabler typography #}
<twig:Tabler:Prose>{{ article.html|raw }}</twig:Tabler:Prose>
```

- **PageHeader** — props `pretitle`, `title`; sub-components `PageHeader:Pretitle`, `PageHeader:Title`, `PageHeader:Actions`.
- **Navbar** — props `expand` (sm/md/lg/xl/none), `dark`, `container`; sub-components `Navbar:Brand`, `Navbar:Toggler`, `Navbar:Nav` (`collapse`, `id`), `Navbar:Item` (`href`, `active`, `icon`).
- **Prose** — a `.prose` typography wrapper.

### Not included

Tabler components that require third-party JavaScript libraries are out of scope: Chart, Dropzone, Countup, Inline player, Range slider, Vector map, WYSIWYG, Autosize.

## Design Pattern

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
        variant: { success: 'alert-success', danger: 'alert-danger', ... },
        important: { true: 'alert-important', false: '' },
        dismissible: { true: 'alert-dismissible', false: '' },
    },
    compound_variants: [
        { important: [true], class: 'text-white' },
    ],
) %}

{# `html_cva` converts boolean recipe values to the string keys 'true'/'false' #}
<div class="{{ alert.apply({variant, important, dismissible}, attributes.render('class')) }}">
```

When two axes both emit a color-dependent class (e.g. Button's `appearance` × `variant`, Badge's `light` × `variant`), the classes live entirely in `compound_variants` so only one wins:

```twig
compound_variants: [
    { appearance: ['outline'], variant: ['primary'], class: 'btn-outline-primary' },
    { appearance: ['ghost'],   variant: ['primary'], class: 'btn-ghost-primary' },
    ...
]
```

## Testing & Quality

```bash
# Install dependencies
composer install

# Run tests
vendor/bin/phpunit

# Static analysis (level: max)
vendor/bin/phpstan analyse

# Code style check
vendor/bin/php-cs-fixer fix --dry-run --diff

# Code style fix
vendor/bin/php-cs-fixer fix

# Twig code style
vendor/bin/twig-cs-fixer lint

# Code modernization check
vendor/bin/rector process --dry-run
```

## Contributing

Contributions are welcome! Please make sure your changes pass all quality checks before submitting a pull request:

```bash
vendor/bin/phpunit && vendor/bin/phpstan analyse && vendor/bin/php-cs-fixer fix --dry-run --diff && vendor/bin/twig-cs-fixer lint
```

## License

MIT License. See [LICENSE](LICENSE) for details.

---

<p align="center">
    Built with care by <a href="https://github.com/silarhi">SILARHI</a>.<br>
    If Tabler UX Components saves you time, consider giving it a star on GitHub.
</p>
