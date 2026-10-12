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

use Silarhi\TablerUxComponents\Tests\Fixtures\TestKernel;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

// Renders the examples of the documentation with the components themselves, so the previews and the HTML the pages
// show are what the components really output.
//
//     php docs/scripts/render-examples.php            # every example
//     php docs/scripts/render-examples.php card       # the examples of docs/examples/card/ only
//     php docs/scripts/render-examples.php --check    # fails when a committed render is missing or out of date (CI)
//
// Reads docs/examples/<component>/<example>.html.twig, writes docs/src/data/examples/<component>/<example>.html.

require \dirname(__DIR__, 2) . '/vendor/autoload.php';

$examples = \dirname(__DIR__) . '/examples';
$output = \dirname(__DIR__) . '/src/data/examples';
$arguments = \array_slice($argv, 1);
$check = \in_array('--check', $arguments, true);
$only = array_values(array_diff($arguments, ['--check']))[0] ?? null;

$kernel = new TestKernel('test', false);
// Without debug, Twig never checks its compiled templates: start from an empty cache, or it renders the old ones
(new Filesystem())->remove($kernel->getCacheDir());
$kernel->boot();
/** @var Environment $twig */
$twig = $kernel->getContainer()->get('test.service_container')->get('twig');

/** @var array<string, string> $renders render name => HTML */
$renders = [];
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($examples, FilesystemIterator::SKIP_DOTS));
foreach ($files as $file) {
    if (!str_ends_with($file->getFilename(), '.html.twig')) {
        continue;
    }

    $name = substr($file->getPathname(), \strlen($examples) + 1, -\strlen('.twig'));
    if (null !== $only && !str_starts_with($name, "{$only}/")) {
        continue;
    }
    $html = $twig->createTemplate((string) file_get_contents($file->getPathname()), $name)->render();
    // Blank lines left by Twig tags; the page formats the rest
    $renders[$name] = trim((string) preg_replace('/\n\s*\n/', "\n", $html)) . "\n";
}
ksort($renders);

// Renders without an example any more, only known when every example was rendered
$stale = [];
if (null === $only && is_dir($output)) {
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($output, FilesystemIterator::SKIP_DOTS)) as $file) {
        $name = substr($file->getPathname(), \strlen($output) + 1);
        if (!isset($renders[$name])) {
            $stale[] = $name;
        }
    }
}

if ($check) {
    $errors = [];
    foreach ($renders as $name => $html) {
        $committed = @file_get_contents("{$output}/{$name}");
        if (false === $committed) {
            $errors[] = "missing   {$name}";
        } elseif ($committed !== $html) {
            $errors[] = "outdated  {$name}";
        }
    }
    foreach ($stale as $name) {
        $errors[] = "stale     {$name}";
    }

    if ([] !== $errors) {
        fwrite(\STDERR, implode("\n", $errors) . "\n\nThe documentation examples do not match the components: run php docs/scripts/render-examples.php and commit docs/src/data/examples/.\n");
        exit(1);
    }

    echo \count($renders) . " examples up to date\n";
    exit(0);
}

foreach ($renders as $name => $html) {
    @mkdir(\dirname("{$output}/{$name}"), 0o755, true);
    file_put_contents("{$output}/{$name}", $html);
}
foreach ($stale as $name) {
    unlink("{$output}/{$name}");
}

echo implode("\n", array_keys($renders)) . "\n";
