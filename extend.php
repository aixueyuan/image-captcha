<?php

namespace aixueyuan\ImageCaptcha;

use Flarum\Extend;
use Flarum\Api\Serializer\ForumSerializer;
use aixueyuan\ImageCaptcha\Api\Controller\GenerateImageCaptchaController;
use aixueyuan\ImageCaptcha\Api\Middleware\CheckImageCaptcha;
use aixueyuan\ImageCaptcha\Api\Serializer\ForumAttributesSerializer;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Routes('api'))
        ->get('/captcha/generate', 'captcha.generate', GenerateImageCaptchaController::class),

    (new Extend\Middleware('api'))
        ->add(CheckImageCaptcha::class),

    (new Extend\Settings())
        ->default('image-captcha.enabled', true),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attributes(ForumAttributesSerializer::class),
];