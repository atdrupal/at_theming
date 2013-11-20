<?php
namespace Drupal\at_theming\EntityTemplate;

class Config {
  public $entity_type;
  public $bundle;
  public $view_mode;

  public function __construct($entity_type, $bundle, $view_mode) {
    $this->entity_type = $entity_type;
    $this->bundle = $bundle;
    $this->view_mode = $view_mode;
  }

  /**
   * Get supported modules which have configuration for entity-templates
   */
  public function getModules() {
    static $modules = array();
    if (!$modules) {
      foreach (at_modules('at_theming') as $module) {
        $file = DRUPAL_ROOT . '/' . drupal_get_path('module', $module) . '/config/entity_template.yml';
        if (file_exists($file)) {
          $modules[] = $module;
        }
      }
    }
    return $modules;
  }

  public function get() {
    $that = $this;
    $options['cache_id'] = "at_theming:entity_template:{$this->entity_type}:{$this->bundle}:{$this->view_mode}";
    $options['reset'] = TRUE;
    return at_cache($options, function() use ($that) {
      foreach ($that->getModules() as $module) {
        try {
          if ($config = $that->_get(at_config($module, 'entity_template')->get('entity_templates'))) {
            return $config;
          }
        }
        catch (\Exception $e) {}
      }
    });
  }

  /**
   * Get value from in nested array: %data.%entity_type.%bundle.%view_mode
   */
  public function _get($data) {
    if (!isset($data[$this->entity_type])) return;

    $data = $data[$this->entity_type];

    if (isset($data[$this->bundle]))    $data = $data[$this->bundle];
    elseif (isset($data['all']))        $data = $data['all'];
    else                                return;

    if (isset($data[$this->view_mode])) $data = $data[$this->view_mode];
    elseif (isset($data['all']))        $data = $data['all'];
    else                                return;

    return $data;
  }
}
