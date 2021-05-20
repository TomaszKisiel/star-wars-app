<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WebControllerTest extends TestCase {

    /** @test */
    public function show_swagger_api_documentation() {
        $response = $this->get( '/' );

        $response->assertStatus( 200 );
        $response->assertViewIs('l5-swagger::index');
    }

}
