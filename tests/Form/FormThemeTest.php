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

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormError;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

final class FormThemeTest extends FormThemeTestCase
{
    private const PERIODS = ['Day' => 'day', 'Week' => 'week', 'Month' => 'month'];

    public function testPlainFieldKeepsTheBootstrapMarkup(): void
    {
        $html = $this->renderForm($this->createField(EmailType::class), 'form_row');

        self::assertMatches(1, $html, '//div[@class="mb-3"]/label[' . self::hasClass('form-label') . ' and ' . self::hasClass('required') . ']');
        self::assertMatches(1, $html, '//div[@class="mb-3"]/input[@type="email" and @class="form-control"]');
        self::assertMatches(0, $html, '//*[' . self::hasClass('input-icon') . ']');
    }

    public function testHelpIsAFormHint(): void
    {
        $html = $this->renderForm($this->createField(TextType::class, ['help' => 'At least 8 characters.']), 'form_row');

        self::assertMatches(1, $html, '//small[@id="field_help" and @class="form-hint" and text()="At least 8 characters."]');
        self::assertMatches(1, $html, '//input[@aria-describedby="field_help"]');
    }

    public function testIconAtTheEndByDefault(): void
    {
        $html = $this->renderForm($this->createField(TextType::class, ['icon' => 'search']));

        self::assertMatches(1, $html, '/html/body/div[@class="input-icon"]/input[@class="form-control"]/following-sibling::span[@class="input-icon-addon"]/i[@class="ti ti-search"]');
    }

    public function testIconAtTheStart(): void
    {
        $html = $this->renderForm($this->createField(TextType::class, ['icon' => 'mail', 'icon_position' => 'start']));

        self::assertMatches(1, $html, '//div[@class="input-icon"]/span[@class="input-icon-addon"]/following-sibling::input[@id="field"]');
    }

    public function testLoaderReplacesTheIcon(): void
    {
        $html = $this->renderForm($this->createField(TextType::class, ['icon' => 'search', 'loader' => true]));

        self::assertMatches(1, $html, '//div[@class="input-icon"]/span[@class="input-icon-addon"]/*[' . self::hasClass('spinner-border') . ']');
        self::assertMatches(0, $html, '//i[' . self::hasClass('ti-search') . ']');
    }

    public function testInvalidFieldWithIcon(): void
    {
        $form = $this->createField(TextType::class, ['icon' => 'user']);
        $form->submit('x');
        $form->addError(new FormError('Too short.'));

        $html = $this->renderForm($form, 'form_row');

        self::assertMatches(1, $html, '//div[@class="input-icon"]/input[' . self::hasClass('is-invalid') . ']');
        // Symfony 6.4 gives the message no id: match its text
        self::assertMatches(1, $html, '//div[text()="Too short."]');
    }

    public function testHiddenFieldIgnoresTheIcon(): void
    {
        $html = $this->renderForm($this->createField(HiddenType::class, ['icon' => 'search']));

        self::assertMatches(1, $html, '/html/body/input[@type="hidden"]');
        self::assertMatches(0, $html, '//*[' . self::hasClass('input-icon') . ']');
    }

    public function testIntegerStepper(): void
    {
        $html = $this->renderForm($this->createField(IntegerType::class, ['stepper' => true, 'attr' => ['min' => 1, 'max' => 9]], 3));

        $root = '/html/body/div[@class="number-input" and @data-bs-toggle="number-input"]';
        self::assertMatches(1, $html, $root . '/button[@data-bs-number-input-action="decrement" and @aria-label="Decrease"]');
        self::assertMatches(1, $html, $root . '/input[@type="number" and @class="form-control" and @value="3" and @min="1" and @max="9" and @name="field"]');
        self::assertMatches(1, $html, $root . '/button[@data-bs-number-input-action="increment" and @aria-label="Increase"]');
    }

    public function testNumberStepperIsATextField(): void
    {
        $html = $this->renderForm($this->createField(NumberType::class, ['stepper' => true, 'icon' => 'search']));

        self::assertMatches(1, $html, '//div[@class="number-input"]/input[@type="text"]');
        self::assertMatches(0, $html, '//*[' . self::hasClass('input-icon') . ']');
    }

    public function testDisabledStepperDisablesItsButtons(): void
    {
        $html = $this->renderForm($this->createField(IntegerType::class, ['stepper' => true, 'disabled' => true]));

        self::assertMatches(2, $html, '//div[@class="number-input"]/button[@disabled]');
        self::assertMatches(1, $html, '//div[@class="number-input"]/input[@disabled]');
    }

    public function testIntegerWithoutStepper(): void
    {
        $html = $this->renderForm($this->createField(IntegerType::class));

        self::assertMatches(1, $html, '/html/body/input[@type="number" and @class="form-control"]');
    }

    public function testSegmentedChoice(): void
    {
        $html = $this->renderForm($this->createField(ChoiceType::class, [
            'choices' => self::PERIODS,
            'expanded' => true,
            'choice_style' => 'segmented',
            'choice_icon' => ['Day' => 'sun'],
            'choice_attr' => ['Week' => ['data-testid' => 'week']],
        ], 'week'), 'form_row');

        self::assertMatches(1, $html, '//fieldset/legend[' . self::hasClass('col-form-label') . ' and ' . self::hasClass('required') . ']');
        $nav = '//fieldset/nav[@id="field" and @class="nav nav-segmented" and @role="radiogroup"]';
        self::assertMatches(3, $html, $nav . '/input[@type="radio" and @name="field" and @class="nav-link-input btn-check d-block" and @required]');
        self::assertMatches(1, $html, $nav . '/input[@id="field_1" and @value="week" and @checked and @data-testid="week"]');
        self::assertMatches(1, $html, $nav . '/input[@id="field_0"]/following-sibling::label[1][@for="field_0" and @class="nav-link"]/i[@class="ti ti-sun nav-link-icon"]');
        self::assertMatches(1, $html, $nav . '/label[@for="field_2" and normalize-space()="Month"]');
        self::assertSame(1, substr_count($html, 'role='), 'The role of the control is rendered once.');
    }

    public function testMultipleSegmentedChoiceUsesCheckboxes(): void
    {
        $html = $this->renderForm($this->createField(ChoiceType::class, [
            'choices' => self::PERIODS,
            'expanded' => true,
            'multiple' => true,
            'choice_style' => 'segmented',
        ], ['day', 'month']));

        self::assertMatches(3, $html, '//nav[@role="group"]/input[@type="checkbox" and @name="field[]" and not(@required)]');
        self::assertMatches(2, $html, '//nav/input[@checked]');
    }

    public function testSegmentedChoiceClassesGoOnTheControl(): void
    {
        $html = $this->renderForm($this->createField(ChoiceType::class, [
            'choices' => self::PERIODS,
            'expanded' => true,
            'choice_style' => 'segmented',
            'attr' => ['class' => 'w-100 nav-sm'],
        ]));

        self::assertMatches(1, $html, '//nav[@class="nav nav-segmented w-100 nav-sm"]');
    }

    public function testInvalidSegmentedChoice(): void
    {
        $form = $this->createField(ChoiceType::class, ['choices' => self::PERIODS, 'expanded' => true, 'choice_style' => 'segmented']);
        $form->submit('day');
        $form->addError(new FormError('Pick another one.'));

        $html = $this->renderForm($form);

        self::assertMatches(1, $html, '//nav[' . self::hasClass('is-invalid') . ']');
    }

    public function testSelectgroupChoice(): void
    {
        $html = $this->renderForm($this->createField(ChoiceType::class, [
            'choices' => self::PERIODS,
            'expanded' => true,
            'choice_style' => 'selectgroup',
            'choice_icon' => static fn (string $choice): ?string => 'month' === $choice ? 'calendar' : null,
            'choice_attr' => ['Day' => ['data-testid' => 'day']],
        ], 'day'));

        $group = '/html/body/div[@id="field" and @class="form-selectgroup"]';
        self::assertMatches(3, $html, $group . '/label[@class="form-selectgroup-item"]/input[@type="radio" and @name="field" and @class="form-selectgroup-input" and @required]');
        self::assertMatches(1, $html, $group . '/label/input[@id="field_0" and @value="day" and @checked and @data-testid="day"]');
        self::assertMatches(1, $html, $group . '/label/span[@class="form-selectgroup-label"]/i[' . self::hasClass('ti-calendar') . ']');
        self::assertMatches(1, $html, $group . '/label/span[@class="form-selectgroup-label" and normalize-space()="Week"]');
    }

    public function testPillsAndBoxes(): void
    {
        $pills = $this->renderForm($this->createField(ChoiceType::class, [
            'choices' => self::PERIODS, 'expanded' => true, 'multiple' => true, 'choice_style' => 'pills',
        ]));
        self::assertMatches(3, $pills, '//div[@class="form-selectgroup form-selectgroup-pills"]/label/input[@type="checkbox" and @name="field[]"]');

        $boxes = $this->renderForm($this->createField(ChoiceType::class, [
            'choices' => self::PERIODS, 'expanded' => true, 'choice_style' => 'boxes',
        ]));
        self::assertMatches(3, $boxes, '//div[@class="form-selectgroup form-selectgroup-boxes"]/label//span[@class="form-selectgroup-check"]');
    }

    public function testChoiceLabelsAreTranslatedAndEscaped(): void
    {
        $html = $this->renderForm($this->createField(ChoiceType::class, [
            'choices' => ['<b>Bold</b>' => 'bold'],
            'expanded' => true,
            'choice_style' => 'segmented',
            'choice_translation_domain' => false,
        ]));

        self::assertStringContainsString('&lt;b&gt;Bold&lt;/b&gt;', $html);
        self::assertMatches(0, $html, '//label/b');
    }

    public function testChoiceStyleIsIgnoredWhenNotExpanded(): void
    {
        $html = $this->renderForm($this->createField(ChoiceType::class, ['choices' => self::PERIODS, 'choice_style' => 'segmented']));

        self::assertMatches(1, $html, '/html/body/select[@class="form-select"]');
    }

    public function testExpandedChoiceWithoutStyleKeepsTheChecks(): void
    {
        $html = $this->renderForm($this->createField(ChoiceType::class, ['choices' => self::PERIODS, 'expanded' => true]));

        self::assertMatches(3, $html, '//div[@class="form-check"]/input[@class="form-check-input"]');
    }

    public function testUnknownChoiceStyle(): void
    {
        $this->expectException(InvalidOptionsException::class);

        $this->createField(ChoiceType::class, ['choices' => self::PERIODS, 'expanded' => true, 'choice_style' => 'tabs']);
    }

    public function testSwitch(): void
    {
        $html = $this->renderForm($this->createField(CheckboxType::class, ['switch' => true, 'label_attr' => ['class' => 'fw-bold']]));

        self::assertMatches(1, $html, '//div[@class="form-check form-switch"]/input[@type="checkbox" and @class="form-check-input"]');
        self::assertMatches(1, $html, '//label[' . self::hasClass('fw-bold') . ' and ' . self::hasClass('form-check-label') . ']');
    }

    public function testCheckboxWithoutSwitch(): void
    {
        $html = $this->renderForm($this->createField(CheckboxType::class));

        self::assertMatches(1, $html, '//div[@class="form-check"]/input');
    }

    public function testHorizontalLayout(): void
    {
        $text = $this->renderForm($this->createField(TextType::class, ['icon' => 'search', 'help' => 'Hint.']), 'form_row', self::HORIZONTAL_LAYOUT);

        self::assertMatches(1, $text, '//div[' . self::hasClass('row') . ']/label[' . self::hasClass('col-sm-2') . ' and ' . self::hasClass('col-form-label') . ']');
        self::assertMatches(1, $text, '//div[' . self::hasClass('row') . ']/div[@class="col-sm-10"]/div[@class="input-icon"]/input');
        self::assertMatches(1, $text, '//div[@class="col-sm-10"]/small[@class="form-hint"]');

        $choice = $this->renderForm($this->createField(ChoiceType::class, [
            'choices' => self::PERIODS, 'expanded' => true, 'choice_style' => 'segmented',
        ]), 'form_row', self::HORIZONTAL_LAYOUT);

        self::assertMatches(1, $choice, '//fieldset/div[@class="row"]/legend[' . self::hasClass('col-sm-2') . ']');
        self::assertMatches(1, $choice, '//fieldset/div[@class="row"]/div[@class="col-sm-10"]/nav[@class="nav nav-segmented"]');

        $stepper = $this->renderForm($this->createField(IntegerType::class, ['stepper' => true]), 'form_row', self::HORIZONTAL_LAYOUT);
        self::assertMatches(1, $stepper, '//div[@class="col-sm-10"]/div[@class="number-input"]/input');
    }
}
