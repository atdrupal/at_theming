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
