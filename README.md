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

<p align="center">
    📖 <a href="https://tabler-ux-components.silarhi.dev"><strong>Documentation</strong></a>
</p>

---

## Features

- **shadcn composition**: an all-in-one tag (`<twig:Tabler:Card title="…" />`) plus, where it makes sense, sub-components (`<twig:Tabler:Card:Header>`, `<twig:Tabler:Card:Body>`…)
- **Block-mirrored props**: on composite components, each prop has a matching Twig block; override one without rewriting the rest
- **`html_cva()` variants**: classes are declared with [`html_cva()`](https://twig.symfony.com/doc/3.x/functions/html_cva.html), Twig's take on shadcn's CVA
- **Plain Tabler markup**: Tabler / Bootstrap 5 classes; the interactive components use the `data-bs-*` JavaScript of `tabler.js`
- **Attribute forwarding**: extra attributes (`class`, `id`, `data-*`…) are merged onto the root element
- **Template-only**: anonymous Twig components, no PHP classes to register or configure

## Requirements

- PHP 8.2+
- Symfony 6.4, 7.x or 8.x, with [Symfony UX Twig Component](https://symfony.com/bundles/ux-twig-component/current/index.html) 2.21+ / 3.x
- [Tabler](https://tabler.io/) 1.6+ on the front-end: its CSS, `tabler.js` for the interactive components, and
  [`@tabler/icons-webfont`](https://tabler.io/icons) for the icons

## Installation

```bash
composer require silarhi/tabler-ux-components
```

On ux-twig-component v3, `twig_component` needs some configuration: see [Installation](https://tabler-ux-components.silarhi.dev/getting-started/installation/).

Prefer to own the templates? Copy the components into your app with the
[Symfony UX Toolkit](https://tabler-ux-components.silarhi.dev/getting-started/installation/#with-the-symfony-ux-toolkit)
instead: `php bin/console ux:install alert --kit=github.com/silarhi/tabler-ux-kit`.

## Quick start

```twig
{# all-in-one #}
<twig:Tabler:Alert variant="success" title="Saved!" description="Your changes are live." />

{# composed #}
<twig:Tabler:Card>
    <twig:Tabler:Card:Header>
        <twig:Tabler:Card:Title>Danger zone</twig:Tabler:Card:Title>
        <twig:Tabler:Card:Actions>
            <twig:Tabler:Button variant="danger" size="sm">Delete</twig:Tabler:Button>
        </twig:Tabler:Card:Actions>
    </twig:Tabler:Card:Header>
    <twig:Tabler:Card:Body>This action cannot be undone.</twig:Tabler:Card:Body>
</twig:Tabler:Card>
```

## Documentation

Every component has a live preview, its Twig source, the HTML it renders, and the reference of its props, sub-components
and blocks on **[tabler-ux-components.silarhi.dev](https://tabler-ux-components.silarhi.dev)**. Start with [Composition](https://tabler-ux-components.silarhi.dev/getting-started/composition/).

- **Feedback**: [Alert](https://tabler-ux-components.silarhi.dev/components/feedback/alert/), [Empty](https://tabler-ux-components.silarhi.dev/components/feedback/empty/), [Placeholder](https://tabler-ux-components.silarhi.dev/components/feedback/placeholder/), [Progress](https://tabler-ux-components.silarhi.dev/components/feedback/progress/), [ProgressSteps](https://tabler-ux-components.silarhi.dev/components/feedback/progress-steps/), [Spinner](https://tabler-ux-components.silarhi.dev/components/feedback/spinner/), [Toast](https://tabler-ux-components.silarhi.dev/components/feedback/toast/)
- **Actions**: [Button](https://tabler-ux-components.silarhi.dev/components/actions/button/), [ButtonActions](https://tabler-ux-components.silarhi.dev/components/actions/button-actions/), [ButtonGroup](https://tabler-ux-components.silarhi.dev/components/actions/button-group/), [ButtonList](https://tabler-ux-components.silarhi.dev/components/actions/button-list/), [ButtonToolbar](https://tabler-ux-components.silarhi.dev/components/actions/button-toolbar/), [Clipboard](https://tabler-ux-components.silarhi.dev/components/actions/clipboard/), [Dropdown](https://tabler-ux-components.silarhi.dev/components/actions/dropdown/), [SegmentedControl](https://tabler-ux-components.silarhi.dev/components/actions/segmented-control/), [SwitchIcon](https://tabler-ux-components.silarhi.dev/components/actions/switch-icon/)
- **Content**: [Accordion](https://tabler-ux-components.silarhi.dev/components/content/accordion/), [Avatar](https://tabler-ux-components.silarhi.dev/components/content/avatar/), [Badge](https://tabler-ux-components.silarhi.dev/components/content/badge/), [Card](https://tabler-ux-components.silarhi.dev/components/content/card/), [Carousel](https://tabler-ux-components.silarhi.dev/components/content/carousel/), [Chat](https://tabler-ux-components.silarhi.dev/components/content/chat/), [Datagrid](https://tabler-ux-components.silarhi.dev/components/content/datagrid/), [Divider](https://tabler-ux-components.silarhi.dev/components/content/divider/), [Icon](https://tabler-ux-components.silarhi.dev/components/content/icon/), [List](https://tabler-ux-components.silarhi.dev/components/content/list/), [List group](https://tabler-ux-components.silarhi.dev/components/content/list-group/), [Mention](https://tabler-ux-components.silarhi.dev/components/content/mention/), [Prose](https://tabler-ux-components.silarhi.dev/components/content/prose/), [Ribbon](https://tabler-ux-components.silarhi.dev/components/content/ribbon/), [Status](https://tabler-ux-components.silarhi.dev/components/content/status/), [Table](https://tabler-ux-components.silarhi.dev/components/content/table/), [Tag](https://tabler-ux-components.silarhi.dev/components/content/tag/), [Timeline](https://tabler-ux-components.silarhi.dev/components/content/timeline/)
- **Overlays**: [Modal](https://tabler-ux-components.silarhi.dev/components/overlays/modal/), [Offcanvas](https://tabler-ux-components.silarhi.dev/components/overlays/offcanvas/), [Popover](https://tabler-ux-components.silarhi.dev/components/overlays/popover/), [Tooltip](https://tabler-ux-components.silarhi.dev/components/overlays/tooltip/)
- **Navigation**: [Breadcrumb](https://tabler-ux-components.silarhi.dev/components/navigation/breadcrumb/), [Nav](https://tabler-ux-components.silarhi.dev/components/navigation/nav/), [Pagination](https://tabler-ux-components.silarhi.dev/components/navigation/pagination/), [Step](https://tabler-ux-components.silarhi.dev/components/navigation/step/), [Tabs](https://tabler-ux-components.silarhi.dev/components/navigation/tabs/)
- **Layout**: [Navbar](https://tabler-ux-components.silarhi.dev/components/layout/navbar/), [PageHeader](https://tabler-ux-components.silarhi.dev/components/layout/page-header/), [PageSection](https://tabler-ux-components.silarhi.dev/components/layout/page-section/)
- **Data display**: [Legend](https://tabler-ux-components.silarhi.dev/components/data/legend/), [Signal](https://tabler-ux-components.silarhi.dev/components/data/signal/), [Sparkline](https://tabler-ux-components.silarhi.dev/components/data/sparkline/), [StarRating](https://tabler-ux-components.silarhi.dev/components/data/star-rating/), [Tracking](https://tabler-ux-components.silarhi.dev/components/data/tracking/), [Trending](https://tabler-ux-components.silarhi.dev/components/data/trending/)

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md).

## License

MIT License. See [LICENSE](LICENSE) for details.

---

<p align="center">
    Built with care by <a href="https://github.com/silarhi">SILARHI</a>.<br>
    If Tabler UX Components saves you time, consider giving it a star on GitHub.
</p>
