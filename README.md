<p align="center">
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://img.shields.io/packagist/v/silarhi/tabler-ux-components?style=for-the-badge&label=stable&color=0d6efd&labelColor=1a1a2e">
        <img src="https://img.shields.io/packagist/v/silarhi/tabler-ux-components?style=for-the-badge&label=stable&color=0d6efd"
            alt="Latest Stable Version">
    </picture>
    <picture>
        <source media="(prefers-color-scheme: dark)" srcset="https://img.shields.io/packagist/dt/silarhi/tabler-ux-components?style=for-the-badge&color=198754&labelColor=1a1a2e">
        <img src="https://img.shields.io/packagist/dt/silarhi/tabler-ux-components?style=for-the-badge&color=198754" alt="Total Downloads">
    </picture>
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
    - [Data display: Legend / Signal / Sparkline / ProgressSteps](#data-display-legend--signal--sparkline--progresssteps)
    - [Clipboard](#clipboard)
    - [Buttons: ButtonGroup / ButtonList / ButtonToolbar](#buttons-buttongroup--buttonlist--buttontoolbar)
    - [Accordion](#accordion)
    - [ListGroup](#listgroup)
    - [Inline: Tag / Mention / Trending / StarRating](#inline-tag--mention--trending--starrating)
    - [Chat](#chat)
    - [Layout: PageHeader / PageSection / Navbar / Prose](#layout-pageheader--pagesection--navbar--prose)
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
- **Plain Tabler markup** — components render Tabler / Bootstrap 5 classes; Modal, Dropdown, Carousel, Tabs, Offcanvas and Accordion use the `data-bs-*` JavaScript that ships in `tabler.js`.
- **Attribute forwarding** — extra attributes (`class`, `id`, `data-*`, …) are merged onto the root element.
- **Template-only** — anonymous Twig components, no PHP classes to register or configure.

## Requirements

| Dependency                                                                                    | Version         |
| --------------------------------------------------------------------------------------------- | --------------- |
| PHP                                                                                           | 8.2+            |
| Symfony (`framework-bundle`, `twig-bundle`)                                                   | 6.4 / 7.x / 8.x |
| [Symfony UX Twig Component](https://symfony.com/bundles/ux-twig-component/current/index.html) | 2.21+ / 3.x     |
| Twig (`twig/twig`, `twig/extra-bundle`, `twig/html-extra`)                                    | 3.12+ / 4.x     |

On the front-end, your app must load [Tabler](https://tabler.io/) **1.6+** (`@tabler/core`): its CSS, and `tabler.js` for the interactive components. Since Tabler 1.5, `tabler.js` bundles Bootstrap's JavaScript, so do not load `bootstrap.js` next to it. `Icon` and the `icon` props expect the [`@tabler/icons-webfont`](https://tabler.io/icons) font.

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
<twig:Tabler:Alert variant="success" icon="check" title="Saved!" description="Your changes are live." />
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

| Prop          | Type    | Default  | Description                                                                                                          |
| ------------- | ------- | -------- | -------------------------------------------------------------------------------------------------------------------- |
| `variant`     | string  | `'info'` | `primary`, `secondary`, `success`, `danger`, `warning`, `info`                                                       |
| `important`   | bool    | `false`  | Filled/solid background (`alert-important`)                                                                          |
| `minor`       | bool    | `false`  | Quiet style: plain border, no tinted background (`alert-minor`)                                                      |
| `icon`        | string? | `null`   | Tabler icon name, rendered with `<twig:Tabler:Icon>` inside `Alert:Icon`; for other markup override the `icon` block |
| `title`       | string? | `null`   | Optional title; skip when using `<twig:Tabler:Alert:Title>`                                                          |
| `description` | string? | `null`   | Optional description; skip when using `<twig:Tabler:Alert:Description>`                                              |
| `dismissible` | bool    | `false`  | Adds a Bootstrap close button                                                                                        |

Extra attributes (e.g. `class`, `data-*`) are forwarded to the root `<div>`.

#### Sub-components

| Tag                               | Purpose                                                                |
| --------------------------------- | ---------------------------------------------------------------------- |
| `<twig:Tabler:Alert:Icon>`        | Slot wrapper; put any icon markup inside (Tabler Icons, SVG, ux-icons) |
| `<twig:Tabler:Alert:Title>`       | Renders `<h4 class="alert-heading">`                                   |
| `<twig:Tabler:Alert:Description>` | Renders `<div class="alert-description">`                              |
| `<twig:Tabler:Alert:Dismiss>`     | The close button (rendered automatically when `dismissible`)           |
| `<twig:Tabler:Alert:Link>`        | `<a class="alert-link">` inside the message (`href`)                   |
| `<twig:Tabler:Alert:Action>`      | `<a class="alert-action">` on its own line, for the next step (`href`) |
| `<twig:Tabler:Alert:List>`        | `<ul class="alert-list">` for several messages                         |

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
| `icon`        | `<twig:Tabler:Alert:Icon><twig:Tabler:Icon name="{{ icon }}" /></twig:Tabler:Alert:Icon>` (if `icon` prop is set) |
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

| Prop          | Type    | Default     | Description                                                                                  |
| ------------- | ------- | ----------- | -------------------------------------------------------------------------------------------- |
| `variant`     | string  | `'primary'` | `default` (neutral) `primary` `secondary` `success` `danger` `warning` `info` `dark` `light` |
| `appearance`  | string  | `'filled'`  | `filled` `outline` `ghost` `link` (`btn-link`) `action` (`btn-action`, quiet icon button)    |
| `size`        | string  | `'md'`      | `sm` `md` `lg` `xl`                                                                          |
| `href`        | string? | `null`      | Renders `<a href>` instead of `<button>`                                                     |
| `type`        | string  | `'button'`  | `button` `submit` `reset` (ignored for links)                                                |
| `pill`        | bool    | `false`     | Fully rounded                                                                                |
| `square`      | bool    | `false`     | Remove border radius                                                                         |
| `iconOnly`    | bool    | `false`     | Icon-only button (`btn-icon`)                                                                |
| `loading`     | bool    | `false`     | Loading state (`btn-loading`)                                                                |
| `block`       | bool    | `false`     | Full width (`w-100`)                                                                         |
| `disabled`    | bool    | `false`     | `disabled` attribute on `<button>`, `.disabled` class on `<a>`                               |
| `floating`    | bool    | `false`     | Pinned to the bottom corner of the viewport (`btn-floating`)                                 |
| `animateIcon` | string? | `null`      | Animate the icon on hover: `pulse` `rotate` `shake` `tada` `move-start`                      |

### Badge

Renders a `<span>`, or an `<a>` when `href` is set.

```twig
<twig:Tabler:Badge variant="success">New</twig:Tabler:Badge>
<twig:Tabler:Badge variant="primary" light pill>3</twig:Tabler:Badge>
<twig:Tabler:Badge variant="danger" outline>Deprecated</twig:Tabler:Badge>
<twig:Tabler:Badge variant="success" dot aria-label="Online" />

{# counter over a button corner #}
<twig:Tabler:Button>Inbox <twig:Tabler:Badge variant="danger" notification blink>4</twig:Tabler:Badge></twig:Tabler:Button>

{# several badges side by side #}
<twig:Tabler:Badge:List>
    <twig:Tabler:Badge>PHP</twig:Tabler:Badge>
    <twig:Tabler:Badge>Symfony</twig:Tabler:Badge>
</twig:Tabler:Badge:List>
```

| Prop           | Type    | Default     | Description                                          |
| -------------- | ------- | ----------- | ---------------------------------------------------- |
| `variant`      | string  | `'primary'` | Bootstrap semantic color (primary, success, …)       |
| `light`        | bool    | `false`     | Soft/tinted variant (`bg-{color}-lt`)                |
| `outline`      | bool    | `false`     | Transparent fill, colored border (`badge-outline`)   |
| `pill`         | bool    | `false`     | Fully rounded (`badge-pill`)                         |
| `dot`          | bool    | `false`     | Small dot with no text (`badge-dot`)                 |
| `iconOnly`     | bool    | `false`     | Square badge holding only an icon (`badge-icononly`) |
| `notification` | bool    | `false`     | Over the corner of its parent (`badge-notification`) |
| `blink`        | bool    | `false`     | Pulsing animation (`badge-blink`)                    |
| `size`         | string  | `'md'`      | `sm` `md` `lg`                                       |
| `href`         | string? | `null`      | Renders `<a href>` instead of `<span>`               |

### Card

Renders a `<div>`, or an `<a>` when `href` is set.

```twig
{# all-in-one #}
<twig:Tabler:Card title="Stats" text="42 active users" status="success" />
<twig:Tabler:Card title="Welcome back" gradient="ocean" gradientDirection="bottom" gradientAnimated />

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

| Prop                  | Type         | Default | Description                                                                       |
| --------------------- | ------------ | ------- | --------------------------------------------------------------------------------- |
| `size`                | string       | `'md'`  | `sm` `md` `lg` (padding)                                                          |
| `status`              | string?      | `null`  | Status border color                                                               |
| `statusPosition`      | string       | `'top'` | `top` `bottom` `start`                                                            |
| `gradient`            | bool\|string | `null`  | Gradient background: bare, a color (`primary`, …) or a preset (`ocean`, `sun`, …) |
| `gradientDirection`   | string?      | `null`  | `start` `end` `bottom`                                                            |
| `gradientAnimated`    | bool         | `false` | Slowly shifts the gradient                                                        |
| `dashed`              | bool         | `false` | Dashed border (`card-dashed`)                                                     |
| `title`               | string?      | `null`  | Mirrored by the `header` block                                                    |
| `text`                | string?      | `null`  | Mirrored by the `body` block                                                      |
| `footer`              | string?      | `null`  | Mirrored by the `footer` block                                                    |
| `href`                | string?      | `null`  | Renders `<a href>` instead of `<div>`                                             |
| `borderless`          | bool         | `false` | No border                                                                         |
| `transparent`         | bool         | `false` | No background, dashed border                                                      |
| `stacked`             | bool         | `false` | Second card drawn behind                                                          |
| `active` / `inactive` | bool         | `false` | Selected / dimmed card                                                            |
| `rotate`              | string?      | `null`  | `start` `end` `left` `right` (tilted card)                                        |
| `link`                | bool\|string | `false` | Hover effect for a linked card: bare, `pop` or `rotate`                           |

Gradient presets: `disco` `gold` `love` `mellow` `ocean` `psychedelic` `rainbow` `snow` `sun`.

Sub-components: `Card:Header`, `Card:Title`, `Card:Subtitle`, `Card:Body` (`scrollable`), `Card:Footer`, `Card:Actions`, `Card:Status`, `Card:Img` (`src`, `alt`, `position` top/bottom/start/end), `Card:Stamp` (`icon`, `variant`, `size`), `Card:Progress` (`value`, `variant`, `label`), `Card:Meta`, `Card:Btn` (`href`), `Card:ImgOverlay` (`dark`; content over a `Card:Img position="full"`), `Card:Cover` (`image`, `blurred`; photo header), `Card:Code` (flush code block), `Card:Tabs` (cards switched by tabs; give each `Tabs:Pane` the `card` class). A table that runs edge to edge inside a card: `<twig:Tabler:Table card>`.

Blocks: `content` (wraps the header, body and footer — override to compose freely), `header`, `body`, `footer`. The `status` bar is rendered outside `content`, so it is kept when you compose.

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

| Prop             | Type    | Default | Description                                       |
| ---------------- | ------- | ------- | ------------------------------------------------- |
| `id`             | string? | `null`  | DOM id targeted by triggers                       |
| `size`           | string  | `'md'`  | `sm` `md` `lg` `xl` `full` `fullscreen`           |
| `centered`       | bool    | `false` | Vertically center the dialog                      |
| `scrollable`     | bool    | `false` | Scroll the body instead of the page               |
| `status`         | string? | `null`  | Status bar color at the top of the dialog         |
| `title`          | string? | `null`  | Mirrored by the `header` block                    |
| `text`           | string? | `null`  | Mirrored by the `body` block                      |
| `footer`         | string? | `null`  | Mirrored by the `footer` block                    |
| `dismissible`    | bool    | `true`  | Show a close button in the header                 |
| `staticBackdrop` | bool    | `false` | Clicking the backdrop does not close the modal    |
| `blur`           | bool    | `false` | Blurs the page behind the backdrop (`modal-blur`) |

Sub-components: `Modal:Header`, `Modal:Title`, `Modal:Body`, `Modal:Footer`, `Modal:Close`, `Modal:Status`.

Blocks: `content` (wraps the header, body and footer — override to compose freely), `header`, `body`, `footer`. The `status` bar is rendered outside `content`, so it is kept when you compose.

> **Note** — to set a boolean prop to `false` in HTML syntax (e.g. disable `dismissible`), pass a Twig expression: `dismissible="{{ false }}"`. A bare `dismissible="false"` passes the truthy string `"false"`.

### Avatar / Spinner / Status / Divider

```twig
<twig:Tabler:Avatar image="/avatars/jane.jpg" rounded />
<twig:Tabler:Avatar variant="primary" size="lg">JL</twig:Tabler:Avatar>
<twig:Tabler:Avatar variant="success" square>AB</twig:Tabler:Avatar>

<twig:Tabler:Spinner variant="primary" size="sm" />
<twig:Tabler:Spinner type="grow" variant="success" />

<twig:Tabler:Status variant="success" label="Online" />
<twig:Tabler:Status variant="danger" dot animated label="Live" />
<twig:Tabler:Status variant="azure" lite dot label="Deploying" />
<twig:Tabler:Status:Indicator variant="green" animated aria-label="Operational" />

<twig:Tabler:Divider>See also</twig:Tabler:Divider>
<twig:Tabler:Divider position="start" variant="primary">Section</twig:Tabler:Divider>
```

- **Avatar** — `size` (xxs–2xl), `variant` (tinted bg for initials), `rounded`, `square` (rounded corners instead of a circle), `cover` (pulled over the element above, with a ring), `image`. Sub-components: `Avatar:List` (`stacked`, `size`), `Avatar:Brand` (`image`, corner mark), `Avatar:Upload` (`href`, `size`, `icon`, `text`).
- **Spinner** — `type` (border/grow), `variant`, `size` (sm/md), `label`.
- **Status** — `variant` (theme or palette color), `dot`, `animated`, `lite` (no background), `label`. The dot and label live inside the `content` block (override `content`, or the `dot` / `label` sub-blocks). Sub-components: `Status:Dot` (`animated`), `Status:Indicator` (`variant`, `animated`; a larger standalone marker, `role="img"` when it has an `aria-label`).
- **Divider** — `position` (start/center/end), `variant`, `spaceless`. Empty content → plain `<hr>`.

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

Props: `value`, `variant`, `size` (sm/md/lg/xl), `label`, `indeterminate`, `striped`, `animated`, `separated` (gap between stacked bars). Sub-component: `Progress:Bar` (`value`, `variant`, `label`, `indeterminate`, `striped`, `animated`).

Several segments as one bar, with Bootstrap 5.3's `progress-stacked` markup:

```twig
<twig:Tabler:Progress:Stacked separated>
    <twig:Tabler:Progress:Segment value="15" label="Photos" />
    <twig:Tabler:Progress:Segment value="30" variant="success" label="Videos" />
</twig:Tabler:Progress:Stacked>
```

`Progress:Segment` props: `value` (share in percent), `variant`, `label` (default `"{value}% of total"`), `striped`, `animated`.

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

{# pager that names pages #}
<twig:Tabler:Pagination>
    <twig:Tabler:Pagination:Item href="/docs/start" direction="prev" subtitle="previous" title="Getting started" />
    <twig:Tabler:Pagination:Item href="/docs/install" direction="next" subtitle="next" title="Installation" />
</twig:Tabler:Pagination>
```

- **Breadcrumb** — `separator` (default/dots/arrows/bullets), `muted`. Item props: `href`, `active`.
- **Pagination** — `outline`, `circle`, `size` (sm/md/lg). Item props: `href`, `active` (`aria-current="page"` on the link), `disabled`, `direction` (prev/next), `title`, `subtitle`.

### Dropdown

```twig
<twig:Tabler:Dropdown>
    <twig:Tabler:Dropdown:Toggle variant="primary">Menu</twig:Tabler:Dropdown:Toggle>
    <twig:Tabler:Dropdown:Menu>
        <twig:Tabler:Dropdown:Header>Actions</twig:Tabler:Dropdown:Header>
        <twig:Tabler:Dropdown:Item href="/edit" icon="pencil">Edit</twig:Tabler:Dropdown:Item>
        <twig:Tabler:Dropdown:Text>Signed in as jane@example.com</twig:Tabler:Dropdown:Text>
        <twig:Tabler:Dropdown:Divider />
        <twig:Tabler:Dropdown:Item href="/delete" disabled>Delete</twig:Tabler:Dropdown:Item>
    </twig:Tabler:Dropdown:Menu>
</twig:Tabler:Dropdown>
```

Props: `direction` (down/up/end/start: where the menu opens). Submenus are not supported: `Dropdown:Toggle` is a `.btn`, not a `.dropdown-item`.

Sub-components: `Dropdown:Toggle` (`variant`, `noCaret`, `split`), `Dropdown:Menu` (`end`, `arrow`, `dark`, `scrollable`, `card`), `Dropdown:Item` (`href`, `active`, `disabled`, `icon`, `tag`: `button` or `label` for an item that is not a link, e.g. holding a checkbox), `Dropdown:Text`, `Dropdown:Columns` / `Dropdown:Column` (multi-column menu), `Dropdown:Indicator` (leading checkbox/radio/avatar/flag slot), `Dropdown:Divider`, `Dropdown:Header`.

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
{# size: sm | md | lg | inline (otherwise it follows the font size); filled: the ti-{name}-filled glyph (icons-webfont <= 3.36.0) #}
<twig:Tabler:Icon name="heart" size="lg" filled variant="danger" />

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

{# Table — rows stacked below md (each cell needs a data-label), sortable header, selectable rows #}
<twig:Tabler:Table mobile="md" selectable size="sm">
    <thead><tr>
        <th class="w-1"><twig:Tabler:Table:Check aria-label="Select all rows" /></th>
        <th><twig:Tabler:Table:Sort field="name" direction="asc">Name</twig:Tabler:Table:Sort></th>
    </tr></thead>
    <tbody><tr>
        <td><twig:Tabler:Table:Check aria-label="Select Jane" /></td>
        <twig:Tabler:Table:Cell label="Name">Jane</twig:Tabler:Table:Cell>
        <twig:Tabler:Table:Cell label="Bio" truncate>{{ user.bio }}</twig:Tabler:Table:Cell>
    </tr></tbody>
</twig:Tabler:Table>
{# other flags: vcenter, center, striped, hover, bordered, borderless, transparent, nowrap, card (edge to edge in a card), responsive (default true) #}
{# Table:Cell — label: data-label for stacked rows; truncate: ellipsis instead of stretching the table (td-truncate) #}

{# Empty state #}
<twig:Tabler:Empty title="No results found" subtitle="Try adjusting your search." />
<twig:Tabler:Empty bordered title="Page not found">
    <twig:block name="icon"><twig:Tabler:Empty:Header>404</twig:Tabler:Empty:Header></twig:block>
</twig:Tabler:Empty>
{# also Empty:Icon, Empty:Img (illustration), Empty:Title, Empty:Subtitle, Empty:Action #}

{# Tracking (uptime blocks; `squares` for square blocks) #}
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

{# Tabs — `pills`, `underline`, `bordered`, `fill`, `card` #}
<twig:Tabler:Tabs underline>
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
{# stack toasts in a corner: placement = top-start | top-center | top-end | middle-center | bottom-start | bottom-center | bottom-end #}
<twig:Tabler:Toast:Container placement="bottom-end">…</twig:Tabler:Toast:Container>

{# Offcanvas — open with data-bs-toggle="offcanvas" data-bs-target="#menu" #}
<twig:Tabler:Offcanvas id="menu" placement="end" title="Filters" text="…" footer="…" />
{# narrow: 20rem wide; floating: detached from the viewport edges; sub-components Offcanvas:Header/Title/Close/Body/Footer #}
<twig:Tabler:Offcanvas id="settings" placement="end" narrow floating title="Settings" />

{# Segmented control — `fullWidth`, `vertical`, `size` (sm/md/lg) #}
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
<twig:Tabler:SwitchIcon iconA="moon" iconB="sun" animation="fade" aria-label="Dark mode" />
{# active: starts on; loading: spinner, clicks ignored; animation: fade | scale | flip | slide-{up,down,left,right,start,end} #}
<twig:Tabler:SwitchIcon iconA="star" iconB="star" active loading aria-label="Favorite" />

{# …or composed #}
<twig:Tabler:SwitchIcon animation="fade">
    <twig:Tabler:SwitchIcon:A><twig:Tabler:Icon name="moon" /></twig:Tabler:SwitchIcon:A>
    <twig:Tabler:SwitchIcon:B><twig:Tabler:Icon name="sun" /></twig:Tabler:SwitchIcon:B>
</twig:Tabler:SwitchIcon>
```

### Data display: Legend / Signal / Sparkline / ProgressSteps

```twig
{# Legend — a colored marker, a label and an optional value for a chart series #}
<twig:Tabler:Legend:List divided>
    <twig:Tabler:Legend variant="primary" size="lg" label="P99" value="124" unit="ms" />
    <twig:Tabler:Legend variant="azure" size="lg" label="P95" value="76" unit="ms" />
    <twig:Tabler:Legend variant="yellow" size="lg" label="Requests" value="1,234" button off />
</twig:Tabler:Legend:List>
<twig:Tabler:Legend:Dot variant="green" />

{# Signal — stepped bars showing a level; without aria-label it is hidden as decoration #}
<twig:Tabler:Signal value="2" variant="orange" aria-label="Priority: high" />

{# Sparkline — a tiny inline chart drawn by tabler.js from data attributes #}
<twig:Tabler:Sparkline values="3,4,2,6,5,8,7" variant="primary" fill spot="last" aria-label="Weekly trend" />
<twig:Tabler:Sparkline values="72" type="circle" size="lg" label="auto" variant="green" aria-label="72% done" />

{# ProgressSteps — where the user is in a short flow #}
<twig:Tabler:ProgressSteps count="4" active="2" aria-label="Setup progress" />
```

- **Legend** — `variant`, `size` (md/lg), `label`, `value`, `unit`, `href` (renders `<a>`), `button` (renders `<button>`), `active`, `off`. Sub-components `Legend:Dot` (`variant`, also usable on its own), `Legend:Value` (`unit`), `Legend:Unit`, `Legend:List` (`vertical`, `divided`). Blocks: `content`, `dot`, `label`, `value`.
- **Signal** — `value` (lit bars), `max` (2–5, default 3), `variant`. Sub-component `Signal:Bar` (`active`).
- **Sparkline** — `values` (array or comma-separated string), `type` (line/bar/tristate/circle), `variant` (text color), `size` (sm/md/lg), `square`, `fill`, `spot` (last/min/max), `min`, `max`, `threshold`, `label`, `barGap`, `barRadius`, `disabled`. Give it an `aria-label`: the SVG is hidden from assistive technology.
- **ProgressSteps** — `count` or `labels`, `active` (1-based current step), `variant` (color of reached steps). Sub-component `ProgressSteps:Item` (`variant`, `current`, `label`).

Legend, Signal and Sparkline accept the theme colors (`primary` … `light`, `muted`) and the palette colors (`blue`, `azure`, `indigo`, `purple`, `pink`, `red`, `orange`, `yellow`, `lime`, `green`, `teal`, `cyan`).

### Clipboard

A copy button built on the browser clipboard API by `tabler.js` (`data-bs-toggle="clipboard"`).

```twig
<input type="text" id="api-key" class="form-control" value="tblr_live_8f2c41d0a7" readonly>
<twig:Tabler:Clipboard target="#api-key" />

{# a literal string, custom labels #}
<twig:Tabler:Clipboard text="composer require silarhi/tabler-ux-components" label="Copy command" feedback="Copied!" class="btn-sm" />

{# composed — icon states #}
<twig:Tabler:Clipboard target="#api-key" aria-label="Copy the API key">
    <twig:Tabler:Clipboard:Label><twig:Tabler:Icon name="copy" /></twig:Tabler:Clipboard:Label>
    <twig:Tabler:Clipboard:Feedback class="text-green"><twig:Tabler:Icon name="check" /></twig:Tabler:Clipboard:Feedback>
</twig:Tabler:Clipboard>
```

Props: `target` (selector), `text` (literal string, wins over `target`), `delay` (ms), `label` (default `Copy`), `feedback` (default `Copied`). Sub-components `Clipboard:Label`, `Clipboard:Feedback`.

> **Confetti** needs no component: `tabler.js` binds it to any trigger, so `<twig:Tabler:Button data-bs-toggle="confetti" data-bs-count="150">Celebrate</twig:Tabler:Button>` works as is.

### Buttons: ButtonGroup / ButtonList / ButtonToolbar

```twig
{# Button group — joined buttons; give it an aria-label #}
<twig:Tabler:ButtonGroup aria-label="Alignment">
    <twig:Tabler:Button variant="default">Left</twig:Tabler:Button>
    <twig:Tabler:Button variant="default">Middle</twig:Tabler:Button>
    <twig:Tabler:Button variant="default">Right</twig:Tabler:Button>
</twig:Tabler:ButtonGroup>

{# Toggle buttons — radio (or checkbox) inputs styled as buttons #}
<twig:Tabler:ButtonGroup size="sm" aria-label="Period">
    <twig:Tabler:ButtonGroup:Toggle id="period-day" name="period" value="day" checked>Day</twig:Tabler:ButtonGroup:Toggle>
    <twig:Tabler:ButtonGroup:Toggle id="period-week" name="period" value="week">Week</twig:Tabler:ButtonGroup:Toggle>
</twig:Tabler:ButtonGroup>

{# Button list — a wrapping row of buttons with a consistent gap #}
<twig:Tabler:ButtonList center>
    <twig:Tabler:Button variant="primary">Save</twig:Tabler:Button>
    <twig:Tabler:Button variant="default">Cancel</twig:Tabler:Button>
</twig:Tabler:ButtonList>

{# Button toolbar — several groups in one toolbar #}
<twig:Tabler:ButtonToolbar aria-label="Editor" class="gap-2">
    <twig:Tabler:ButtonGroup aria-label="Formatting">…</twig:Tabler:ButtonGroup>
    <twig:Tabler:ButtonGroup aria-label="History">…</twig:Tabler:ButtonGroup>
</twig:Tabler:ButtonToolbar>

{# Action buttons — quiet icon buttons for card headers and table rows #}
<twig:Tabler:ButtonActions>
    <twig:Tabler:Button appearance="action" href="/edit" aria-label="Edit"><twig:Tabler:Icon name="edit" /></twig:Tabler:Button>
    <twig:Tabler:Button appearance="action" aria-label="Delete"><twig:Tabler:Icon name="trash" /></twig:Tabler:Button>
</twig:Tabler:ButtonActions>

{# Plain lists, without list-group borders #}
<twig:Tabler:List separated>
    <twig:Tabler:List:Item class="d-flex align-items-center">…</twig:Tabler:List:Item>
</twig:Tabler:List>
<twig:Tabler:List inline dots>
    <twig:Tabler:List:Item inline>Documentation</twig:Tabler:List:Item>
    <twig:Tabler:List:Item inline>License</twig:Tabler:List:Item>
</twig:Tabler:List>
```

- **ButtonGroup** — `vertical`, `size` (sm/md/lg); `role="group"`. Sub-component `ButtonGroup:Toggle` (`id`, `name`, `value`, `type` radio/checkbox, `checked`, `disabled`, `label`, `variant`, `appearance` filled/outline/ghost) renders the `.btn-check` input and its `<label class="btn">` (`class` goes on the label, other attributes on the input).
- **ButtonList** — `center` (`btn-list-center`).
- **ButtonToolbar** — `role="toolbar"`.
- **ButtonActions** — `btn-actions` wrapper for `<twig:Tabler:Button appearance="action">` buttons.
- **List** — `separated` (`list-separated`), `inline` (`list-inline`), `dots` (`list-inline-dots`), `unstyled`, `ordered` (`<ol>`). Sub-component `List:Item` (`inline`).

### Accordion

```twig
{# All-in-one — item ids default to "<id>-<n>"; opening one closes the others #}
<twig:Tabler:Accordion id="faq" items="{{ [
    {title: 'Account details', text: 'Update your profile.', open: true},
    {title: 'Security settings', text: 'Configure two-factor authentication.', icon: 'lock'},
] }}" />

{# Composed — `parent` wires data-bs-parent; override the `title` / `body` blocks of an item #}
<twig:Tabler:Accordion id="settings" flush>
    <twig:Tabler:Accordion:Item id="settings-api" parent="settings" title="API access" text="Generate tokens." open plus />
    <twig:Tabler:Accordion:Item id="settings-hooks" parent="settings" title="Webhooks" plus>
        <twig:block name="body">
            <twig:Tabler:Accordion:Body>Manage <strong>delivery URLs</strong>.</twig:Tabler:Accordion:Body>
        </twig:block>
    </twig:Tabler:Accordion:Item>
</twig:Tabler:Accordion>

{# Fully composed item #}
<twig:Tabler:Accordion:Item>
    <twig:Tabler:Accordion:Header level="2">
        <twig:Tabler:Accordion:Button target="faq-team" icon="user" open>Team profile</twig:Tabler:Accordion:Button>
    </twig:Tabler:Accordion:Header>
    <twig:Tabler:Accordion:Collapse id="faq-team" parent="faq" open>
        <twig:Tabler:Accordion:Body>Manage members.</twig:Tabler:Accordion:Body>
    </twig:Tabler:Accordion:Collapse>
</twig:Tabler:Accordion:Item>
```

- **Accordion** — `id`, `items` (array of `{title, text, open?, icon?, id?}`), `flush`, `inverted` (toggle at the start), `tabs` (spaced, fully bordered items), `alwaysOpen` (no `data-bs-parent` on generated items), `plus` (plus toggle on generated items).
- **Accordion:Item** — `id` (panel id), `parent` (accordion id, for `data-bs-parent`), `title`, `text`, `open`, `icon` (leading icon), `plus`, `toggleIcon` (default `chevron-down`), `level` (heading level, default 3). Blocks: `content`, `header`, `title`, `body`.
- Sub-components `Accordion:Header` (`level`), `Accordion:Button` (`target`, `open`, `icon`, `plus`, `toggleIcon`; blocks `icon`, `toggle`) — keeps `collapsed`, `aria-expanded` and `aria-controls` in sync —, `Accordion:Icon`, `Accordion:Toggle` (`plus`, `icon`), `Accordion:Collapse` (`id`, `parent`, `open`), `Accordion:Body`.

### ListGroup

```twig
{# All-in-one #}
<twig:Tabler:ListGroup tag="nav" items="{{ [
    {label: 'Profile', href: '/profile', active: true},
    {label: 'Billing', href: '/billing', disabled: true},
] }}" />

{# Composed #}
<twig:Tabler:ListGroup flush hoverable>
    <twig:Tabler:ListGroup:Header>Today</twig:Tabler:ListGroup:Header>
    <twig:Tabler:ListGroup:Item>
        Build failed
        <twig:Tabler:ListGroup:Actions href="/favorites/add" aria-label="Add to favorites"><twig:Tabler:Icon name="star" /></twig:Tabler:ListGroup:Actions>
    </twig:Tabler:ListGroup:Item>
    <twig:Tabler:ListGroup:Item button variant="success">Deploy succeeded</twig:Tabler:ListGroup:Item>
</twig:Tabler:ListGroup>

<twig:Tabler:ListGroup tag="ol" numbered>
    <twig:Tabler:ListGroup:Item tag="li" label="Create an account" />
    <twig:Tabler:ListGroup:Item tag="li" label="Invite your team" />
</twig:Tabler:ListGroup>
```

- **ListGroup** — `tag` (div/ul/ol/nav), `items` (array of `{label, href?, active?, disabled?, variant?}`), `flush`, `hoverable`, `transparent`, `numbered`, `horizontal` (bare, or a breakpoint sm…xxl), `card` (`card-list-group`).
- **ListGroup:Item** — `label`, `href` (renders `<a>`), `button` (renders `<button>`), `tag` (div/li), `action` (defaults to true for links and buttons), `active` (`aria-current="true"`), `disabled` (a disabled link loses its `href`), `variant` (theme color tint).
- Sub-components `ListGroup:Header` (`tag`), `ListGroup:Actions` (`href`, `show`) — the trailing control revealed on hover.

### Inline: Tag / Mention / Trending / StarRating

```twig
{# Tag — leading icon, avatar, status dot or checkbox; counter badge; remove button #}
<twig:Tabler:Tag:List>
    <twig:Tabler:Tag label="Featured" icon="star" dismissible />
    <twig:Tabler:Tag label="Alex P." avatar="/avatars/alex.jpg" dismissible />
    <twig:Tabler:Tag label="Online" status="success" />
    <twig:Tabler:Tag label="Notifications" badge="12" />
    <twig:Tabler:Tag label="Selected" checkbox checked />
</twig:Tabler:Tag:List>

{# Mention — an inline chip in running text #}
Hey <twig:Tabler:Mention label="JohnDoe" prefix="@" prefixHidden avatar="/avatars/john.jpg" href="/u/john" />, look!
<twig:Tabler:Mention label="GitHub" logo="/brands/github.svg" />
<twig:Tabler:Mention label="#066fd1" swatch="blue" />
<twig:Tabler:Mention label="Tabler" prefix="#" count="4" href="/tags/tabler" />

{# Trending — direction and color come from the sign of the value #}
<twig:Tabler:Trending value="25" />
<twig:Tabler:Trending value="-12" />
<twig:Tabler:Trending value="4.2K" unit="" />

{# StarRating — read-only stars, labelled "4 out of 5" #}
<twig:Tabler:StarRating value="4" />
<twig:Tabler:StarRating value="3" max="10" variant="red" icon="heart" aria-label="3 of 10 hearts" />
```

- **Tag** — `label`, `icon`, `avatar` (image URL), `status` (dot color), `checkbox`, `checked`, `badge`, `dismissible` (remove button labelled "Remove &lt;label&gt;"). Sub-components `Tag:Avatar` (`image`), `Tag:Status` (`variant`), `Tag:Check` (`checked`), `Tag:Badge`, `Tag:Close`, `Tag:List` (`tag-list`, which replaces the deprecated `tags-list`). Blocks: `content`, `leading`, `label`, `badge`, `close`.
- **Mention** — `label`, `href` (renders `<a>`), `prefix` (`@`, `#`, …), `prefixHidden` (visually hidden prefix), `avatar`, `logo`, `swatch` (color), `count`. Sub-components `Mention:Avatar` (`image`), `Mention:App` (`image`), `Mention:Color` (`variant`), `Mention:Count`. Blocks: `content`, `leading`, `label`, `count`.
- **Trending** — `value` (number or signed string, rendered as written), `unit` (default `%`), `direction` (up/down/neutral, to override the sign), `label` (visually hidden prefix, default "Increased by" / "Decreased by" / "No change,"). Blocks: `content`, `label`, `value`, `icon`.
- **StarRating** — `value`, `max` (default 5), `variant` (active color, default `yellow`), `icon` (default `star`; `star-filled` only exists up to `@tabler/icons-webfont` 3.36.0); `role="img"` with an "N out of M" `aria-label`. Sub-component `StarRating:Star` (`active`, `variant`, `icon`).

Tag status, Mention swatch and StarRating accept the theme colors (`primary` … `light`, `muted`) and the palette colors (`blue` … `cyan`). Icons use `<twig:Tabler:Icon>` (requires `@tabler/icons-webfont`).

### Chat

```twig
{# All-in-one #}
<twig:Tabler:Chat messages="{{ [
    {author: 'Alice Marlin', date: '10:24', text: 'Hey, are you free for a quick call?', avatar: '/avatars/alice.jpg'},
    {author: 'You', date: '10:26', text: 'Sure, give me five minutes.', avatar: '/avatars/me.jpg', me: true},
] }}" />

{# Composed #}
<twig:Tabler:Chat>
    <twig:Tabler:Chat:Bubbles>
        <twig:Tabler:Chat:Message author="Alice Marlin" date="10:24" text="Hey!" avatar="/avatars/alice.jpg" />
        <twig:Tabler:Chat:Message me avatar="/avatars/me.jpg">
            <twig:Tabler:Chat:Bubble me>
                <twig:Tabler:Chat:Bubble:Title>
                    <twig:Tabler:Chat:Bubble:Author>You</twig:Tabler:Chat:Bubble:Author>
                    <twig:Tabler:Chat:Bubble:Date>10:26</twig:Tabler:Chat:Bubble:Date>
                </twig:Tabler:Chat:Bubble:Title>
                <twig:Tabler:Chat:Bubble:Body><p>Sure, <strong>five minutes</strong>.</p></twig:Tabler:Chat:Bubble:Body>
            </twig:Tabler:Chat:Bubble>
        </twig:Tabler:Chat:Message>
        <twig:Tabler:Chat:Typing>Alice is typing</twig:Tabler:Chat:Typing>
    </twig:Tabler:Chat:Bubbles>
</twig:Tabler:Chat>
```

- **Chat** — `messages` (array of `{author?, date?, text?, avatar?, me?}`).
- **Chat:Message** — one row: `author`, `date`, `text`, `avatar` (image URL; block `avatar`), `me` (bubble tinted and pushed to the end, avatar after it).
- **Chat:Bubble** — `author`, `date`, `text` (wrapped in a `<p>`), `me`. Blocks: `content`, `title`, `body`.
- Sub-components `Chat:Bubbles`, `Chat:Bubble:Title` (`author`, `date`), `Chat:Bubble:Author`, `Chat:Bubble:Date`, `Chat:Bubble:Body`, `Chat:Typing` (`label`, default "Typing", followed by animated dots).

### Layout: PageHeader / PageSection / Navbar / Prose

```twig
{# Page header #}
<twig:Tabler:PageHeader pretitle="Overview" title="Dashboard">
    <twig:block name="actions">
        <twig:Tabler:PageHeader:Actions>
            <twig:Tabler:Button variant="primary">New</twig:Tabler:Button>
        </twig:Tabler:PageHeader:Actions>
    </twig:block>
</twig:Tabler:PageHeader>

{# Page section — a heading inside the page body #}
<twig:Tabler:PageSection title="Line charts" description="Trends over time." class="col-12" />

{# Navbar #}
<twig:Tabler:Navbar>
    <twig:Tabler:Navbar:Toggler target="navbar-menu" />
    <twig:Tabler:Navbar:Brand href="/">My App</twig:Tabler:Navbar:Brand>
    <twig:Tabler:Navbar:Nav id="navbar-menu" collapse>
        <twig:Tabler:Navbar:Item href="/" icon="home" active>Home</twig:Tabler:Navbar:Item>
        <twig:Tabler:Navbar:Item href="/profile" icon="user">Profile</twig:Tabler:Navbar:Item>
    </twig:Tabler:Navbar:Nav>
</twig:Tabler:Navbar>

{# Vertical sidebar, folded into an icon rail that unfolds on hover #}
<twig:Tabler:Navbar vertical expand="lg" folded="hover">
    <twig:Tabler:Navbar:Toggler target="sidebar-menu" />
    <twig:Tabler:Navbar:Brand href="/">My App</twig:Tabler:Navbar:Brand>
    <twig:Tabler:Navbar:Nav id="sidebar-menu" collapse>
        <twig:Tabler:Navbar:SectionTitle>Overview</twig:Tabler:Navbar:SectionTitle>
        <twig:Tabler:Navbar:Item href="/" icon="home" active>Home</twig:Tabler:Navbar:Item>
        <twig:block name="side">
            <twig:Tabler:Navbar:Side>
                <twig:Tabler:Navbar:Item href="/help" icon="help">Help</twig:Tabler:Navbar:Item>
            </twig:Tabler:Navbar:Side>
        </twig:block>
    </twig:Tabler:Navbar:Nav>
    <twig:Tabler:Navbar:Footer>
        <twig:Tabler:Navbar:Item href="/me" icon="user">Jane Doe</twig:Tabler:Navbar:Item>
    </twig:Tabler:Navbar:Footer>
</twig:Tabler:Navbar>

{# Prose — wraps freeform/markdown HTML with Tabler typography #}
<twig:Tabler:Prose>{{ article.html|raw }}</twig:Tabler:Prose>
```

- **PageHeader** — props `pretitle`, `title`; sub-components `PageHeader:Pretitle`, `PageHeader:Title`, `PageHeader:Actions`.
- **PageSection** — props `title`, `description`; sub-components `PageSection:Title`, `PageSection:Description`.
- **Navbar** — props `expand` (sm/md/lg/xl/none), `dark`, `container` (default `xl`, or `fluid` when vertical), `vertical` (sidebar, rendered as `<aside>`), `folded` (bare for an icon rail, `hover` to unfold on hover), `floating` (detached from the edges); sub-components `Navbar:Brand`, `Navbar:Toggler`, `Navbar:Nav` (`collapse`, `id`, `side` block), `Navbar:Item` (`href`, `active`, `icon`), `Navbar:SectionTitle`, `Navbar:Side` (trailing group), `Navbar:Footer` (bottom zone of a sidebar).
- **Prose** — a `.prose` typography wrapper.

### Not included

Tabler components that require third-party JavaScript libraries are out of scope: Chart, Dropzone, Countup, Inline player, Range slider, Vector map, WYSIWYG, Autosize, Datepicker, interactive Star rating (the read-only `StarRating` is included). Form controls (OTP input, password strength) are not covered yet.

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

### Escaping rules

Templates never bypass Twig's autoescaping — `tests/TemplateConventionsTest.php` fails on any `|raw` or `{% autoescape false %}`:

- **Props are text, slots are markup.** Prop values are always escaped; HTML only comes in through blocks and sub-components (e.g. `Alert`'s `icon` prop is a Tabler icon name, custom SVG goes in the `icon` block).
- **Pick the element, don't duplicate the content.** When a component renders `<a>`, `<button>` or `<span>` depending on its props, the tag name is dynamic (`<{{ tag }}>…</{{ tag }}>`) and the `content` block is defined once. An optional wrapper is opened and closed under the same `{% if %}`.
- **Capture only to test for emptiness.** A captured `{% set x %}…{% endset %}` block is already escaped and marked safe: print it as `{{ x }}`, never through `|raw`, and never joined with `~` for output (that escapes it twice).
- **Never forward a possibly-null value as an HTML attribute.** Older ux-twig-component releases render a `null` attribute as `"true"`; guard it with `{% if %}`, or make it a declared prop.

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
