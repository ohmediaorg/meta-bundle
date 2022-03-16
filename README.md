# Overview

This bundle leverages `OHMediaSettingsBundle` to offer meta tag management.

## Installation

First, make sure `OHMediaFileBundle` and `OHMediaSettingsBundle` are installed.

Enable the bundle in `config/bundles.php`:

```php
return [
    // ...
    OHMedia\MetaBundle\MetaBundle() => ['all' => true],
];
```

## Settings

Create the form fields to manage the settings:

```php
<?php

namespace App\Form;

use OHMedia\FileBundle\Form\Type\ImageEntityType;
use OHMedia\SettingsBundle\Settings\Settings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SettingsType extends AbstractType
{
    private $settings;
    
    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ...
            ->add('oh_media_meta_title', TextType::class, [
                'label' => 'Meta Title',
                'data' => $this->settings->get('oh_media_meta_title')
            ])
            ->add('oh_media_meta_description', TextareaType::class, [
                'label' => 'Meta Description',
                'data' => $this->settings->get('oh_media_meta_description')
            ])
            ->add('oh_media_meta_image', ImageEntityType::class, [
                'label' => 'Meta Image',
                'data' => $this->settings->get('oh_media_meta_image')
            ])
            // ...
        ;
    }
}

```

and update them in a controller:

```php
<?php

use App\Form\SettingsType;
use OHMedia\SettingsBundle\Settings\Settings;

// ...

public function updateSettings(Settings $settings)
{
    $form = $this->createForm(SettingsType::class);
    
    // ...
    
    $settings->set('oh_media_meta_title', $form->get('oh_media_meta_title')->getData());
    $settings->set('oh_media_meta_description', $form->get('oh_media_meta_description')->getData());
    $settings->set('oh_media_meta_image', $form->get('oh_media_meta_image')->getData());
}

```

## Usage

The bundle supplies a Twig function for outputting consistent meta tag content.

You can use the defaults provided by the above settings:

```twig
{{ meta_tags() }}
```

You can provide overrides:

```twig
{{ meta_tags('Products', 'We have lots of products ranging from...') }}
```

The title is not fully overridden unless the fourth parameter is `false`.

For example, let's say the `oh_media_meta_title` setting was "Company Ltd."

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
