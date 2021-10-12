<?php

namespace robertogallea\LaravelGrenPass;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Masterix21\GreenPass\Exceptions\InvalidQrcode;
use robertogallea\LaravelGrenPass\Services\GreenPassDecoder;

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
        Validator::extend('greenpass', function ($attribute, $value, $parameters, $validator) use ($decoder) {
            try {
                $decoder->decode($value);
            } catch (InvalidQrcode $exception) {

                $error_msg = str_replace([':attribute'], [$attribute], trans('validation.greenpass.invalid-code'));


                $validator->addReplacer('greenpass', function ($message, $attribute, $rule, $parameters, $validator) use ($error_msg) {
                    return str_replace([':attribute'], [$validator->getDisplayableAttribute($attribute)], str_replace('green pass', ':attribute', $error_msg));
                });

                return false;
            }

            return true;
        });

        Validator::extend('greenpass_file', function ($attribute, $value, $parameters, $validator) use ($decoder) {
            try {
                $decoder->decodeFile($value->getRealPath());
            } catch (InvalidQrcode $exception) {

                $error_msg = str_replace([':attribute'], [$attribute], trans('validation.greenpass_file.invalid-code'));


                $validator->addReplacer('greenpass_file', function ($message, $attribute, $rule, $parameters, $validator) use ($error_msg) {
                    return str_replace([':attribute'], [$validator->getDisplayableAttribute($attribute)], str_replace('green pass', ':attribute', $error_msg));
                });

                return false;
            }

            return true;
        });
    }
}