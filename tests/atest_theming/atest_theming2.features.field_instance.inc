<?php
/**
 * @file
 * atest_theming.features.field_instance.inc
 */

/**
 * Implements hook_field_default_field_instances().
 */
function atest_theming_field_default_field_instances() {
  $field_instances = array();

  // Exported field_instance: 'box-atest_theming_block_type-field_atest_theming_box_body'
  $field_instances['box-atest_theming_block_type-field_atest_theming_box_body'] = array(
    'bundle' => 'atest_theming_block_type',
    'default_value' => NULL,
    'deleted' => 0,
    'description' => '',
    'display' => array(
      'default' => array(
        'label' => 'above',
        'module' => 'text',
        'settings' => array(),
        'type' => 'text_default',
        'weight' => 0,
      ),
    ),
    'entity_type' => 'box',
    'field_name' => 'field_atest_theming_box_body',
    'label' => 'Body',
    'required' => 0,
    'settings' => array(
      'text_processing' => 0,
      'user_register_form' => FALSE,
    ),
    'widget' => array(
      'active' => 1,
      'module' => 'text',
      'settings' => array(
        'rows' => 5,
      ),
      'type' => 'text_textarea',
      'weight' => 1,
    ),
  );

  // Translatables
  // Included for use with string extractors like potx.
  t('Body');

  return $field_instances;
}
