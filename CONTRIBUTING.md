# Contributing

Contributions are welcome! Bug reports and feature requests go to the
[issue tracker](https://github.com/silarhi/tabler-ux-components/issues), changes to a pull request against `main`.

## Setup

```bash
composer install
pnpm install # Git hooks: lint-staged formats the staged files on commit
```

## Quality checks

The CI runs the tests on every supported PHP version (8.2 to 8.5), with both the lowest and the latest dependencies
(Symfony, Twig, ux-twig-component), and the static analysis and code style checks once. Rector is not run in CI: run it
locally before opening a pull request.

```bash
# Tests
vendor/bin/phpunit

# Static analysis (level: max)
vendor/bin/phpstan analyse

# Code style (drop --dry-run --diff to fix)
vendor/bin/php-cs-fixer fix --dry-run --diff

# Twig code style (add --fix to fix)
vendor/bin/twig-cs-fixer lint

# Code modernization (drop --dry-run to apply), not run in CI
vendor/bin/rector process --dry-run

# composer.json validation and normalization
composer validate --strict
composer normalize --dry-run
```

## Adding a component

Follow the [composition pattern](https://tabler-ux-components.silarhi.dev/getting-started/composition/): a main
component in `templates/components/Tabler/<Name>.html.twig` taking all the props, with a block per prop, and its
sub-components in `templates/components/Tabler/<Name>/`. Cover it with a test in `tests/Component/`, and document it in
the same pull request.

### Template rules

Templates never bypass Twig's autoescaping: `tests/TemplateConventionsTest.php` fails on any `|raw` or
`{% autoescape false %}`.

- **Props are text, slots are markup.** Prop values are always escaped; HTML only comes in through blocks and
  sub-components (e.g. `Alert`'s `icon` prop is an icon name, custom SVG goes in the `icon` block).
- **Pick the element, don't duplicate the content.** When a component renders `<a>`, `<button>` or `<span>` depending
  on its props, the tag name is dynamic (`<{{ tag }}>…</{{ tag }}>`) and the `content` block is defined once. An
  optional wrapper is opened and closed under the same `{% if %}`.
- **Capture only to test for emptiness.** A captured `{% set x %}…{% endset %}` block is already escaped and marked
  safe: print it as `{{ x }}`, never through `|raw`, and never joined with `~` for output (that escapes it twice).
- **Never forward a possibly-null value as an HTML attribute.** Older ux-twig-component releases render a `null`
  attribute as `"true"`; guard it with `{% if %}`, or make it a declared prop.

## Documentation

The documentation site, [tabler-ux-components.silarhi.dev](https://tabler-ux-components.silarhi.dev), is built from
the [`docs/`](docs) folder with [Starlight](https://starlight.astro.build). Each component has a page in
`docs/src/content/docs/components/`, whose examples are Twig files in `docs/examples/<component>/`. They are rendered
with the components themselves: run the script after changing an example or a template, and commit its output. The
CI fails when a committed render is missing or out of date (`--check`).

```bash
php docs/scripts/render-examples.php          # every example
php docs/scripts/render-examples.php card     # the examples of docs/examples/card/ only

cd docs
pnpm install
pnpm dev # http://localhost:4321
```

Pull requests touching `docs/` build the site; it is published once merged into `main`.

## License

By contributing, you agree that your contributions are released under the [MIT License](LICENSE).
