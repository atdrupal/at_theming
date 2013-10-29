<?php

/**
 * @file
 * Bulk export of boxes objects generated by Bulk export module.
 */

/**
 * Implements hook_box_admin_ui_types().
 */
function atest_theming_box_admin_ui_types() {
  $export = array();

  $box_type = new stdClass();
  $box_type->disabled = FALSE; /* Edit this to true to make a default box_type disabled initially */
  $box_type->api_version = 6;
  $box_type->name = 'atest_theming_block_type';
  $box_type->label = 'ATest Theming Block Type';
  $box_type->options = '';
  $box_type->description = '';
  $export['atest_theming_block_type'] = $box_type;

  return $export;
}