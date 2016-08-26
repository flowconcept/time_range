<?php

/**
 * @file
 * Contains \Drupal\time_range\Plugin\field\field_type\TimeRangeItem.
 */

namespace Drupal\time_range\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'country' field type.
 *
 * @FieldType(
 *   id = "time_range",
 *   label = @Translation("Time Range"),
 *   description = @Translation("Stores a time range."),
 *   category = @Translation("Custom"),
 *   default_formatter = "time_range_default",
 *   default_widget = "time_range_timepicker"
 * )
 */
class TimeRangeItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['start'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('From'))
      ->setRequired(TRUE);
    $properties['end'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('To'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function mainPropertyName() {
    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return array(
      'columns' => array(
        'start' => array(
          'type' => 'varchar',
          'length' => 20,
        ),
        'end' => array(
          'type' => 'varchar',
          'length' => 20,
        ),
      ),
      'indexes' => array(
        'start' => array('start'),
        'end' => array('end'),
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    return empty($this->start) && empty($this->end);
  }
}