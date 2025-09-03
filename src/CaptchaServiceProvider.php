<?php

namespace Cocomelon\Captcha;

use Illuminate\Support\ServiceProvider;

class CaptchaServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publish assets (images)
        $this->publishes([
            __DIR__ . '/../resources/images' => public_path('vendor/captcha'),
        ], 'captcha-assets');
    }

    public function register()
    {
        //
    }
}
