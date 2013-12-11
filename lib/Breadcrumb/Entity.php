<?php

namespace Drupal\at_theming\Breadcrumb;

use Drupal\at_theming\Breadcrumb\BreadcrumbBase;

class Entity extends BreadcrumbBase {

  /**
   * Entity key id
   */
  private $entityIdKey;

  /**
   * 
   * @param array $args()
   */
  function __construct(array $args) {
    if (isset($args['entity'], $args['entity_type'])) {
      $this->entity_breadcrumb($args['entity'], $args['entity_type']);
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Process breadcrum for entity
   * 
   * @param type $entity
   * @param type $entity_type
   */
  private function entity_breadcrumb($entity_object, $entity_type) {
    $this->entity_data = $entity_object;
    $this->entity_data->entity_type = $entity_type;
    if (!is_null($entity_object) && current_path() === $this->entity_get_uri($entity_type)) {
      // Set the token use on session
      $this->set_entity_default_token();
      // Tags for cache
      $this->setCacheTags(
        array(
          'entity',
          $entity_type, $entity_type . ':' . $entity_object->content['#bundle'],
          $entity_type . ':' . $entity_object->{$this->entityIdKey})
      );
      $breadcrumbs_config = $this->read_module_breadcrumb_Config();
      foreach ($breadcrumbs_config as $config) {
        if (isset($config['entity'][$entity_type][$entity_object->content['#bundle']])) {
          $this->setBreadcrumb($config['entity'][$entity_type][$entity_object->content['#bundle']]);
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
    $this->entityIdKey = $entity_info['entity keys']['id'];
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
        'node_title' => $entity->title,
      );
    }
    // For taxonomy term
    if ($entity->entity_type === 'taxonomy_term') {
      $default_tokens = array(
        'term_name' => $entity->name
      );
    }
    $default_tokens[$this->entityIdKey] = $entity->{$this->entityIdKey};
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