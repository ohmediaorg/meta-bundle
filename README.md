# Overview

The bundle supplies a Twig function for outputting consistent meta tag content.

## Installation

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
{{ meta_tags() }}
```

You can provide overrides:

```twig
{{ meta_tags('Products', 'We have lots of products ranging from...') }}
```

The title is not fully overridden unless the fourth parameter is `false`.

For example, let's say the `oh_media_meta.title` config was "Company Ltd."

If you did

```twig
{{ meta_tags('Products') }}
```

you would get

```html
<title>Products | Company Ltd.</title>
```

If you did

```twig
{{ meta_tags('Products', null, null, false) }}
```

you would get

```html
<title>Products</title>
```
