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

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withCache(__DIR__ . '/var/tools/rector')
    ->withPaths([
        'src',
        'tests',
    ])
    ->withPhpSets(php82: true)
    ->withComposerBased(
        twig: true,
        symfony: true,
    )
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
    );
