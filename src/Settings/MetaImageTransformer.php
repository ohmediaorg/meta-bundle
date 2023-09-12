<?php

namespace OHMedia\MetaBundle\Settings;

use OHMedia\FileBundle\Repository\FileRepository;
use OHMedia\SettingsBundle\Interfaces\TransformerInterface;

class MetaImageTransformer implements TransformerInterface
{
    private $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function transform($value): ?string
    {
        return (string) $value->getId();
    }

    public function reverseTransform(?string $value)
    {
        return $value ? $this->fileRepository->find($value) : null;
    }

    public function getId(): string
    {
        return MetaSettings::SETTING_IMAGE;
    }
}
