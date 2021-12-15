<?php

namespace robertogallea\LaravelGreenPass;

use Herald\GreenPass\Utils\FileUtils;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Masterix21\GreenPass\Exceptions\InvalidQrcode;
use robertogallea\LaravelGreenPass\Exceptions\InvalidGreenPassException;
use robertogallea\LaravelGreenPass\Services\GreenPassDecoder;
use robertogallea\LaravelGreenPass\Validators\GreenPassFileValidator;
use robertogallea\LaravelGreenPass\Validators\GreenPassValidator;

class GreenPassServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'greenpass',
            function ($app) {
                return new GreenPassDecoder();
            }
        );

        $this->mergeConfigFrom($this->getPackagePath() . '/config/green-pass.php', 'green-pass');

        $this->publishes([
            $this->getPackagePath() . '/config/green-pass.php' => config_path('green-pass.php')
        ], 'config');

        FileUtils::overrideCacheFilePath(config('green-pass.certificate-storage-path'));
    }

    public function boot(GreenPassDecoder $decoder)
    {
        $this->bootValidator($decoder);
    }

    private function getPackagePath()
    {
        return __DIR__ . '/..';
    }

    public function bootValidator(GreenPassDecoder $decoder)
    {
        Validator::extend('greenpass', GreenPassValidator::class);

        Validator::extend('greenpass_file', GreenPassFileValidator::class);
    }
}