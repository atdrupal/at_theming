at_theming
==========

[![Build Status](https://secure.travis-ci.org/andytruong/at_theming.png?branch=7.x-1.x)](http://travis-ci.org/andytruong/at_theming)

Provide some helper method for theming.

Check the tests for more details.

Install
==========

Download Twig library to /sites/all/libraries/twig — where we can find
/sites/all/libraries/twig/lib/Twig/Autoloader.php

Twig template is supported
==========

````php
  $template_file = drupal_get_path('module', 'atest_theming') . '/templates/hello.twig';
  echo at_theming_render_template($template_file, array('name' => 'Andy Truong'));
````

#### Filters for Drupal:

- {{ 'view_name' | drupalView }}
- {{ 'system:powered-by' | drupalBlock }}

Planned features
==========

- {{ 'box-delta' | drupalBox }}
- {{ 'node/1' | url }}
- url, l, auto_p, hide, format_date, filter_xss_admin, kpr, …
