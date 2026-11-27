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
- **Any icon**: [Tabler Icons](https://tabler.io/icons) from the webfont, or any icon of [Symfony UX Icons](https://symfony.com/bundles/ux-icons/current/index.html) with a prefixed name (`icon="lucide:circle-check"`)
- **Attribute forwarding**: extra attributes (`class`, `id`, `data-*`…) are merged onto the root element
- **Template-only**: anonymous Twig components, no PHP classes to register or configure
- **Symfony Form themes**: vertical and horizontal themes on top of Bootstrap 5, with `icon`, `stepper`, `choice_style` (segmented control, select group) and `switch` options rendered by the same components

## Requirements

- PHP 8.2+
- Twig 3.15+ / 4.x, with `twig/html-extra` 3.12+ / 4.x, and [Symfony UX Twig Component](https://symfony.com/bundles/ux-twig-component/current/index.html) 2.21+ / 3.x
- In a Symfony 6.4, 7.x or 8.x app, FrameworkBundle and TwigBundle: the bundle registers `html_cva()` unless
  TwigExtraBundle does. Without a kernel, see [Without the bundle](#without-the-bundle) (UX Twig Component 3.2+, so PHP 8.4+)
- [Tabler](https://tabler.io/) 1.6+ on the front-end (1.7+ for the components that say so): its CSS, `tabler.js` for the interactive components, and
  [`@tabler/icons-webfont`](https://tabler.io/icons) for the icons (3.36.1+ for the filled icons)
- Optional: [Symfony UX Icons](https://symfony.com/bundles/ux-icons/current/index.html) 2.17+ / 3.x, for icon names with
  an icon set prefix (`lucide:circle-check`)

## Installation

```bash
composer require silarhi/tabler-ux-components
```

On ux-twig-component v3, `twig_component` needs some configuration: see [Installation](https://tabler-ux-components.silarhi.dev/getting-started/installation/).

Prefer to own the templates? Copy the components into your app with the
[Symfony UX Toolkit](https://tabler-ux-components.silarhi.dev/getting-started/installation/#with-the-symfony-ux-toolkit)
instead: `php bin/console ux:install alert --kit=github.com/silarhi/tabler-ux-kit`.

### Without the bundle

From UX Twig Component 3.2, the components render in a plain Twig environment: no kernel, no
`symfony/dependency-injection`. Add the bundle's `templates/` directory to the loader, as the bundle does, and wire
TwigComponent's runtime by hand, with an empty PSR-11 container for the services (the Tabler components are anonymous):

```php
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Contracts\Service\ServiceLocatorTrait;
use Symfony\UX\TwigComponent\ComponentAttributes;
use Symfony\UX\TwigComponent\ComponentFactory;
use Symfony\UX\TwigComponent\ComponentProperties;
use Symfony\UX\TwigComponent\ComponentRenderer;
use Symfony\UX\TwigComponent\ComponentStack;
use Symfony\UX\TwigComponent\ComponentTemplateFinder;
use Symfony\UX\TwigComponent\Twig\ComponentExtension;
use Symfony\UX\TwigComponent\Twig\ComponentLexer;
use Symfony\UX\TwigComponent\Twig\ComponentRuntime;
use Twig\Environment;
use Twig\Extra\Html\HtmlExtension;
use Twig\Loader\FilesystemLoader;
use Twig\Runtime\EscaperRuntime;
use Twig\RuntimeLoader\FactoryRuntimeLoader;

// Your templates, then the bundle's: <twig:Tabler:Alert> is components/Tabler/Alert.html.twig
$loader = new FilesystemLoader([__DIR__ . '/templates', __DIR__ . '/vendor/silarhi/tabler-ux-components/templates']);

$twig = new Environment($loader, ['cache' => __DIR__ . '/var/cache/twig']);
$twig->setLexer(new ComponentLexer($twig)); // the <twig:…> syntax
$twig->addExtension(new ComponentExtension()); // {% component %}, {% props %}, component()
$twig->addExtension(new HtmlExtension()); // html_cva()
$twig->getRuntime(EscaperRuntime::class)->addSafeClass(ComponentAttributes::class, ['html']);

$services = new class([]) implements ContainerInterface {
    use ServiceLocatorTrait;
};
$propertyAccessor = PropertyAccess::createPropertyAccessor();
$dispatcher = new EventDispatcher();
$stack = new ComponentStack();
$factory = new ComponentFactory(new ComponentTemplateFinder($loader, 'components'), $services, $propertyAccessor, $dispatcher, [], [], $twig);
$renderer = new ComponentRenderer($twig, $dispatcher, $factory, new ComponentProperties($propertyAccessor), $stack);

$twig->addRuntimeLoader(new FactoryRuntimeLoader([
    ComponentRuntime::class => static fn (): ComponentRuntime => new ComponentRuntime($renderer, $services, $stack),
]));
```

The anonymous component directory is `components`, the one the bundle's templates use: your own anonymous components go
in `templates/components/`. Without the bundle, the form themes and their options (`symfony/form`) and the icon names
with a set prefix (`lucide:check`, which need UX Icons' bundle) are not available. UX Twig Component marks these
classes `@internal`: this is the wiring of its standalone usage (symfony/ux#3602), which `tests/Standalone/` checks.

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

- **Feedback**: [Alert](https://tabler-ux-components.silarhi.dev/components/feedback/alert/), [Empty](https://tabler-ux-components.silarhi.dev/components/feedback/empty/), [Placeholder](https://tabler-ux-components.silarhi.dev/components/feedback/placeholder/), [Progress](https://tabler-ux-components.silarhi.dev/components/feedback/progress/), [ProgressSteps](https://tabler-ux-components.silarhi.dev/components/feedback/progress-steps/), [Spinner](https://tabler-ux-components.silarhi.dev/components/feedback/spinner/), [TextShimmer](https://tabler-ux-components.silarhi.dev/components/feedback/text-shimmer/), [Toast](https://tabler-ux-components.silarhi.dev/components/feedback/toast/)
- **Actions**: [Button](https://tabler-ux-components.silarhi.dev/components/actions/button/), [ButtonActions](https://tabler-ux-components.silarhi.dev/components/actions/button-actions/), [ButtonGroup](https://tabler-ux-components.silarhi.dev/components/actions/button-group/), [ButtonList](https://tabler-ux-components.silarhi.dev/components/actions/button-list/), [ButtonToolbar](https://tabler-ux-components.silarhi.dev/components/actions/button-toolbar/), [Clipboard](https://tabler-ux-components.silarhi.dev/components/actions/clipboard/), [Dropdown](https://tabler-ux-components.silarhi.dev/components/actions/dropdown/), [SegmentedControl](https://tabler-ux-components.silarhi.dev/components/actions/segmented-control/), [SwitchIcon](https://tabler-ux-components.silarhi.dev/components/actions/switch-icon/)
- **Forms**: [InputIcon](https://tabler-ux-components.silarhi.dev/components/forms/input-icon/), [NumberInput](https://tabler-ux-components.silarhi.dev/components/forms/number-input/), [Selectgroup](https://tabler-ux-components.silarhi.dev/components/forms/selectgroup/)
- **Content**: [Accordion](https://tabler-ux-components.silarhi.dev/components/content/accordion/), [Avatar](https://tabler-ux-components.silarhi.dev/components/content/avatar/), [Badge](https://tabler-ux-components.silarhi.dev/components/content/badge/), [Card](https://tabler-ux-components.silarhi.dev/components/content/card/), [Carousel](https://tabler-ux-components.silarhi.dev/components/content/carousel/), [Chat](https://tabler-ux-components.silarhi.dev/components/content/chat/), [Datagrid](https://tabler-ux-components.silarhi.dev/components/content/datagrid/), [Divider](https://tabler-ux-components.silarhi.dev/components/content/divider/), [Flag](https://tabler-ux-components.silarhi.dev/components/content/flag/), [Hover gallery](https://tabler-ux-components.silarhi.dev/components/content/hover-gallery/), [Icon](https://tabler-ux-components.silarhi.dev/components/content/icon/), [Image label](https://tabler-ux-components.silarhi.dev/components/content/image-label/), [Kbd](https://tabler-ux-components.silarhi.dev/components/content/kbd/), [List](https://tabler-ux-components.silarhi.dev/components/content/list/), [List group](https://tabler-ux-components.silarhi.dev/components/content/list-group/), [Mention](https://tabler-ux-components.silarhi.dev/components/content/mention/), [Mockup browser](https://tabler-ux-components.silarhi.dev/components/content/mockup-browser/), [Prose](https://tabler-ux-components.silarhi.dev/components/content/prose/), [Ribbon](https://tabler-ux-components.silarhi.dev/components/content/ribbon/), [Status](https://tabler-ux-components.silarhi.dev/components/content/status/), [Table](https://tabler-ux-components.silarhi.dev/components/content/table/), [Tag](https://tabler-ux-components.silarhi.dev/components/content/tag/), [Timeline](https://tabler-ux-components.silarhi.dev/components/content/timeline/)
- **Overlays**: [Modal](https://tabler-ux-components.silarhi.dev/components/overlays/modal/), [Offcanvas](https://tabler-ux-components.silarhi.dev/components/overlays/offcanvas/), [Popover](https://tabler-ux-components.silarhi.dev/components/overlays/popover/), [Tooltip](https://tabler-ux-components.silarhi.dev/components/overlays/tooltip/)
- **Navigation**: [Breadcrumb](https://tabler-ux-components.silarhi.dev/components/navigation/breadcrumb/), [Nav](https://tabler-ux-components.silarhi.dev/components/navigation/nav/), [Pagination](https://tabler-ux-components.silarhi.dev/components/navigation/pagination/), [Step](https://tabler-ux-components.silarhi.dev/components/navigation/step/), [Tabs](https://tabler-ux-components.silarhi.dev/components/navigation/tabs/)
- **Layout**: [Footer](https://tabler-ux-components.silarhi.dev/components/layout/footer/), [Navbar](https://tabler-ux-components.silarhi.dev/components/layout/navbar/), [Page](https://tabler-ux-components.silarhi.dev/components/layout/page/), [PageHeader](https://tabler-ux-components.silarhi.dev/components/layout/page-header/), [PageSection](https://tabler-ux-components.silarhi.dev/components/layout/page-section/)
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
