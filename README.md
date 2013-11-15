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
- {{ 'user:1' | drupalEntity }}

#### Functions

- {% for i in element_children(render_array) %} {{ render_array[i] | render }}  {% endfor %}

#### Define custom twig filter:

Add this line to your_module.info

````
dependencies[] = at_config
dependencies[] = at_theming
````

Then, create new config file — your_module/config/twig_filters.yml

````yaml
# @see at_theming/config/twig_filters.yml for example
twig_filters:
  - [t, t]
  - [drupalView, [\Drupal\at_theming\Twig\Filters\Views, render]]
````

Entity Template
==========

This module make it a bit easier to theme the entity.

````yaml
# %my_module/config/entity_template.yml

entity_templates:
  taxonomy_term:
    product_range:
      full:
        template: @my_module/taxonomy_term/product_range.html.twig
````

Flush cache, /path/to/my_module/taxonomy_term/product_range.html.twig is not used
for rendering entity.

Planned features
==========

- l, hide, format_date, filter_xss_admin, …
