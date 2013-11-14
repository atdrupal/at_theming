<?php

namespace Drupal\at_theming\Twig\Filters;

class Entity {

  /**
   * Callback for drupalEntity filter.
   *
   * @param  string  $string       %entity_type:%id:%view_mode
   */
  public static function render($string) {
    $string = explode(':', $string);
    if (2 !== count($string)) {
      return '<!-- Wrong param -->';
    }

    list($entity_type, $entity_id, $view_mode) = $string;
    $entity = entity_load($entity_type, array($entity_id));
    $view_mode = !empty($view_mode) ? $view_mode : 'full';

    if (!$entity) {
      return '<!-- Entity node found -->';
    }

    $entity = reset($entity);

    return drupal_render(self::entityView($entity_type, array($entity), $view_mode));
  }

  /**
   * Render entity view
   */
  private static function entityView($entity_type, $entities, $view_mode = 'full', $langcode = NULL, $page = NULL) {
    return entity_view($entity_type, $entities, $view_mode, $langcode, $page);
  }

}
