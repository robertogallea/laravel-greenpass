<?php

namespace Tests;

use robertogallea\LaravelGreenPass\Facades\GreenPass;

class GreenPassFacadeTest extends TestCase
{
    /** @test */
    public function it_can_use_facade()
    {
        foreach ($this->greenPasses as $types) {
            foreach ($types as $greenPass) {
                $greenPass = \GreenPass::decode($greenPass);

                $this->assertNotEmpty($greenPass->holder->surname);
            }
        }
    }

    protected function getPackageAliases($app)
    {
        return [
            'GreenPass' => GreenPass::class,
        ];
    }


}