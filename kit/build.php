<?php

declare(strict_types=1);

/*
 * This file is part of the Tabler UX Components Bundle package.
 *
 * (c) SILARHI <dev@silarhi.fr>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

// Builds the Symfony UX Toolkit kit (https://ux.symfony.com/toolkit) from the components and their documentation: one
// recipe per component, with its templates and a README.md converted from its documentation page.
//
//     php kit/build.php              # writes the kit in var/kit/
//     php kit/build.php <directory>  # writes it elsewhere, e.g. a checkout of silarhi/tabler-ux-kit (keeps its .git)
//
// CI publishes it to the read-only repository github.com/silarhi/tabler-ux-kit on each release.

const SITE = 'https://tabler-ux-components.silarhi.dev';

$root = \dirname(__DIR__);
$components = $root . '/templates/components/Tabler';
$pages = $root . '/docs/src/content/docs/components';
$examples = $root . '/docs/examples';
$output = rtrim($argv[1] ?? $root . '/var/kit', '/');

/** @return list<string> the files of a component: its template and its sub-components */
function componentFiles(string $components, string $component): array
{
    $files = [$components . "/{$component}.html.twig"];
    if (is_dir($directory = $components . "/{$component}")) {
        $files = [...$files, ...glob($directory . '/*.html.twig') ?: []];
    }

    return $files;
}

function recipeName(string $component): string
{
    return strtolower((string) preg_replace('/(?<=[a-z0-9])(?=[A-Z])/', '-', $component));
}

/** @return array{title: string, description: string, readme: string} */
function readme(string $page, string $examples): array
{
    $source = (string) file_get_contents($page);
    if (1 !== preg_match('/\A---\n(?<frontmatter>.*?)\n---\n(?<body>.*)\z/s', $source, $matches)) {
        throw new RuntimeException("{$page}: no frontmatter.");
    }
    preg_match('/^title: *(?<value>.+)$/m', $matches['frontmatter'], $title);
    preg_match('/^description: *(?<value>.+)$/m', $matches['frontmatter'], $description);
    $title = trim($title['value'] ?? throw new RuntimeException("{$page}: no title."), '\'" ');
    $description = trim($description['value'] ?? '', '\'" ');

    $body = (string) preg_replace('/^import .*\n/m', '', $matches['body']);
    // <Example name="alert/variants" /> becomes a code block the Toolkit renders with a live preview
    $body = (string) preg_replace_callback('/<Example name="(?<name>[^"]+)"[^>]*\/>/', static function (array $example) use ($examples, $page): string {
        $file = $examples . "/{$example['name']}.html.twig";
        if (!is_file($file)) {
            throw new RuntimeException("{$page}: the example \"{$example['name']}\" does not exist.");
        }

        return "```twig {\"preview\":true}\n" . trim((string) file_get_contents($file)) . "\n```";
    }, $body);
    // Links to other pages of the site
    $body = str_replace('](/', '](' . SITE . '/', $body);
    // The Toolkit renders the installation steps in place of the directive, before the first section
    $installation = "## Installation\n\n::: installation\n";
    $body = str_contains($body, "\n## ")
        ? (string) preg_replace('/\n## /', "\n{$installation}\n## ", $body, 1)
        : rtrim($body) . "\n\n{$installation}";

    $readme = "# {$title}\n\n" . trim((string) preg_replace('/\n{3,}/', "\n\n", $body)) . "\n";

    return ['title' => $title, 'description' => $description, 'readme' => $readme];
}

function write(string $file, string $contents): void
{
    if (!is_dir(\dirname($file))) {
        mkdir(\dirname($file), 0o777, true);
    }
    file_put_contents($file, $contents);
}

function json(mixed $value): string
{
    return json_encode($value, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE | \JSON_THROW_ON_ERROR) . "\n";
}

// Start from an empty directory, except the .git of a checkout
if (is_dir($output)) {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($output, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($files as $file) {
        $relative = substr($file->getPathname(), \strlen($output) + 1);
        if ('.git' === $relative || str_starts_with($relative, '.git/')) {
            continue;
        }
        $file->isDir() && !$file->isLink() ? rmdir($file->getPathname()) : unlink($file->getPathname());
    }
}

foreach (['manifest.json', 'INSTALL.md', 'README.md', 'icon.svg'] as $file) {
    write("{$output}/{$file}", (string) file_get_contents(__DIR__ . "/{$file}"));
}
write("{$output}/LICENSE", (string) file_get_contents($root . '/LICENSE'));

$names = array_map(static fn (string $file): string => basename($file, '.html.twig'), glob($components . '/*.html.twig') ?: []);
foreach ($names as $component) {
    $recipe = recipeName($component);
    $files = componentFiles($components, $component);
    $sources = implode("\n", array_map(static fn (string $file): string => (string) file_get_contents($file), $files));

    $pageFiles = glob($pages . "/*/{$recipe}.mdx") ?: [];
    if (1 !== \count($pageFiles)) {
        throw new RuntimeException("{$component}: expected one documentation page {$recipe}.mdx, found " . \count($pageFiles) . '.');
    }
    $doc = readme($pageFiles[0], $examples);

    // The other components it renders, installed along with it; not the ones its doc comments only mention
    preg_match_all('/<twig:Tabler:(?<component>[A-Za-z]+)/', (string) preg_replace('/\{#.*?#\}/s', '', $sources), $matches);
    $recipes = array_values(array_unique(array_map(recipeName(...), array_diff($matches['component'], [$component]))));
    foreach ($recipes as $dependency) {
        if (!\in_array($dependency, array_map(recipeName(...), $names), true)) {
            throw new RuntimeException("{$component}: renders the unknown component of recipe \"{$dependency}\".");
        }
    }
    sort($recipes);

    $dependencies = [];
    if ([] !== $recipes) {
        $dependencies['recipe'] = $recipes;
    }
    if (str_contains($sources, 'html_cva(')) {
        $dependencies['composer'] = ['twig/extra-bundle', 'twig/html-extra:^3.12.0'];
    }
    // Icon renders the names with an icon set prefix with symfony/ux-icons
    if (str_contains((string) preg_replace('/\{#.*?#\}/s', '', $sources), '<twig:ux:icon')) {
        $dependencies['composer'] = [...$dependencies['composer'] ?? [], 'symfony/ux-icons'];
    }

    write("{$output}/{$recipe}/manifest.json", json(array_filter([
        'type' => 'component',
        'name' => $doc['title'],
        'description' => $doc['description'],
        'copy-files' => ['templates/' => 'templates/'],
        'dependencies' => $dependencies,
    ], static fn (mixed $value): bool => '' !== $value && [] !== $value)));
    write("{$output}/{$recipe}/README.md", $doc['readme']);
    foreach ($files as $file) {
        write("{$output}/{$recipe}/templates/components/Tabler/" . substr($file, \strlen($components) + 1), (string) file_get_contents($file));
    }
}

echo \sprintf("Built %d recipes in %s\n", \count($names), $output);
