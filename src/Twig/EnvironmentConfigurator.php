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

namespace Silarhi\TablerUxComponents\Twig;

use Closure;
use Twig\Environment;

/**
 * Installs the bundle's ComponentLexer once ux-twig-component has set its own:
 * through a setLexer() call (3.x) or its own environment configurator (2.x),
 * both of which run before this decorator.
 *
 * @internal
 */
final readonly class EnvironmentConfigurator
{
    /** @var Closure(Environment): void */
    private Closure $decorated;

    /**
     * @param callable(Environment): void $decorated the decorated configurator's configure() method
     */
    public function __construct(callable $decorated)
    {
        $this->decorated = $decorated(...);
    }

    public function configure(Environment $environment): void
    {
        ($this->decorated)($environment);

        $environment->setLexer(new ComponentLexer($environment));
    }
}
