<?php

namespace Drupal\at_theming;

class Twig {
  public static function getTwig() {
    static $twig;
    
    if (!$twig) {
      require_once DRUPAL_ROOT . '/sites/all/libraries/twig/Autoloader.php';
      Twig_Autoloader::register();
      $twig = new Twig_Environment(new \Twig_Loader_Filesystem(DRUPAL_ROOT));
    }

    return $twig;
  }

  public static function render($template_file, $variables) {
    $twig = self::getTwig();
    $twig->render($template_file, $variables);
  }
}
