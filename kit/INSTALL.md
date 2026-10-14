# Getting started

This kit provides ready-to-use Twig components based on [Tabler](https://tabler.io/) 1.6. It is built from
[silarhi/tabler-ux-components](https://github.com/silarhi/tabler-ux-components), whose documentation describes every
component: [tabler-ux-components.silarhi.dev](https://tabler-ux-components.silarhi.dev).

## Requirements

Tabler's CSS is required by all components. Tabler's JavaScript is also required by interactive components (Modal,
Dropdown, Carousel, Tabs, Offcanvas, Tooltip, Popover, Clipboard, Sparkline…), and the Tabler Icons webfont by the
`icon` props and the `Icon` component.

## Installation

Install Tabler with AssetMapper:

```bash
php bin/console importmap:require @tabler/core @tabler/core/dist/css/tabler.min.css @tabler/icons-webfont/dist/tabler-icons.min.css
```

Then import Tabler from `assets/app.js`:

```js
import '@tabler/core/dist/css/tabler.min.css'
import '@tabler/icons-webfont/dist/tabler-icons.min.css'
import '@tabler/core'
```

With a JavaScript package manager (pnpm, npm, Yarn…), install Tabler instead:

```bash
pnpm add @tabler/core@^1.6.0 @tabler/icons-webfont@^3.36.1
```

The imports in `assets/app.js` remain the same. Since Tabler 1.5, `tabler.js` bundles Bootstrap's JavaScript: do not
load `bootstrap.js` next to it.

The components are installed under `templates/components/Tabler/` and used with the `Tabler:` prefix, as
`<twig:Tabler:Alert>`. Install either this kit or the `silarhi/tabler-ux-components` bundle, not both: they provide
the same components.
