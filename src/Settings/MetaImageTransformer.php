<?php

namespace OHMedia\MetaBundle\Settings;

use OHMedia\FileBundle\Repository\ImageRepository;
use OHMedia\SettingsBundle\Interfaces\TransformerInterface;

class MetaImageTransformer implements TransformerInterface
{
    private $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }

    public function transform($value): ?string
    {
        return (string) $value->getId();
    }

    public function reverseTransform(?string $value)
    {
        return $value ? $this->imageRepository->find($value) : null;
    }

    public function getId(): string
    {
        return MetaSettings::SETTING_IMAGE;
    }
}
