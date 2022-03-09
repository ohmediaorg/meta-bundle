Overview
========

This bundle leverages `JstnThmsSettingsBundle` to offer meta tag management.

Installation
------------

First, make sure `JstnThmsFileBundle` and `JstnThmsSettingsBundle` are installed.

Enable the bundle in `config/bundles.php`:

```php
return [
    // ...
    JstnThms\MetaBundle\MetaBundle() => ['all' => true],
];
```

Usage
-----

Create the form fields to manage the settings:

```php
<?php

namespace App\Form;

use JstnThms\FileBundle\Form\Type\ImageEntityType;
use JstnThms\SettingsBundle\Settings\Settings;
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
            ->add('jstnthms_meta_title', TextType::class, [
                'label' => 'Meta Title',
                'data' => $this->settings->get('jstnthms_meta_title')
            ])
            ->add('jstnthms_meta_description', TextareaType::class, [
                'label' => 'Meta Description',
                'data' => $this->settings->get('jstnthms_meta_description')
            ])
            ->add('jstnthms_meta_image', ImageEntityType::class, [
                'label' => 'Meta Image',
                'data' => $this->settings->get('jstnthms_meta_image')
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
use JstnThms\SettingsBundle\Settings\Settings;

// ...

public function updateSettings(Settings $settings)
{
    $form = $this->createForm(SettingsType::class);
    
    // ...
    
    $settings->set('jstnthms_meta_title', $form->get('jstnthms_meta_title')->getData());
    $settings->set('jstnthms_meta_description', $form->get('jstnthms_meta_description')->getData());
    $settings->set('jstnthms_meta_image', $form->get('jstnthms_meta_image')->getData());
}

```
