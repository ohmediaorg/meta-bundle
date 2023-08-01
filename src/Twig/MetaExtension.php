<?php

namespace OHMedia\MetaBundle\Twig;

use OHMedia\FileBundle\Entity\Image as ImageEntity;
use OHMedia\FileBundle\Service\FileManager;
use OHMedia\MetaBundle\Entity\Meta as MetaEntity;
use OHMedia\MetaBundle\Settings\MetaSettings;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MetaExtension extends AbstractExtension
{
    private $meta;
    private $projectDir;

    public function __construct(
        FileManager $fileManager,
        MetaSettings $metaSettings,
        string $projectDir
    ) {
        $this->fileManager = $fileManager;

        $this->baseTitle = $metaSettings->getBaseTitle();
        $this->description = $metaSettings->getDescription();
        $image = $metaSettings->getImage();

        $this->imageData = $this->getImageData($image);

        $this->projectDir = $projectDir;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('meta_simple', [$this, 'getMetaSimple'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
            new TwigFunction('meta_entity', [$this, 'getMetaEntity'], [
                'is_safe' => ['html'],
                'needs_environment' => true,
            ]),
        ];
    }

    public function getMetaSimple(
        Environment $env,
        string $title = null,
        string $description = null,
        $image = null,
        bool $appendBaseTitle = true
    ) {
        return $this->renderMeta($env, $title, $description, $image, $appendBaseTitle);
    }

    public function getMetaEntity(Environment $env, MetaEntity $meta)
    {
        return $this->renderMeta(
            $env,
            $meta->getTitle(),
            $meta->getDescription(),
            $meta->getImage(),
            $meta->getAppendBaseTitle()
        );
    }

    private function renderMeta(
        Environment $env,
        string $title = null,
        string $description = null,
        $image,
        bool $appendBaseTitle = true
    ) {
        $imageData = $this->getImageData($image);

        $params = [
            'title' => $title ?: $this->baseTitle,
            'description' => $description ?: $this->description,
            'image' => $imageData ?: $this->imageData,
        ];

        if ($title && $appendBaseTitle) {
            $params['title'] = sprintf(
                '%s | %s',
                $title,
                $this->baseTitle
            );
        }

        return $env->render('@OHMediaMeta/meta.html.twig', $params);
    }

    private function getImageData($image): ?array
    {
        if ($image instanceof ImageEntity) {
            return [
                'path' => $this->fileManager->getWebPath($image->getFile()),
                'width' => $image->getWidth(),
                'height' => $image->getHeight(),
            ];
        }

        if (!$image || !is_string($image)) {
            return null;
        }

        $absolute = $this->projectDir.'/public'.$image;

        if (!is_file($absolute)) {
            return null;
        }

        $size = getimagesize($absolute);

        if (!$size) {
            return null;
        }

        return [
            'path' => $image,
            'width' => $size[0],
            'height' => $size[1],
        ];
    }
}
