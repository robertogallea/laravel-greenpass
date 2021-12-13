<?php

namespace robertogallea\LaravelGreenPass\Exceptions;

class InvalidGreenPassException extends \Exception
{
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}