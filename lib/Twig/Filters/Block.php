<?php

namespace Drupal\at_theming\Twig\Filters;

class Block {
  public static function render($string) {
    $string = explode(':', $string);
    if (2 !== count($string)) {
      return '<!-- Wrong param -->';
    }

    list($module, $delta) = $string;
    if (!module_exists($module)) {
      return '<!-- Invalid module -->';
    }

    if (!$block = block_load($module, $delta)) {
      return '<!-- Block not found -->';
    }

    if ($block = block_load($module, $delta)) {
      $output = _block_render_blocks(array($block));
      $output = _block_get_renderable_array($output);
      return drupal_render($output);
    }
  }
}
