<?php

namespace Tests;

use Herald\GreenPass\Utils\FileUtils;
use Masterix21\GreenPass\Exceptions\InvalidQrcode;
use robertogallea\LaravelGreenPass\Exceptions\InvalidGreenPassException;
use robertogallea\LaravelGreenPass\Services\GreenPassDecoder;

class DecoderServiceTest extends TestCase
{

    /** @test */
    public function test_valid_but_revoked()
    {
        $decoder = new GreenPassDecoder();

        $greenPass = $decoder->decode($this->qrcode_certificate_valid_but_revoked);

        $this->assertNotEmpty($greenPass->person);
        $this->assertEquals('NOT_VALID', $greenPass->certificateStatus);
    }

    /** @test */
    public function test_parses_code_without_hc1()
    {
        $decoder = new GreenPassDecoder();

        $greenPass = $decoder->decode($this->qrcode_without_hc1);

        $this->assertNotEmpty($greenPass->person);
        $this->assertEquals('NOT_VALID', $greenPass->certificateStatus);
    }

    /** @test */
    public function test_new_zealand()
    {
        $decoder = new GreenPassDecoder();

        $this->expectException(InvalidGreenPassException::class);
        $greenPass = $decoder->decode($this->qrcode_new_zeland_gp);
    }

    /** @test */
    public function test_parses_kid_green_pass()
    {
        $decoder = new GreenPassDecoder();

        $greenPass = $decoder->decode($this->qrcode_de_test_kid_invalid);
        $this->assertEmpty($greenPass->person);
        $this->assertEquals('NOT_EU_DCC', $greenPass->certificateStatus);
    }

    /** @test */
    public function it_decodes_the_qrcode_to_greenpass(): void
    {
        $decoder = new GreenPassDecoder();

        $greenPass = $decoder->decodeFile(__DIR__ . '/codes/example_qr.png');

        $this->assertNotEmpty($greenPass->person);
    }
}