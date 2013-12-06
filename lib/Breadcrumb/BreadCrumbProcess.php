<?php

namespace Drupal\at_theming\Breadcrumb;

class BreadCrumbProcess {

  private $plugin_obj_store = '';
  private static $startUp_storage = NULL;

  /**
   * Call BreadCrumbProcess()
   * 
   * @return Drupal\at_theming_study\Breadcrumb\BreadCrumbProcess
   */
  public static function startUp() {
    if (self::$startUp_storage === NULL) {
      self::$startUp_storage = new BreadCrumbProcess;
    }
    return self::$startUp_storage;
  }

  /**
   * Define support plugin
   * 
   * @param type $plugin_name
   * @return type
   */
  private function get_plugin($plugin_name) {
    $name_space = __NAMESPACE__;
    $plugins = array(
      'entity' => 'entity',
      'pages' => 'pages',
    );
    return isset($plugins[$plugin_name]) ? $name_space . '\\' . $plugins[$plugin_name] : FALSE;
  }

  /**
   * Load a plugin
   * 
   * @param type $plugin_name
   * @param array $args
   */
  public function breadcrumb($plugin_name, array $args = array()) {
    $plugin = $this->get_plugin($plugin_name);
    if ($plugin !== FALSE && class_exists($plugin)) {
      $this->plugin_obj_store = new $plugin($args);
    }
  }

  public function get_plugin_obj_store() {
    return $this->plugin_obj_store;
  }

}
