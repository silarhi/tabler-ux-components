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

use Symfony\UX\TwigComponent\Twig\ComponentLexer as UxComponentLexer;
use Twig\Environment;
use Twig\Lexer;
use Twig\Source;
use Twig\TokenStream;

/**
 * Keeps the line break that follows a `</twig:Tabler:…>` closing tag.
 *
 * ux-twig-component turns a closing tag into `{% endcomponent %}`, and Twig
 * drops the first newline after a `%}`, so
 *
 *     <twig:Tabler:Badge>A</twig:Tabler:Badge>
 *     <twig:Tabler:Badge>B</twig:Tabler:Badge>
 *
 * rendered two touching badges, while the self-closing form, a `{{ }}`
 * expression, keeps its newline. An empty `{# ~#}` comment is inserted between
 * the tag and the newline: a comment closed by `~#}` only trims the spaces and
 * tabs after it, and adds no line, so error line numbers are unchanged.
 * Closing tags quoted in a comment or a verbatim block are skipped.
 *
 * The bundle's own templates are left alone: they control their whitespace
 * and render none around a component (see InlineWhitespaceTest).
 *
 * @internal
 */
final class ComponentLexer extends Lexer
{
    private const CLOSING_TAG_BEFORE_NEWLINE = '/
        \{%[-~]?\s*verbatim\s*[-~]?%\}.*?\{%[-~]?\s*endverbatim\s*[-~]?%\}(*SKIP)(*FAIL)
        | \{\#.*?\#\}(*SKIP)(*FAIL)
        | <\/twig:Tabler:[\w:.-]+>\K(?=\r?\n)
    /sx';

    private readonly Lexer $lexer;

    /**
     * @param array<string, mixed> $options
     */
    public function __construct(Environment $env, array $options = [])
    {
        parent::__construct($env, $options);

        $this->lexer = new UxComponentLexer($env, $options);
    }

    public function tokenize(Source $source): TokenStream
    {
        $code = $source->getCode();

        if (str_contains($code, '</twig:Tabler:') && !str_starts_with($source->getName(), 'components/Tabler/')) {
            $code = (string) preg_replace(self::CLOSING_TAG_BEFORE_NEWLINE, '{# ~#}', $code);
            $source = new Source($code, $source->getName(), $source->getPath());
        }

        return $this->lexer->tokenize($source);
    }
}
