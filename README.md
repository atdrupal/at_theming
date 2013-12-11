at_theming
==========

[![Build Status](https://secure.travis-ci.org/andytruong/at_theming.png?branch=7.x-2.x)](http://travis-ci.org/andytruong/at_theming?branch=7.x-2.x)

Provide some helper method for theming.

Check the tests for more details.

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

Breadcrumb builder
===========
Support create the breadcrumb for each entity and for each site based on path
````yaml
# %my_module/config/breadcrumbs.yml
entity:
  entity_type:
    bundle:
      - [Title, url]
      - ['@token_name', ''@token_name']
      - [Title 2, '<none>']
pages:
  path/path:
    - [Title, url]
    - [Title 2, '<none>']
````
Can use tokens including token provides default.
Or tokens insert in the working process. with hook_at_theming_breadcrumb_token_alter(&$token)

Page body alter class
===========
Allows programmers to easily add a class to the body tag of the page
````yaml
# %my_module/config/at_theming.yml
body_classes:
  'path/path': ['class1', 'class2', 'class3']
````
