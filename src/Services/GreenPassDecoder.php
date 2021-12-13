<?php

namespace robertogallea\LaravelGreenPass\Services;

use Herald\GreenPass\Utils\CertificateValidator;
use Herald\GreenPass\Validation\Covid19\ValidationScanMode;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Libern\QRCodeReader\QRCodeReader;
use Masterix21\GreenPass\Services\Decoder;
use robertogallea\LaravelGreenPass\Exceptions\InvalidGreenPassCode;
use robertogallea\LaravelGreenPass\Exceptions\InvalidGreenPassException;
use TypeError;

class GreenPassDecoder
{
    private $decoder;

    public function __construct()
    {

    }

    /**
     * @throws InvalidGreenPassException
     */
    public function decode(string $code, string $mode = ValidationScanMode::CLASSIC_DGP)
    {
        try {
            $decoder = new CertificateValidator($code, $mode);
            return $decoder->getCertificateSimple();
        } catch (TypeError $error) {
            throw new InvalidGreenPassException($error->getMessage(), $error->getCode());
        }
    }

    public function decodeFile($file, $mode = ValidationScanMode::CLASSIC_DGP)
    {
        $QRCodeReader = new QRCodeReader();
        $qrcode_text = $QRCodeReader->decode($file);

        $decoder = new CertificateValidator($qrcode_text, $mode);
        return $decoder->getCertificateSimple();
    }
}