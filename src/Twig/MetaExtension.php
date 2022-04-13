<?php

namespace OHMedia\MetaBundle\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class MetaExtension extends AbstractExtension
{
    private $meta;
    private $projectDir;
    private $separator;

    public function __construct(
        string $projectDir,
        string $title,
        string $description,
        string $image,
        string $separator
    )
    {
        $this->projectDir = $projectDir;

        $this->title = $title;
        $this->description = $description;
        $this->image = $image;

        list($this->width, $this->height) = $this->getImageSize($image);

        $this->separator = $separator;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('meta_tags', [$this, 'getMetaTags'], [
                'is_safe' => ['html'],
                'needs_environment' => true
            ]),
        ];
    }

    public function getMetaTags(
        Environment $env,
        ?string $title = null,
        ?string $description = null,
        ?string $image = null,
        bool $appendBaseTitle = true
    )
    {
        list($width, $height) = $this->getImageSize($image);

        $params = [
            'title' => $title ?: $this->title,
            'description' => $description ?: $this->description,
            'image' => $image ?: $this->image,
            'image_width' => $width ?: $this->width,
            'image_height' => $height ?: $this->height,
        ];

        if ($title && $appendBaseTitle) {
            // basically prepending $title
            $params['title'] = sprintf(
                '%s %s %s',
                $title,
                $this->separator,
                $this->title
            );
        }

        return $env->render('@OHMediaMeta/meta.html.twig', $params);
    }

    private function getImageSize(?string $image): array
    {
        $default = [null, null];

        if (!$image) {
            return $default;
        }

        $absolute = $this->projectDir . '/public' . $image;

        if (!is_file($absolute)) {
            return $default;
        }

        $size = getimagesize($absolute);

        if (!$size) {
            return $default;
        }

        return [$size[0], $size[1]];
    }
}
