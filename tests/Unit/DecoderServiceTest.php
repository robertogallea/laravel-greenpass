<?php

namespace Tests\Unit;

use Masterix21\GreenPass\Exceptions\InvalidQrcode;
use Masterix21\GreenPass\GreenPass;
use robertogallea\LaravelGrenPass\Exceptions\InvalidGreenPassCode;
use robertogallea\LaravelGrenPass\Services\GreenPassDecoder;

class DecoderServiceTest extends \Tests\TestCase
{

    /** @test */
    public function it_throws_invalid_code()
    {
        $decoder = new GreenPassDecoder();

        $this->expectException(InvalidQrcode::class);

        $decoder->decode('fake-code');
    }

    /** @test */
    public function it_decodes_the_code_to_greenpass(): void
    {
        $decoder = new GreenPassDecoder();

        foreach ($this->greenPasses as $types) {
            foreach ($types as $greenPass) {
                $greenPass = $decoder->decode($greenPass);

                $this->assertNotEmpty($greenPass->holder->surname);
            }
        }
    }

    /** @test */
    public function it_decodes_the_qrcode_to_greenpass(): void
    {
        $decoder = new GreenPassDecoder();

        $greenPass = $decoder->decodeFile('tests/codes/example_qr.png');

        $this->assertNotEmpty($greenPass->holder->surname);
    }
}