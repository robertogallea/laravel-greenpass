<?php

namespace Tests;

use robertogallea\LaravelGreenPass\Facades\GreenPass;

class GreenPassFacadeTest extends TestCase
{
    /** @test */
    public function it_can_use_facade()
    {

        $greenPass = \GreenPass::decode($this->qrcode_certificate_valid_but_revoked);

        $this->assertNotEmpty($greenPass->person);

    }

    protected function getPackageAliases($app)
    {
        return [
            'GreenPass' => GreenPass::class,
        ];
    }


}