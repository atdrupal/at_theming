<?php

namespace Drupal\at_theming\PageClassAlter;

class BodyTag {

  /**
   * Config id
   */
  private $configId = 'at_theming';

  public function __construct(&$variables, $path) {
    $this->addClass($variables, drupal_get_normal_path($path));
  }

  /**
   * Add class
   * 
   * @param type $variables
   * @param type $path
   * @return boolean
   */
  public function addClass(&$variables, $path) {
    $config = $this->getConfigValue();
    if (isset($config[$path])) {
      $variables['classes_array'] = array_merge($variables['classes_array'], $config[$path]);
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Get the module has file config
   * 
   * @return type
   */
  private function getModule() {
    $dependency_modules = at_modules('at_theming');
    $module_has_config = array();
    foreach ($dependency_modules as $dependency_module) {
      if (file_exists(drupal_get_path('module', $dependency_module) . '/config/' . $this->configId . '.yml')) {
        $module_has_config[] = $dependency_module;
      }
    }
    return $module_has_config;
  }

  /**
   * Get config value
   * 
   * @return type
   */
  private function getConfigValue() {
    return at_cache(array(
      'ttl' => '+ 1day', // live 1 day
      'cache_id' => 'at_theming:body_classes_config',
      'tags' => array_merge(array('body_classes')),
      ), array($this,'buildConfig'));
  }

  /**
   * Build config
   * 
   * @return type
   */
  public function buildConfig() {
    $modules = $this->getModule();
    $config = array();
    foreach ($modules as $module) {
      $config_by_module = at_config($module, $this->configId)->getAll();
      foreach ($config_by_module['body_classes'] as $key => $config_value) {
        $key = drupal_get_normal_path($key);
        if (isset($config[$key])) {
          $config[$key] = array_merge($config[$key], $config_value);
        }
        else {
          $config[$key] = $config_value;
        }
      }
    }
    return $config;
  }

}
