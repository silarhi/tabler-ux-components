# Tabler kit for Symfony UX Toolkit

[Tabler](https://tabler.io/) components for the [Symfony UX Toolkit](https://ux.symfony.com/toolkit): install a
component and its templates are copied into your application, yours to edit.

```bash
composer require --dev symfony/ux-toolkit symfony/http-client
php bin/console ux:install alert --kit=github.com/silarhi/tabler-ux-kit
```

The Toolkit downloads this kit from GitHub: it needs `symfony/http-client` and PHP's `zip` extension. Pin a release by
adding its version: `--kit=github.com/silarhi/tabler-ux-kit:1.0.0`. Read [INSTALL.md](INSTALL.md) to load Tabler on
the front-end, and the [documentation](https://tabler-ux-components.silarhi.dev) for every component.

Prefer a Composer dependency that you update? The same components ship as a Symfony bundle:
[silarhi/tabler-ux-components](https://github.com/silarhi/tabler-ux-components).

> [!IMPORTANT]
> **This repository is read-only.** It is generated from
> [silarhi/tabler-ux-components](https://github.com/silarhi/tabler-ux-components) on each release: report issues and
> send pull requests there.

## License

MIT, see [LICENSE](LICENSE).
