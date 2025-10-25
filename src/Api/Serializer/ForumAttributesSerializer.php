<?php

namespace aixueyuan\ImageCaptcha\Api\Serializer;

use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Settings\SettingsRepositoryInterface;

class ForumAttributesSerializer
{
    protected $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke(ForumSerializer $serializer, $model, array $attributes): array
    {
        return [
            'imageCaptchaEnabled' => (bool)$this->settings->get('image-captcha.enabled', true)
        ];
    }
}