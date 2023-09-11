<?php

namespace OHMedia\MetaBundle\Settings;

use OHMedia\FileBundle\Repository\FileRepository;
use OHMedia\SettingsBundle\Service\Settings;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;

class MetaSettings
{
    public const SETTING_BASE_TITLE = 'oh_media_meta_base_title';
    public const SETTING_DESCRIPTION = 'oh_media_meta_description';
    public const SETTING_IMAGE = 'oh_media_meta_image';

    private $fileRepository;
    private $settings;

    public function __construct(FileRepository $fileRepository, Settings $settings)
    {
        $this->fileRepository = $fileRepository;
        $this->settings = $settings;
    }

    public function getBaseTitle()
    {
        return $this->settings->get(self::SETTING_BASE_TITLE);
    }

    public function getDescription()
    {
        return $this->settings->get(self::SETTING_DESCRIPTION);
    }

    public function getImage()
    {
        return $this->settings->get(self::SETTING_IMAGE);
    }

    public function addDefaultFields(FormBuilderInterface $formBuilder): void
    {
        $formBuilder
            ->add(self::SETTING_BASE_TITLE, TextType::class, [
                'label' => 'Base Title',
                'data' => $this->getBaseTitle(),
            ])
            ->add(self::SETTING_DESCRIPTION, TextareaType::class, [
                'label' => 'Default Description',
                'data' => $this->getDescription(),
            ])
            ->add(self::SETTING_IMAGE, FileEntityType::class, [
                'label' => 'Default Image',
                'data' => $this->getImage(),
            ])
        ;
    }

    public function saveDefaultFields(FormInterface $form)
    {
        $formData = $form->getData();

        $this->settings->set(self::SETTING_BASE_TITLE, $formData[self::SETTING_BASE_TITLE]);
        $this->settings->set(self::SETTING_DESCRIPTION, $formData[self::SETTING_DESCRIPTION]);

        $image = $formData[self::SETTING_IMAGE];

        $this->fileRepository->save($image, true);

        $this->settings->set(self::SETTING_IMAGE, $image);
    }
}
