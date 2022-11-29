<?php

namespace OHMedia\MetaBundle\Form\Type;

use OHMedia\FileBundle\Form\Type\ImageEntityType;
use OHMedia\MetaBundle\Entity\Meta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MetaEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $meta = isset($options['data']) ? $options['data'] : null;

        $builder
            ->add('title', null, [
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('image', ImageEntityType::class, [
                'data' => $meta ? $meta->getImage() : null,
            ])
            ->add('append_base_title', CheckboxType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Meta::class,
        ]);
    }
}
