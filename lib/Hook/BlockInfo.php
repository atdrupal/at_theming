<?php
namespace Drupal\at_theming\Hook;

class BlockInfo {
  public function import() {
    $info = array();
    foreach (at_modules('at_theming') as $module_name) {
      $path = DRUPAL_ROOT . '/' . drupal_get_path('module', $module_name) . '/config/block.yml';
      if (file_exists($path)) {
        $info += $this->importResource($module_name);
      }
    }
    return $info;
  }

  private function importResource($module) {
    $info = array();
    foreach (at_config($module, 'block')->get('blocks') as $k => $block) {
      $info["{$module}___{$k}"] = array(
        'info' => !empty($block['info']) ? $block['info'] : $k,
        'cache' => !empty($block['cache']) ? constant($block['cache']) : DRUPAL_CACHE_PER_ROLE,
      );
    }
    return $info;
  }
}
