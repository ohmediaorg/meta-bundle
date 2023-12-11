<?php

namespace OHMedia\MetaBundle\Form\Type;

use OHMedia\FileBundle\Form\Type\FileEntityType;
use OHMedia\MetaBundle\Entity\Meta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MetaEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $meta = isset($options['data']) ? $options['data'] : null;

        $builder
            ->add('title', null, [
                'required' => $options['required'],
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('image', FileEntityType::class, [
                'data' => $meta ? $meta->getImage() : null,
                'required' => false,
                'image' => true,
                'show_alt' => false,
            ])
        ;

        if ($options['show_append_base_title']) {
            $builder->add('append_base_title', CheckboxType::class, [
                'required' => false,
                'data' => $meta ? $meta->getAppendBaseTitle() : true,
            ]);
        } else {
            $builder->add('append_base_title', HiddenType::class, [
                'data' => true,
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meta::class,
            'show_append_base_title' => true,
        ]);
    }
}
