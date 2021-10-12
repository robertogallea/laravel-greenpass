<?php

namespace Tests\Unit;

use robertogallea\LaravelGrenPass\Facades\GreenPass;
use Tests\TestCase;

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