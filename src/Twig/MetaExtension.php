<?php

namespace JstnThms\MetaBundle\Twig;

use JstnThms\FileBundle\Entity\Image;
use JstnThms\SettingsBundle\Settings\Settings;
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
    
    public function getFunctions()
    {
        return [
            new TwigFunction('jstnthms_meta', [$this, 'getMeta'], [
                'is_safe' => ['html'],
                'needs_environment' => true
            ])
        ];
    }
    
    public function getMeta(Environment $env,
        ?string $title = null,
        ?string $description = null,
        ?Image $image = null
    )
    {
        $meta = [
            'title' => $this->settings->get('jstnthms_meta_title'),
            'description' => $description ?: $this->settings->get('jstnthms_meta_description'),
            'image' => $image ?: $this->settings->get('jstnthms_meta_image')
        ];
        
        if ($title) {
            $meta['title'] = sprintf('%s | %s', $title, $meta['title']);
        }
        
        return $env->render('@JstnThmsMeta/meta.html.twig', [
            'meta' => $meta
        ]);
    }
}
