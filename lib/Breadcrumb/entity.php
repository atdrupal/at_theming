<?php

namespace Drupal\at_theming\Breadcrumb;

use Drupal\at_theming\Breadcrumb\BreadcrumbBase;

class entity extends BreadcrumbBase {

  /**
   * 
   * @param array $args()
   */
  function __construct(array $args) {
    if (isset($args['build'], $args['entity_type'])) {
      $this->entity_breadcrumb($args['build'], $args['entity_type']);
      return TRUE;
    }
    return FALSE;
  }

  /**
   * The entitis be support
   * 
   * @return string
   */
  private function entity_support($entity_type = NULL) {
    $entity_support = array(
      'node' => '#node',
      'taxonomy_term' => '#term',
      'user' => '#account',
    );
    if (!is_null($entity_type)) {
      return isset($entity_support[$entity_type]) ? $entity_support[$entity_type] : FALSE;
    }
    else {
      return $entity_support;
    }
  }

  /**
   * Process breadcrum for entity
   * 
   * @param type $build
   * @param type $entity_type
   */
  private function entity_breadcrumb($build, $entity_type) {
    //Check support entity
    if (!$this->entity_support($entity_type)) {
      return FALSE;
    }
    $entity_object = $build[$this->entity_support($entity_type)];
    $this->entity_data = $entity_object;
    $this->entity_data->entity_type = $entity_type;
    if ($this->entity_support($entity_type) !== FALSE && !is_null($entity_object) && current_path() === $this->entity_get_uri($entity_type)) {
      // Set the token use on session
      $this->set_entity_default_token();
      $breadcrumbs_config = $this->read_module_breadcrumb_Config();
      foreach ($breadcrumbs_config as $config) {
        if (isset($config['entity'][$entity_type][$build['#bundle']])) {
          $this->setBreadcrumb($config['entity'][$entity_type][$build['#bundle']]);
        }
      }
    }
  }

  /**
   * Get uri of current entity
   * 
   * @param type $entity_type
   * @return type
   */
  private function entity_get_uri($entity_type) {
    $entity_info = entity_get_info($entity_type);
    $uri = $entity_info['uri callback']($this->entity_data);
    return $uri['path'];
  }

  /**
   * Set default token
   */
  private function set_entity_default_token() {
    $entity = $this->entity_data;
    $default_tokens = array();
    // Set default token for node entity
    if ($entity->entity_type === 'node') {
      $default_tokens = array(
        'node_id' => $entity->nid,
        'node_title' => $entity->title,
      );
    }
    // For taxonomy term
    if ($entity->entity_type === 'taxonomy_term') {
      $default_tokens = array(
        'term_id' => $entity->tid,
        'term_name' => $entity->name
      );
    }
    $default_tokens['current_uri'] = $this->entity_get_uri($entity->entity_type);
    foreach ($default_tokens as $n_token_key => $n_token_value) {
      $this->set_token($n_token_key, $n_token_value);
    }
  }

  /**
   * 
   * @return the data of current entity
   */
  public function get_current_entity_data() {
    return $this->entity_data;
  }

}