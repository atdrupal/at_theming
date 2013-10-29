<?php
/**
 * @file
 * atest_theming.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function atest_theming_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "boxes_admin_ui" && $api == "boxes") {
    return array("version" => "6");
  }
}
