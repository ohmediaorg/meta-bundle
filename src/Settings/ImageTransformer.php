<?php

namespace JstnThms\MetaBundle\Settings;

use Doctrine\ORM\EntityManagerInterface;
use JstnThms\FileBundle\Entity\Image;
use JstnThms\SettingsBundle\Settings\SettingsTransformerInterface;

class ImageTransformer implements SettingsTransformerInterface
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    public function getId(): string
    {
        return 'jstnthms_meta_image';
    }
    
    public function transform($value): ?string
    {
        if ($value instanceof Image) {
            $this->em->persist($value);
            $this->em->flush();
            
            return (string) $value->getId();
        }
        
        return null;
    }
    
    public function reverseTransform(?string $value)
    {
        return $value
            ? $this->em->getRepository(Image::class)->find($value)
            : null;
    }
}
