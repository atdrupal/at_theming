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

- {{ 'view_name' | drupalView }} — if views.module is enabled
  - %theme/templates/views/%view_name[.%display_id].html.twig will be used if it's available
- {{ node | kpr }} — if devel.module is enabled
- {{ 'system:powered-by' | drupalBlock }}
- {{ 'boxes:box-delta' | drupalBlock }}
- {{ render_array | render }}
- {{ 'node/1' | url }}
- {{ string | _filter_autop}}
- {{ translate_me | t }}

#### Functions

- {% for i in element_children(render_array) %} {{ render_array[i] | render }}  {% endfor %}

Planned features
==========

- l, hide, format_date, filter_xss_admin, …
