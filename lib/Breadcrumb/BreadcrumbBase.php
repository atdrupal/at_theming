<?php

namespace Drupal\at_theming\Breadcrumb;

abstract class BreadcrumbBase {

  /**
   * Config id
   * @var string 
   */
  private $breadcrumb_config_id = 'breadcrumbs';

  /**
   * Storage the token
   * 
   * @var type 
   */
  private $token_storage = array();

  /**
   * A object current entity
   * 
   * @var type 
   */
  protected $entity_data = FALSE;

  /*
   * Set true if want to automatically add a link to the homepage
   * Home > ...
   */
  private $prefix_home = TRUE;

  /**
   * Provide tags for cache
   */
  private $cache_tags = array();

  /**
   * Token use in this module system
   */
  protected function build_token() {
    // Current title
    $this->set_token('current_title', drupal_get_title());
    // Allows programmers can intervene in token of breadcrumb with hook_at_theming_breadcrumb_token_alter(&$token).
    if (sizeof(module_implements('at_theming_breadcrumb_token_alter')) > 0) {
      drupal_alter('at_theming_breadcrumb_token', $this->token_store);
    }
  }

  /**
   * Replace tokens use in link and title
   * 
   * @param type $string
   * @param array $token
   * @return type
   */
  protected function replace_token($string) {
    return count($this->token_store) > 0 ? strtr($string, $this->token_store) : $string;
  }

  /**
   * Define token to use
   * 
   * @param type $key
   * @param type $value
   */
  protected function set_token($key, $value) {
    $this->token_store['@' . $key] = $value;
  }

  public function get_token() {
    return $token_storage;
  }

  /**
   * Allow the plugin alter cache tags
   */
  public function setCacheTags(array $cache_tags) {
    $this->cache_tags = $cache_tags;
  }

  private function getCacheTags() {
    return $this->cache_tags;
  }

  /**
   * Read breadcrumb config of the module
   */
  protected function read_module_breadcrumb_Config() {
    $breadcrumb_config_id = $this->breadcrumb_config_id;
    $module_use_breadcrumbs = $this->get_module_have_using_breadcrumb();
    return at_cache(array(
      'ttl' => '+ 1day', // live 1 day
      'cache_id' => 'at_theming:BreadcrumbConfig',
      'tags' => array_merge(array('breadcrumbConfig'), $this->getCacheTags()),
      ), function() use ($breadcrumb_config_id, $module_use_breadcrumbs) {
        $config = array();
        foreach ($module_use_breadcrumbs as $module_use_breadcrumb) {
          if (file_exists(drupal_get_path('module', $module_use_breadcrumb) . '/config/' . $breadcrumb_config_id . '.yml')) {
            $config[$module_use_breadcrumb] = at_config($module_use_breadcrumb, $breadcrumb_config_id)->getAll();
          }
        }
        return $config;
      });
  }

  /**
   * Retrieve a configuration from any module
   * 
   * @staticvar null $config
   * @param type $module_name
   * @return type
   */
  protected function get_config_by_module_name($module_name) {
    static $config = NULL;
    if (is_null($config)) {
      $config = $this->read_module_breadcrumb_Config();
    }
    return isset($config[$module_name]) ? $config[$module_name] : FALSE;
  }

  /**
   * Get the module dependency at theming
   * @return type
   */
  protected function get_module_have_using_breadcrumb() {
    $breadcrumb_config_id = $this->breadcrumb_config_id;
    return at_cache(array(
      'ttl' => '+ 1day', // live 1 day
      'cache_id' => 'at_theming:BreadcrumbUsedModule',
      'tags' => array('breadcrumbConfig'),
      ), function() use ($breadcrumb_config_id) {
        $dependency_modules = at_modules('at_theming');
        $module_use = array();
        foreach ($dependency_modules as $module) {
          if (file_exists(drupal_get_path('module', $module) . '/config/' . $breadcrumb_config_id . '.yml')) {
            $module_use[] = $module;
          }
        }
        return $module_use;
      });
  }

  /**
   * Set display breadcrumb use drupal_set_breadcrumb() function
   * @param array $breadcrumbs
   */
  public function setBreadcrumb(array $breadcrumbs) {
    $breadcrumb_render = array();
    if ($this->prefix_home) {
      $breadcrumb_render['home'] = l(t('Home'), '<front>');
    }
    // Buil the token to use
    $this->build_token();
    foreach ($breadcrumbs as $breadcrumb) {
      $title = empty($breadcrumb[0]) ? FALSE : $this->replace_token($breadcrumb[0]);
      $link = empty($breadcrumb[1]) ? FALSE : $this->replace_token($breadcrumb[1]);
      if ($title) {
        if ($link && $link != '<none>') {
          $breadcrumb_render[] = l($title, $link);
        }
        else {
          $breadcrumb_render[] = $title;
        }
      }
    }
    // Set drupal breadcrumb
    if (count($breadcrumb_render) > 0) {
      drupal_set_breadcrumb($breadcrumb_render);
    }
  }

}