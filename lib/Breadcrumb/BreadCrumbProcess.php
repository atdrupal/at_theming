<?php

namespace Drupal\at_theming\Breadcrumb;

class BreadCrumbProcess {

  /**
   * Plugin be support
   * @var type 
   */
  private $plugin_obj_store = '';

  /**
   * Define support plugin
   * 
   * @param type $plugin_name
   * @return type
   */
  private function get_plugin($plugin_name) {
    $name_space = __NAMESPACE__;
    // array(plugin id => Class name)
    $plugins = array(
      'entity' => 'Entity',
      'pages' => 'Pages',
    );
    $this->plugin_obj_store = $plugins;
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
