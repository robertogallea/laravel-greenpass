<?php

namespace robertogallea\LaravelGreenPass\Validators;

use robertogallea\LaravelGreenPass\Exceptions\InvalidGreenPassException;
use robertogallea\LaravelGreenPass\Services\GreenPassDecoder;

class GreenPassValidator
{
    protected GreenPassDecoder $decoder;

    public function __construct(GreenPassDecoder $decoder)
    {
        $this->decoder = $decoder;
    }

    public function validate($attribute, $value, $parameters, $validator)
    {
        try {
            $result = $this->decoder->decode($value);

            if (in_array('valid', $parameters) && ($result->certificateStatus === 'NOT_VALID')) {
                return false;
            }

            return true;

        } catch (InvalidGreenPassException $exception) {

            $error_msg = str_replace([':attribute'], [$attribute], trans('validation.greenpass.invalid-code'));


            $validator->addReplacer('greenpass', function ($message, $attribute, $rule, $parameters, $validator) use ($error_msg) {
                return str_replace([':attribute'], [$validator->getDisplayableAttribute($attribute)], str_replace('green pass', ':attribute', $error_msg));
            });

            return false;
        }
    }
}