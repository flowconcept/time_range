<?php

/**
 * @file
 * Contains \Drupal\time_range\Plugin\Field\FieldFormatter\TimeRangeFormatter.
 */

namespace Drupal\time_range\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;


/**
 * Plugin implementation of the 'default' formatter for 'time_range' fields.
 *
 * @FieldFormatter(
 *   id = "time_range_default",
 *   label = @Translation("Default"),
 *   field_types = {
 *     "time_range"
 *   }
 * )
 */
class TimeRangeFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      // The text value has no text format assigned to it, so the user input
      // should equal the output, including newlines.
      $elements[$delta]['start'] = [
        '#type' => 'inline_template',
        '#template' => '{{ value|nl2br }}',
        '#context' => ['value' => $item->start],
      ];
      $elements[$delta]['end'] = [
        '#type' => 'inline_template',
        '#template' => '{{ value|nl2br }}',
        '#context' => ['value' => $item->end],
      ];

    }

    return $elements;
  }

}
