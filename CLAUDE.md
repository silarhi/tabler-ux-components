# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

`silarhi/tabler-ux-components` is a Symfony bundle of [Tabler](https://tabler.io/) UI components built as anonymous [Symfony UX Twig Components](https://symfony.com/bundles/ux-twig-component/current/index.html): `<twig:Tabler:Alert>`, `<twig:Tabler:Card>`, … Almost all of the code is Twig templates under `templates/components/Tabler/`; the only PHP class is the bundle. Published on Packagist under MIT license.

The README documents every component, the design pattern and the escaping rules: keep it in sync with the templates.

## Development Commands

```bash
# Install dependencies
composer install

# Run tests (fail on any deprecation)
vendor/bin/phpunit
vendor/bin/phpunit tests/Component/AlertTest.php   # Single file
vendor/bin/phpunit --filter testDismissible        # Single method

# Static analysis (level max + strict rules, src and tests)
vendor/bin/phpstan analyse

# Code style
vendor/bin/php-cs-fixer fix
vendor/bin/twig-cs-fixer lint          # templates/; add --fix to apply

# Rector
vendor/bin/rector process --dry-run

# composer.json validation + normalization
composer validate --strict
composer normalize --dry-run
```

## Architecture

- `src/TablerUxComponentsBundle.php` (`AbstractBundle`) only prepends the bundle's `templates/` directory as a non-namespaced Twig path, so ux-twig-component's anonymous component finder resolves everything under `components/Tabler/` with the `Tabler:` prefix. There are no PHP components, services or configuration.
- **shadcn composition pattern**: each component is a main template with every prop (`Alert.html.twig`) plus one sub-component per part (`Alert/Title.html.twig` → `<twig:Tabler:Alert:Title>`). Each prop of the main component has a matching block whose default renders the sub-component wrapping the prop value, so users can override a block, or the whole `content` block, to compose freely.
- Every template starts with a `{# … #}` doc comment: what it renders, usage examples and the list of props. Keep it accurate; it is the reference the README is written from.
- **Variants** are declared with `html_cva()` (twig/html-extra) and applied with `attributes.render('class')` so users' classes are merged. Booleans become the string keys `true`/`false`. When two axes both emit a color class (Button `appearance` × `variant`, Badge `light` × `variant`), the classes live entirely in `compound_variants` so only one wins.
- **Nullable props passed to `html_cva`** (`variant = null`, `size = null`, `animation = null`…) go through `?? ''` in `.apply({…})`: PHP 8.5 deprecates `null` as an array offset, which Cva uses for the lookup, and the suite fails on deprecations. `''` selects the same (absent) variant.
- **Escaping**: props are text and always escaped; markup only comes in through blocks and sub-components. Never `|raw` nor `{% autoescape false %}` (`tests/TemplateConventionsTest.php` fails on both, outside comments). A captured `{% set x %}…{% endset %}` is already safe: print it as `{{ x }}`, never through `|raw` and never joined with `~` for output. Never forward a possibly-null value as an HTML attribute (older ux-twig-component releases render `null` as `"true"`): guard it with `{% if %}` or declare it as a prop. See the README's "Escaping rules".
- **Prop syntax** in templates and docs: always the explicit string form `<twig:Tabler:Icon name="{{ icon }}" />`, never the `:prop` shorthand.
- Front-end: components target Tabler **1.6+** (`@tabler/core` CSS and `tabler.js`, which bundles Bootstrap's JavaScript since 1.5) and the `@tabler/icons-webfont` font. Components needing third-party JavaScript (charts, datepicker, …) are out of scope (README "Not included").

## Testing

- `tests/Fixtures/TestKernel.php`: FrameworkBundle + TwigBundle + TwigComponentBundle + TwigExtraBundle + this bundle. Its cache goes to the project's `var/cache/test` (Symfony's default), not the system temp directory, so parallel checkouts do not share compiled containers.
- `tests/ComponentTestCase.php`: `renderComponent('<twig:Tabler:…>')` renders a Twig snippet through the kernel's Twig, `assertHtmlSame()` compares HTML ignoring whitespace around tags. One test class per component under `tests/Component/` (grouped ones: `CompositionComponentsTest`, `LayoutComponentsTest`, `ModifiersTest`…).
- `phpunit.xml.dist` sets `failOnDeprecation="true"`: a deprecation from a template (or a dependency update) fails the suite.

### Adding a component

1. `templates/components/Tabler/<Name>.html.twig` with its doc comment, `{% props %}`, `html_cva` variants and one block per prop, plus `templates/components/Tabler/<Name>/<Part>.html.twig` sub-components.
2. A test in `tests/Component/<Name>Test.php` covering the all-in-one and composed usages, each variant and the attributes merge.
3. A README section (all-in-one and composed usage, props, sub-components, blocks), and the table of contents.
4. `vendor/bin/twig-cs-fixer lint --fix` and the full test suite.

## Code Standards

- PHP 8.2+, `declare(strict_types=1)` and the SILARHI header comment in PHP files
- PHPStan level max with strict rules, Symfony PHP-CS-Fixer ruleset with `@Symfony:risky`, Twig-CS-Fixer standard
- Rector skips `RenameClassRector`: Symfony 8.1 moves the bundle classes to `DependencyInjection\Kernel`, which 6.4 and 7.x do not have

## Dependency Constraints

- Integration libraries keep wide ranges so the CI matrix tests from the lowest to the latest supported versions: Symfony `^6.4 || ^7.0 || ^8.0`, ux-twig-component `^2.21 || ^3.0`, Twig `^3.12 || ^4.0`. Never raise their floors to the installed version.
- QA tools are bumped to their latest releases. `composer.lock` is not committed.

## Changelog & Releases

- **`CHANGELOG.md`** follows [Keep a Changelog](https://keepachangelog.com/en/1.1.0/). Every user-facing change (new component, prop or sub-component, changed markup or classes, fix) gets an entry in the top section, titled with the next release, never a bare `[Unreleased]` (e.g. `[0.3.0] - Unreleased`, its compare link ending in `...HEAD`). Prefix breaking changes (a removed or renamed prop, block or sub-component, markup users may style or test against) with **BC break:** and say what users must change. Skip dependency bumps, CI and tooling changes.
- While in `0.x`, new components, modifiers and BC breaks are a minor, fixes only a patch.
- **Releases**: date the section and point its compare link at the tag (`compare/<previous>...<tag>`), then tag `vX.Y.Z` on `origin/main` once CI is green, with a GitHub release whose notes follow that section. Packagist updates from the GitHub hook.
