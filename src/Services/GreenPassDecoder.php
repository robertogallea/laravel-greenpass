<?php

namespace robertogallea\LaravelGreenPass\Services;

use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Libern\QRCodeReader\QRCodeReader;
use Masterix21\GreenPass\Services\Decoder;
use robertogallea\LaravelGreenPass\Exceptions\InvalidGreenPassCode;

class GreenPassDecoder
{
    private Decoder $decoder;

    public function __construct()
    {
        $this->decoder = new Decoder();
    }

    public function decode(string $code)
    {
        return $this->decoder->qrcode($code);
    }

    public function decodeFile($file)
    {
        $QRCodeReader = new QRCodeReader();
        $qrcode_text = $QRCodeReader->decode($file);

        return $this->decoder->qrcode($qrcode_text);
    }
}