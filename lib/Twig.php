<?php

namespace Drupal\at_theming;

class Twig {
  public static function getEnvironment() {
    static $twig;

    if (!$twig) {
      require_once DRUPAL_ROOT . '/sites/all/libraries/twig/lib/Twig/Autoloader.php';
      \Twig_Autoloader::register();

      $loader = new \Twig_Loader_Filesystem(DRUPAL_ROOT);
      // Add @module shortcuts
      foreach (at_modules('at_theming') as $module_name) {
        $dir = DRUPAL_ROOT . '/' . drupal_get_path('module', $module_name) . '/templates';
        if (is_dir($dir)) {
          $loader->addPath($dir, $module_name);
        }
      }

      $twig = new \Twig_Environment($loader, self::getOptions());

      // Add Drupal filters
      if (module_exists('views')) {
        $twig->addFilter(new \Twig_SimpleFilter('drupalView', 'views_embed_view'));
      }
    }

    return $twig;
  }

  protected static function getOptions() {
    $options['debug'] = at_debug();
    $options['auto_reload'] = at_debug();
    $options['autoescape'] = FALSE;
    $options['cache'] = variable_get('file_temporary_path', FALSE);
    return $options;
  }

  public static function render($template_file, $variables) {
    $twig = self::getEnvironment();
    return $twig->render($template_file, $variables);
  }
}
