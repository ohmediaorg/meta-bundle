<?php

namespace OHMedia\MetaBundle\Twig;

use OHMedia\FileBundle\Entity\Image;
use OHMedia\SettingsBundle\Service\Settings;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MetaExtension extends AbstractExtension
{
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('oh_media_meta', [$this, 'getMeta'], [
                'is_safe' => ['html'],
                'needs_environment' => true
            ])
        ];
    }

    public function getMeta(
        Environment $env,
        ?string $title = null,
        ?string $description = null,
        ?Image $image = null,
        bool $appendBaseTitle = true
    )
    {
        $baseTitle = $this->settings->get('oh_media_meta_title');

        $meta = [
            'title' => $title ?: $baseTitle,
            'description' => $description ?: $this->settings->get('oh_media_meta_description'),
            'image' => $image ?: $this->settings->get('oh_media_meta_image')
        ];

        if ($title && $appendBaseTitle && $baseTitle) {
            $meta['title'] = sprintf(
                '%s | %s',
                $title,
                $baseTitle
            );
        }

        return $env->render('@OHMediaMeta/meta.html.twig', [
            'meta' => $meta
        ]);
    }
}
