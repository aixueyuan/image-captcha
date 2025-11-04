<?php

namespace Aixueyuan\ImageCaptcha\Provider;

use Illuminate\Support\ServiceProvider;

class ImageCaptchaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // 占位注册，无实际逻辑
    }

    public function boot(): void
    {
        // 占位启动，确保启用扩展时不会报错
    }
}
