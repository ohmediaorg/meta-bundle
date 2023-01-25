# Overview

The bundle supplies a Twig function for outputting consistent meta tag content.

## Installation

Make sure `ohmediaorg/file-bundle` is set up.

Enable the bundle in `config/bundles.php`:

```php
return [
    // ...
    OHMedia\MetaBundle\MetaBundle() => ['all' => true],
];
```

## Config

Create `config/packages/oh_media_meta.yaml`:

```php
oh_media_meta:
    title: ''
    description: ''
    image: '' # should be relative to the public directory
    separator: '|' # default

```

## Usage

You can use the defaults provided by the above config:

```twig
{{ meta_simple() }}
```

You can provide overrides:

```twig
{{ meta_simple('Products', 'We have lots of products ranging from...') }}
```

The third parameter is an image. This can be a string path to an image in the
`public` folder or an `Image` entity from the `FileBundle`.

The title is not fully overridden unless the fourth parameter is `false`.

For example, let's say the `oh_media_meta.title` config was "Company Ltd."

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

## Entities

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
{{ meta_entity(myCustomEntity.meta) }}
```

Note: This assumes the name of your association on your custom entity is called `meta`.
