<?php

namespace Aixueyuan\ImageCaptcha;

use Flarum\Extend;

return [
    (new Extend\ServiceProvider())
        ->register(Provider\ImageCaptchaServiceProvider::class),
];
