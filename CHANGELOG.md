# Changelog

All notable changes to this project are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.4.0] - 2026-10-12

### Added

- `StarRating` and `StarRating:Star` `filled`, passed to their icons.

### Changed

- **BC break:** `Icon`'s `filled` renders `ti-filled ti-filled-{name}` instead of `ti ti-{name}-filled`, which `@tabler/icons-webfont` dropped in 3.36.1. The filled icons are now a separate font: compile its `tabler-icons-filled.scss` with `$ti-prefix: 'ti-filled'` (see the Icon page of the documentation). On webfont 3.36.0 or older, keep `filled` off and pass the `-filled` name instead: `<twig:Tabler:Icon name="star-filled" />`.

## [0.3.0] - 2026-10-12

### Added

- Components: `ButtonGroup` (+ `Toggle`), `ButtonList`, `ButtonToolbar`, `Accordion` (with an `items` all-in-one mode), `Tag`, `Trending`, read-only `StarRating`, `ListGroup`, `Chat` (with a `messages` all-in-one mode and a typing indicator) and `Mention`.
- Tabler 1.6 modifiers on navigation, feedback and layout components:
  - `Tabs` `underline`, `bordered`, `fill`; `SegmentedControl` `vertical` and `size`.
  - `Progress` `striped`, `animated`, `separated`; `Progress:Bar` `striped` and `animated`.
  - `Pagination` `size`; `Pagination:Item` `direction` (prev/next with `rel`), `title` and `subtitle` for a named pager.
  - `Dropdown` `direction`; `Dropdown:Menu` `arrow`, `dark`, `scrollable`, `card`; `Dropdown:Item` `icon`; `Dropdown:Toggle` `split`; new `Dropdown:Text`, `Dropdown:Columns` and `Dropdown:Column`.
  - `Modal` `blur` and `size="fullscreen"`; `Button` `appearance="link"`, `floating`, `animateIcon`; `Icon` `size` and `filled`.
  - `Card` `borderless`, `transparent`, `stacked`, `active`, `inactive`, `rotate`, `link`; `Card:Body` `scrollable`; new `Card:Img`, `Card:Stamp`, `Card:Progress`, `Card:Meta` and `Card:Btn`.
  - New `Avatar:List`, `Avatar:Brand` and `Avatar:Upload`; `Breadcrumb` `bullets`, `Divider` `spaceless`, `Tracking` `squares`, `Empty` `bordered` with `Empty:Header` / `Empty:Img`, and `Toast:Container`.
- The last Tabler 1.6 classes:
  - `Button` `appearance="action"` (`btn-action`) and a `ButtonActions` wrapper.
  - `Card:ImgOverlay` (`dark`), `Card:Cover` (`image`, `blurred`), `Card:Code`, `Card:Tabs`, and `Card:Img` `position="full"`.
  - `Table` `card` (`card-table`) and `Table:Cell` (`label` for stacked rows, `truncate`).
  - `Progress:Stacked` (`separated`) and `Progress:Segment`, Bootstrap 5.3's `progress-stacked` markup.
  - `Dropdown:Indicator`, `Avatar` `cover`, and a plain `List` + `List:Item` (`separated`, `inline` with `dots`, `unstyled`, `ordered`).
- `Dropdown:Item` `tag`: `button` or `label` for an item that is not a link, such as one holding a checkbox or a radio in a `Dropdown:Indicator`.

### Changed

- **BC break:** `Alert`'s `icon` prop takes a Tabler icon name, rendered through `<twig:Tabler:Icon>`. Markup passed to it (`icon="<svg …>"`) is now escaped: move it to the `icon` block (`<twig:block name="icon"><twig:Tabler:Alert:Icon>…</twig:Tabler:Alert:Icon></twig:block>`).
- No template bypasses Twig's autoescaping any more: components that switch between `<a>`, `<button>` and `<span>` render a dynamic tag with their content defined once.
- **BC break:** `Dropdown:Toggle` renders a `<button type="button">` instead of an `<a href="#">`: CSS or tests targeting `a.dropdown-toggle` must target `.dropdown-toggle`. `SegmentedControl:Item` defaults to `type="button"`, so neither submits an enclosing form.
- `Pagination:Item` puts `aria-current="page"` on the link instead of the `<li>`, as Tabler's documentation requires.

### Fixed

- Components rendered blank lines before their markup, which added a space before a component in running text. Each still ends with one line break, so components on consecutive lines stay apart.
- `Card` and `Modal` dropped their status bar when given children.
- `Avatar`, `Progress:Bar`, `Carousel:Indicator`, `Tag:Avatar`, `Mention:Avatar`, `Mention:App` and `Avatar:Brand` dropped a user `style` attribute instead of merging it.
- `Toast` carried `data-bs-toggle="toast"` on its root, which tabler.js treats as a trigger.
- `StarRating`: `max="0"` rendered two stars, and the default `star-filled` icon, which no longer exists after icons-webfont 3.36.0, rendered empty stars (the default is now `star`).
- `Trending`: a Unicode minus is a decrease, a zero with a decimal comma is neutral, and a value that is not a number (e.g. `N/A`) is neutral instead of an increase.
- `ListGroup:Item` with both `href` and `button` no longer puts `type="button"` or a bare `disabled` on the link; a disabled `Pagination:Item` is an `<a aria-disabled>` without `href`, and an active one keeps `aria-current`.
- `Chat:Message` wraps long messages instead of dropping them under the avatar, and `Chat:Typing` no longer stretches across `Chat:Bubbles`.
- `Card:Cover` and `Progress:Segment` dropped a user `style` attribute; `Card:Cover` wraps its content in a `position-relative` `<div>`, so text stays above the darkening overlay; `Progress:Segment`'s fill no longer carries a second, unnamed `role="progressbar"`.
- `Accordion:Header` falls back to `<h3>` for a level outside 1 to 6, and `Tag`'s checkbox no longer gets `aria-label="true"` on older ux-twig-component releases when the tag has no label.

## [0.2.0] - 2026-10-12

### Added

- Components: `Legend`, `Signal`, `Sparkline` (the `data-bs-*` attributes tabler.js draws an inline chart from), `ProgressSteps`, `Clipboard` and `PageSection`.
- `Alert:Link`, `Alert:Action` and `Alert:List`; `Badge` `outline`, `dot`, `iconOnly`, `notification`, `blink` and `Badge:List`; `Status` `lite`, `muted`, the palette colors and `Status:Indicator`.
- `Table` `mobile`, `center`, `borderless`, `transparent`, `nowrap`, `selectable`, `size="sm"`, with `Table:Sort` and `Table:Check`.
- Tabler 1.5 and 1.6 modifiers on existing components:
  - `Button` `default` variant and `xl` size; `Alert` `minor`; `Avatar` `square` and the `xxs` / `2xl` sizes; `Progress` `lg` and `xl`.
  - `Card` `gradient` (bare, theme color or preset), `gradientDirection`, `gradientAnimated` and `dashed`.
  - `SwitchIcon` `loading`, `active` and every `slide-*` animation.
  - `Offcanvas` `narrow`, `floating`, and a `footer` prop and block with `Offcanvas:Footer`.
  - `Navbar` `vertical` (sidebar), `folded` and `floating`, with `Navbar:SectionTitle`, `Navbar:Side`, `Navbar:Footer` and a `side` block on `Navbar:Nav`.

### Changed

- The components target Tabler **1.6+** and its `tabler.js`, which bundles Bootstrap's JavaScript since Tabler 1.5: do not load `bootstrap.js` next to it.
- `SwitchIcon` renders `type="button"` and an initial `aria-pressed`, so it no longer submits an enclosing form; active `Navbar:Item` links carry `aria-current="page"`.

### Removed

- **BC break:** `Table`'s `cards` prop: the `.table-cards` class it added is defined by no Tabler stylesheet. Remove the prop.

### Fixed

- Classes Tabler does not define: `Alert:Title` renders `.alert-heading` instead of `.alert-title`, `Alert:Description` uses `.alert-description` instead of `text-secondary`, and `Badge` `light` no longer adds `text-*-lt-fg`.
- `Alert:Dismiss` is a `<button type="button">` instead of an `<a>` without `href`, so it can be reached with the keyboard.

## [0.1.0] - 2026-10-12

First release: Tabler components as anonymous Symfony UX Twig Components (`<twig:Tabler:…>`), each with an all-in-one form driven by props and sub-components for fine-grained composition. Alert, Avatar, Badge, Breadcrumb, Button, Card, Carousel, Datagrid, Divider, Dropdown, Empty, Icon, Modal, Nav, Navbar, Offcanvas, PageHeader, Pagination, Placeholder, Popover, Progress, Prose, Ribbon, SegmentedControl, Spinner, Status, Step, SwitchIcon, Table, Tabs, Timeline, Toast, Tooltip and Tracking. Requires PHP 8.2+, Symfony 6.4 / 7.x / 8.x, Symfony UX Twig Component 2.21+ / 3.x and Twig 3.12+.

[0.4.0]: https://github.com/silarhi/tabler-ux-components/compare/v0.3.0...v0.4.0
[0.3.0]: https://github.com/silarhi/tabler-ux-components/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/silarhi/tabler-ux-components/compare/v0.1.0...v0.2.0
[0.1.0]: https://github.com/silarhi/tabler-ux-components/releases/tag/v0.1.0
