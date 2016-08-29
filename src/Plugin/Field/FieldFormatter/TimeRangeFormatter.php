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

      if (!empty($item->end)) {
        $elements[$delta] = [
          '#markup' => $this->t('@start to @end', [
            '@start' => ltrim($item->start, "0"),
            '@end' => ltrim($item->end, "0"),
          ]),
        ];
      }
      else {
        $elements[$delta] = [
          '#markup' => $this->t('@start', [
            '@start' => ltrim($item->start, "0"),
          ]),
        ];
      }

    }

    return $elements;
  }

}
