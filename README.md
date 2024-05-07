# Overview

The bundle supplies a Twig function for outputting consistent meta tag content.

# Installation

Update `composer.json` by adding this to the `repositories` array:

```json
{
    "type": "vcs",
    "url": "https://github.com/ohmediaorg/meta-bundle"
}
```

Then run `composer require ohmediaorg/meta-bundle:dev-main`.

Run `php bin/console make:migration` then run the subsequent migration.

# Usage

You can use the default settings provided by the bundle:

```twig
{{ meta_simple() }}
```

You can provide overrides:

```twig
{{ meta_simple('Products', 'We have lots of products ranging from...') }}
```

The third parameter is an image. This can be a string path to an image in the
`public` folder or a `File` entity from the `FileBundle`.

The title is not fully overridden unless the fourth parameter is `false`.

For example, let's say the `oh_media_meta_base_title` setting was "Company Ltd."

If you did

```twig
{{ meta_simple('Products') }}
```

you would get

```html
<title>Products | Company Ltd.</title>
```

If you did

```twig
{{ meta_simple('Products', null, null, false) }}
```

you would get

```html
<title>Products</title>
```

# Entities

There is also an entity provided in `OHMedia\MetaBundle\Entity\Meta` with a
corresponding form type `OHMedia\MetaBundle\Form\Type\MetaEntityType`. This is
so you can have custom meta information for your dynamic data.

All you need to do is make a `OneToOne` association from your custom entity
to this `Meta` entity.

In your custom entity form you can add a field like so:

```php
use OHMedia\MetaBundle\Form\Type\MetaEntityType;

// ...


$builder->add('meta', MetaEntityType::class);
```

In your templates, you can do:

```twig
{{ meta_entity(my_custom_entity.meta) }}
```
