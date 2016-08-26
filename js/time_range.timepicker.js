/**
 * @file
 *
 */

(function ($, Drupal) {

  //"use strict";

  /**
   * Behaviors for the time_range timepicker.
   */
  Drupal.behaviors.timeRangeTimePicker = {
    attach: function (context, settings) {
      $('.timepicker-wrapper input', context).once().timepicker();
    }
  };

})(jQuery, Drupal);
