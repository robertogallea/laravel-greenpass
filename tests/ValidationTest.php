<?php

namespace Tests;

use Illuminate\Http\UploadedFile;

class ValidationTest extends TestCase
{
    /** @test */
    public function valid_green_passes_pass_validation()
    {
        foreach ($this->greenPasses as $types) {
            foreach ($types as $greenPass) {
                $rules = [
                    'green_pass_field' => 'greenpass',
                ];

                $data = [
                    'green_pass_field' => $greenPass,
                ];

                $validator = $this->app['validator']->make($data, $rules);
                $this->assertEquals(true, $validator->passes());
            }
        }
    }

    /** @test */
    public function invalid_green_pass_does_not_pass_validation()
    {
        $rules = [
            'green_pass_field' => 'greenpass',
        ];

        $data = [
            'green_pass_field' => 'invalid-green-pass',
        ];

        $validator = $this->app['validator']->make($data, $rules);
        $this->assertEquals(false, $validator->passes());
    }

    /** @test */
    public function valid_green_pass_qr_codes_pass_validation()
    {
        $greenPassFile = new UploadedFile('./tests/codes/example_qr.png', 'example_qr.png');

        $rules = [
            'green_pass_file_field' => 'greenpass_file',
        ];

        $data = [
            'green_pass_file_field' => $greenPassFile,
        ];

        $validator = $this->app['validator']->make($data, $rules);
        $this->assertEquals(true, $validator->passes());
    }
}