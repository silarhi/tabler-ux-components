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

namespace Silarhi\TablerUxComponents\Tests\Form;

use DOMDocument;
use DOMElement;
use DOMXPath;
use Silarhi\TablerUxComponents\Tests\ComponentTestCase;

use function sprintf;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;

/**
 * Renders real Symfony forms through the Tabler form themes.
 */
abstract class FormThemeTestCase extends ComponentTestCase
{
    protected const LAYOUT = '@TablerUxComponents/form/tabler_layout.html.twig';
    protected const HORIZONTAL_LAYOUT = '@TablerUxComponents/form/tabler_horizontal_layout.html.twig';

    /**
     * @param class-string<FormTypeInterface<mixed>> $type
     * @param array<string, mixed>                   $options
     *
     * @return FormInterface<mixed>
     */
    protected function createField(string $type, array $options = [], mixed $data = null): FormInterface
    {
        /** @var FormFactoryInterface $factory */
        $factory = self::getContainer()->get('test.form.factory');

        return $factory->createNamed('field', $type, $data, $options);
    }

    /**
     * @param FormInterface<mixed> $form
     */
    protected function renderForm(FormInterface $form, string $function = 'form_widget', string $theme = self::LAYOUT): string
    {
        return $this->renderComponent(
            sprintf("{%% form_theme form '%s' %%}{{ %s(form) }}", $theme, $function),
            ['form' => $form->createView()],
        );
    }

    /**
     * The elements matching an XPath query in an HTML fragment: the forms are asserted on their structure, since
     * Symfony's own markup (attribute order, `required="required"`…) differs between releases.
     *
     * @return list<DOMElement>
     */
    protected static function query(string $html, string $expression): array
    {
        $document = new DOMDocument();
        $document->loadHTML('<?xml encoding="utf-8"?><body>' . $html . '</body>', \LIBXML_NOERROR | \LIBXML_HTML_NODEFDTD);

        $nodes = (new DOMXPath($document))->query($expression);
        self::assertNotFalse($nodes, 'Invalid XPath expression: ' . $expression);

        $elements = [];
        foreach ($nodes as $node) {
            if ($node instanceof DOMElement) {
                $elements[] = $node;
            }
        }

        return $elements;
    }

    protected static function assertMatches(int $count, string $html, string $expression): void
    {
        self::assertCount($count, self::query($html, $expression), sprintf("%s in:\n%s", $expression, $html));
    }

    /**
     * An XPath condition on a class name, for `//div[%s]`.
     */
    protected static function hasClass(string $class): string
    {
        return sprintf('contains(concat(" ", normalize-space(@class), " "), " %s ")', $class);
    }
}
