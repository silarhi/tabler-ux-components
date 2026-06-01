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

### Button

Renders a `<button>`, or an `<a>` when `href` is set.

```twig
<twig:Tabler:Button variant="primary">Save</twig:Tabler:Button>
<twig:Tabler:Button variant="danger" appearance="outline" size="sm">Delete</twig:Tabler:Button>
<twig:Tabler:Button href="/profile" variant="ghost">Profile</twig:Tabler:Button>
```

| Prop         | Type    | Default     | Description                                                       |
| ------------ | ------- | ----------- | ----------------------------------------------------------------- |
| `variant`    | string  | `'primary'` | `primary` `secondary` `success` `danger` `warning` `info` `dark` `light` |
| `appearance` | string  | `'filled'`  | `filled` `outline` `ghost`                                        |
| `size`       | string  | `'md'`      | `sm` `md` `lg`                                                    |
| `href`       | string? | `null`      | Renders `<a href>` instead of `<button>`                          |
| `type`       | string  | `'button'`  | `button` `submit` `reset` (ignored for links)                    |
| `pill`       | bool    | `false`     | Fully rounded                                                     |
| `square`     | bool    | `false`     | Remove border radius                                             |
| `iconOnly`   | bool    | `false`     | Icon-only button (`btn-icon`)                                    |
| `loading`    | bool    | `false`     | Loading state (`btn-loading`)                                    |
| `block`      | bool    | `false`     | Full width (`w-100`)                                             |
| `disabled`   | bool    | `false`     | `disabled` attribute on `<button>`, `.disabled` class on `<a>`   |

### Badge

Renders a `<span>`, or an `<a>` when `href` is set.

```twig
<twig:Tabler:Badge variant="success">New</twig:Tabler:Badge>
<twig:Tabler:Badge variant="primary" light pill>3</twig:Tabler:Badge>
```

| Prop    | Type    | Default     | Description                                          |
| ------- | ------- | ----------- | ---------------------------------------------------- |
| `variant` | string  | `'primary'` | Bootstrap semantic color (primary, success, …)                             |
| `light` | bool    | `false`     | Soft/tinted variant (`bg-{color}-lt`)                |
| `pill`  | bool    | `false`     | Fully rounded (`badge-pill`)                         |
| `size`  | string  | `'md'`      | `sm` `md` `lg`                                       |
| `href`  | string? | `null`      | Renders `<a href>` instead of `<span>`               |

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

| Prop             | Type    | Default | Description                                       |
| ---------------- | ------- | ------- | ------------------------------------------------- |
| `size`           | string  | `'md'`  | `sm` `md` `lg` (padding)                          |
| `status`         | string? | `null`  | Status border color                               |
| `statusPosition` | string  | `'top'` | `top` `bottom` `start`                            |
| `title`          | string? | `null`  | Mirrored by the `header` block                    |
| `text`           | string? | `null`  | Mirrored by the `body` block                      |
| `footer`         | string? | `null`  | Mirrored by the `footer` block                    |
| `href`           | string? | `null`  | Renders `<a href>` instead of `<div>`             |

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

| Prop             | Type    | Default | Description                                       |
| ---------------- | ------- | ------- | ------------------------------------------------- |
| `id`             | string? | `null`  | DOM id targeted by triggers                       |
| `size`           | string  | `'md'`  | `sm` `md` `lg` `xl` `full`                        |
| `centered`       | bool    | `false` | Vertically center the dialog                      |
| `scrollable`     | bool    | `false` | Scroll the body instead of the page               |
| `status`         | string? | `null`  | Status bar color at the top of the dialog         |
| `title`          | string? | `null`  | Mirrored by the `header` block                    |
| `text`           | string? | `null`  | Mirrored by the `body` block                      |
| `footer`         | string? | `null`  | Mirrored by the `footer` block                    |
| `dismissible`    | bool    | `true`  | Show a close button in the header                 |
| `staticBackdrop` | bool    | `false` | Clicking the backdrop does not close the modal    |

Sub-components: `Modal:Header`, `Modal:Title`, `Modal:Body`, `Modal:Footer`, `Modal:Close`, `Modal:Status`.

Blocks: `content` (wraps the whole dialog content — override to compose freely), `header`, `body`, `footer`.

> Note: to set a boolean prop to `false` in HTML syntax (e.g. disable `dismissible`), use the `{% component %}` tag — `dismissible="false"` passes the truthy string `"false"`.

### Avatar / Spinner / Status / Divider

```twig
<twig:Tabler:Avatar image="/avatars/jane.jpg" rounded />
<twig:Tabler:Avatar variant="primary" size="lg">JL</twig:Tabler:Avatar>

<twig:Tabler:Spinner variant="primary" size="sm" />
<twig:Tabler:Spinner type="grow" variant="success" />

<twig:Tabler:Status variant="success">Online</twig:Tabler:Status>
<twig:Tabler:Status variant="danger" dot animated>Live</twig:Tabler:Status>

<twig:Tabler:Divider>See also</twig:Tabler:Divider>
<twig:Tabler:Divider position="start" variant="primary">Section</twig:Tabler:Divider>
```

- **Avatar** — `size` (xs–xl), `variant` (tinted bg for initials), `rounded`, `image`.
- **Spinner** — `type` (border/grow), `variant`, `size` (sm/md), `label`.
- **Status** — `variant`, `dot`, `animated`.
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

### More components

```twig
{# Icon (requires @tabler/icons-webfont) #}
<twig:Tabler:Icon name="check" variant="success" />

{# Ribbon — place inside a positioned parent like a card #}
<twig:Tabler:Ribbon variant="green" position="top-start">NEW</twig:Tabler:Ribbon>

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

{# Timeline #}
<twig:Tabler:Timeline>
    <twig:Tabler:Timeline:Event title="Backup done" time="1 day ago">Latest backup ready.</twig:Tabler:Timeline:Event>
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

> **ux-twig-component v3**: configure `twig_component.defaults` and `anonymous_template_directory` in your app (v3 made both required). On v2 they are optional.

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
        dismissible: { true: 'alert-dismissible', false: '' },
    },
    compound_variants: [
        { style: ['important'], class: 'text-white' },
    ],
) %}

{# `html_cva` converts boolean recipe values to the string keys 'true'/'false' #}
<div class="{{ alert.apply({type, style, dismissible}, attributes.render('class')) }}">
```

When two axes both emit a color-dependent class (e.g. Button's `appearance` × `variant`, Badge's `light` × `variant`), the classes live entirely in `compound_variants` so only one wins:

```twig
compound_variants: [
    { appearance: ['outline'], variant: ['primary'], class: 'btn-outline-primary' },
    { appearance: ['ghost'],   variant: ['primary'], class: 'btn-ghost-primary' },
    ...
]
```

## Roadmap

- [x] Alert
- [x] Button
- [x] Badge
- [x] Card
- [x] Modal
- [x] Avatar
- [x] Spinner
- [x] Status
- [x] Divider
- [x] Progress
- [x] Breadcrumb
- [x] Pagination
- [x] Dropdown
- [x] Avatar, Spinner, Status, Divider, Progress, Breadcrumb, Pagination
- [x] Icon, Ribbon, Placeholder, Tooltip, Popover, Table
- [x] Empty, Tracking, SwitchIcon, Step, Timeline
- [x] Tabs, Toast, Offcanvas, SegmentedControl, Datagrid
- [x] PageHeader, Navbar, Prose (from Tabler's layout/base sections)

**Not included** (require third-party JavaScript libraries): Chart, Carousel, Dropzone, Countup, Inline player, Range slider, Vector map, WYSIWYG, Autosize.

## License

MIT
