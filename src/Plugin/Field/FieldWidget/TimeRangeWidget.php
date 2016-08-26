<?php

namespace Drupal\time_range\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

/**
 * Plugin implementation of the 'time_range_timepicker' widget.
 *
 * @FieldWidget(
 *   id = "time_range_timepicker",
 *   label = @Translation("TimePicker"),
 *   field_types = {
 *     "time_range"
 *   }
 * )
 */
class TimeRangeWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'timeFormat' => 'H:i',
      'step' => '15',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $element['timeFormat'] = array(
      '#type' => 'textfield',
      '#title' => t('How times should be displayed in the list and input element. Uses PHP\'s date() formatting syntax.'),
      '#size' => 10,
      '#maxlength' => 10,
      '#default_value' => $this->getSetting('timeFormat'),
    );
    $element['step'] = array(
      '#type' => 'textfield',
      '#title' => t('The amount of time, in minutes, between each item in the dropdown.'),
      '#size' => 2,
      '#maxlength' => 5,
      '#default_value' => $this->getSetting('step'),
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $summary[] = t('timeFormat: @timeFormat', array('@timeFormat' => $this->getSetting('timeFormat')));
    $summary[] = t('step: @step', array('@step' => $this->getSetting('step')));
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    // We are nesting some sub-elements inside the parent, so we need a wrapper.
    // We also need to add another #title attribute at the top level for ease in
    // identifying this item in error messages. We do not want to display this
    // title because the actual title display is handled at a higher level by
    // the Field module.

    $element['#theme_wrappers'][] = 'fieldset';

    $element['#attached']['library'][] = 'time_range/drupal.time_range.timepicker';
    $element['#attributes']['class'][] = 'timepicker-wrapper container-inline';
    $element['#attributes']['data-timeFormat'] = 'H:i'; #[$element['#timeFormat']];


    $element['start'] = [
      '#type' => 'textfield',
      '#title' => $this->t('From'),
      '#size' => 5,
      '#maxlength' => 5,
      '#default_value' => $items[$delta]->start,
      '#required' => $element['#required'],
    ];

    $element['end'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('To'),
      '#size' => 5,
      '#maxlength' => 5,
      '#default_value' => $items[$delta]->end,
      '#required' => FALSE,
    );

    foreach (Element::children($element) as $child) {
      // timepicker setting is timeFormat, see https://www.w3.org/TR/html5/dom.html#dom-dataset
      $element[$child]['#attributes']['data-time-format'] = $this->getSetting('timeFormat');
      $element[$child]['#attributes']['data-step'] = $this->getSetting('step');
    }

    return $element;
  }

}
