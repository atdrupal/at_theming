<?php

namespace Drupal\at_theming\Breadcrumb;

use Drupal\at_theming\Breadcrumb\BreadcrumbBase;

class pages extends BreadcrumbBase {

  /**
   * Storage configuration "path" match
   * @var type 
   */
  private $path_match_config_value = FALSE;

  function __construct() {
    $this->pages_breadcrumb();
  }

  private function pages_breadcrumb() {
    if ($this->match_path()) {
      $this->setBreadcrumb($this->path_match_config_value);
    }
  }

  private function match_path() {
    $current_path = drupal_get_normal_path(request_path());
    $breadcrumbs_config = $this->read_module_breadcrumb_Config();
    foreach ($breadcrumbs_config as $config) {
      if (!isset($config['pages'])) {
        break;
      }
      foreach ($config['pages'] as $path => $config) {
        $path = str_replace('*', '(.+?)', $path);
        $path = drupal_get_normal_path($path);
        $path = str_replace('/', '\/', $path);
        if (preg_match("/^{$path}$/", $current_path)) {
          $this->path_match_config_value = $config;
          return TRUE;
        }
      }
    }
    return FALSE;
  }

}