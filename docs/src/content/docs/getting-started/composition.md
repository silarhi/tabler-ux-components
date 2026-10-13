---
title: Composition
description: All-in-one tags, sub-components, blocks and attributes, the building blocks every component shares.
sidebar:
    order: 2
---

Every component follows the [shadcn](https://ui.shadcn.com/) composition pattern: a main component taking all the
props, and dedicated sub-components for each of its parts. The same component then covers both the one-liner and the
fully custom case.

## All-in-one

Props cover the common case in a single tag:

```twig
<twig:Tabler:Alert variant="success" title="Saved!" description="Your changes are live." />
```

## Composed

Sub-components take over when the content is more than a string:

```twig
<twig:Tabler:Alert variant="success">
    <twig:Tabler:Alert:Icon><twig:Tabler:Icon name="check" /></twig:Tabler:Alert:Icon>
    <twig:Tabler:Alert:Title>Saved!</twig:Tabler:Alert:Title>
    <twig:Tabler:Alert:Description>
        Your changes are <strong>live</strong>.
    </twig:Tabler:Alert:Description>
</twig:Tabler:Alert>
```

## Blocks

On composite components, each prop has a matching Twig block whose default renders the sub-component with the prop
value. Override one block and keep the others:

```twig
<twig:Tabler:Alert variant="success" title="Saved!" description="Your changes are live.">
    <twig:block name="title">
        <twig:Tabler:Alert:Title class="display-6">Custom heading</twig:Tabler:Alert:Title>
    </twig:block>
</twig:Tabler:Alert>
```

The `content` block wraps all the others: replace it to compose freely, as in the composed example above, where the
children of the tag become the `content` block.

## Attributes

Attributes that are not props (`class`, `id`, `data-*`, `aria-*`…) are forwarded to the root element. Classes are
merged with the ones of the component:

```twig
<twig:Tabler:Button variant="primary" class="ms-auto" data-action="live#action">Save</twig:Tabler:Button>
```

## Boolean props

A bare attribute is `true`: `<twig:Tabler:Alert dismissible />`. To pass `false`, use a Twig expression, since
`dismissible="false"` passes the string `"false"`, which is truthy:

```twig
<twig:Tabler:Modal id="confirm" title="Delete item?" dismissible="{{ false }}" />
```

## Whitespace

Each component ends its output with a line break, like an element on its own line in HTML: components written on
consecutive lines are separated by a space, with the self-closing and the closing-tag syntax alike. In running text,
that line break shows as a space after the component: `Click <twig:Tabler:Badge>New</twig:Tabler:Badge>.` reads
"Click New .".

The self-closing and the closing-tag syntax don't output exactly the same whitespace, though. A closing tag compiles
to `{% endcomponent %}`, and Twig drops the line break right after a `%}` tag, so only the component's own line break
remains. A self-closing tag compiles to `{{ component() }}`, which keeps the line break written after it:

| Two components on consecutive lines                                                      | Output between them |
| ---------------------------------------------------------------------------------------- | ------------------- |
| `<twig:Tabler:Icon name="…" />` or `{{ component() }}`                                   | two line breaks     |
| `<twig:Tabler:Icon name="…"></twig:Tabler:Icon>` or `{% component %}…{% endcomponent %}` | one line break      |

Browsers collapse both into a single space, so the page looks the same. The difference only shows inside
`white-space: pre` / `pre-wrap` / `pre-line` content, or in tests that compare the raw HTML.

For a row of components, a list component (`Badge:List`, `Avatar:List`, `ButtonList`…) or a flex container with a
gap gives a consistent spacing:

```twig
<twig:Tabler:Badge:List>
    <twig:Tabler:Badge variant="success">Paid</twig:Tabler:Badge>
    <twig:Tabler:Badge variant="warning">Pending</twig:Tabler:Badge>
</twig:Tabler:Badge:List>
```

## Escaping

Prop values are text: they are always escaped, so `title="<b>Saved</b>"` prints the tags as text. HTML comes in
through blocks and sub-components only. A prop that names something renders it for you: Alert's `icon` prop takes a
[Tabler icon](https://tabler.io/icons) name, and custom markup, such as an inline SVG, goes in its `icon` block:

```twig
<twig:Tabler:Alert variant="info" icon="info-circle" title="Heads up" />

<twig:Tabler:Alert variant="info" title="Heads up">
    <twig:block name="icon">
        <twig:Tabler:Alert:Icon><svg class="icon">…</svg></twig:Tabler:Alert:Icon>
    </twig:block>
</twig:Tabler:Alert>
```

The components never bypass Twig's autoescaping: no `|raw` and no `{% autoescape false %}` in a template.

## Variants

Classes are declared with [`html_cva()`](https://twig.symfony.com/doc/3.x/functions/html_cva.html) from
`twig/html-extra`, Twig's take on shadcn's CVA:

```twig
{% set alert = html_cva(
    base: 'alert',
    variants: {
        variant: { success: 'alert-success', danger: 'alert-danger', ... },
        important: { true: 'alert-important', false: '' },
        minor: { true: 'alert-minor', false: '' },
        dismissible: { true: 'alert-dismissible', false: '' },
    },
    compound_variants: [
        { important: [true], class: 'text-white' },
    ],
) %}

{# html_cva converts boolean recipe values to the string keys 'true'/'false' #}
<div class="{{ alert.apply({variant, important, minor, dismissible}, attributes.render('class')) }}">
```

When two axes both emit a color-dependent class (Button's `appearance` × `variant`, Badge's `light` × `variant`), the
classes live entirely in `compound_variants`, so only one wins:

```twig
compound_variants: [
    { appearance: ['outline'], variant: ['primary'], class: 'btn-outline-primary' },
    { appearance: ['ghost'],   variant: ['primary'], class: 'btn-ghost-primary' },
    ...
]
```

## File layout

```
templates/components/Tabler/
    Alert.html.twig              # Main: all props + block-mirrored sub-components
    Alert/
        Icon.html.twig           # <twig:Tabler:Alert:Icon>
        Title.html.twig          # <twig:Tabler:Alert:Title>
        Description.html.twig    # <twig:Tabler:Alert:Description>
        List.html.twig           # <twig:Tabler:Alert:List>
        Link.html.twig           # <twig:Tabler:Alert:Link>
        Action.html.twig         # <twig:Tabler:Alert:Action>
        Dismiss.html.twig        # <twig:Tabler:Alert:Dismiss>
```

## Not included

Tabler components that require third-party JavaScript libraries are out of scope: Chart, Dropzone, Countup, Inline
player, Range slider, Vector map, WYSIWYG, Autosize, Datepicker, and the interactive star rating (the read-only
[StarRating](/components/data/star-rating/) is included). Form controls (OTP input, password strength) are not covered
yet.
