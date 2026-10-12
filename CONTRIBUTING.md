# Contributing

Contributions are welcome! Bug reports and feature requests go to the
[issue tracker](https://github.com/silarhi/tabler-ux-components/issues), changes to a pull request against `main`.

## Setup

```bash
composer install
```

## Quality checks

The CI runs them all, on every supported PHP and Symfony version:

```bash
# Tests
vendor/bin/phpunit

# Static analysis (level: max)
vendor/bin/phpstan analyse

# Code style (drop --dry-run --diff to fix)
vendor/bin/php-cs-fixer fix --dry-run --diff

# Twig code style (add --fix to fix)
vendor/bin/twig-cs-fixer lint

# Code modernization (drop --dry-run to apply)
vendor/bin/rector process --dry-run
```

## Adding a component

Follow the [composition pattern](https://tabler-ux-components.silarhi.dev/getting-started/composition/): a main
component in `templates/components/Tabler/<Name>.html.twig` taking all the props, with a block per prop, and its
sub-components in `templates/components/Tabler/<Name>/`. Cover it with a test in `tests/Component/`, and document it in
the same pull request.

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
yarn install
yarn dev # http://localhost:4321
```

Pull requests touching `docs/` build the site; it is published once merged into `main`.

## License

By contributing, you agree that your contributions are released under the [MIT License](LICENSE).
