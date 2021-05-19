<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @covers \App\Http\Controllers\Api\PlanetController */
class PlanetControllerTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_access_his_hero_planets() {
        /** given */
        $user = User::factory()->create();

        /** when */
        $response = $this->actingAs( $user, 'api' )->getJSON( '/api/planets' );

        /** expect */
        $response->assertStatus( 200 );
        $response->assertJsonStructure( [
            'planets' => [
                '*' => [
                    'name',
                    'diameter',
                    'population',
                    'created',
                    'edited'
                ]
            ]
        ] );
    }

    /** @test */
    public function unauthenticated_user_cannot_access_planets() {
        /** when */
        $response = $this->getJSON( '/api/planets' );

        /** expect */
        $response->assertStatus( 401 );
        $response->assertJsonFragment( [
            'message' => 'You\'re unauthenticated because of wrong or not provided api token. Please make sure that your token is correct or sign in again to get new one.'
        ] );
    }

    /** @test */
    public function authenticated_user_can_access_his_hero_planet_by_id() {
        /** given */
        $user = User::factory()->create( [ 'hero_id' => 1 ] );

        /** when */
        $response = $this->actingAs( $user, 'api' )->getJSON( '/api/planets/1' );

        /** expect */
        $response->assertStatus( 200 );
        $response->assertJsonFragment( [
            'name' => 'Tatooine',
            'diameter' => '10465',
            'population' => '200000',
            'created' => '2014-12-09T13:50:49.641000Z',
        ] );
    }

    /** @test */
    public function authenticated_user_cannot_access_other_planet_by_id() {
        /** given */
        $user = User::factory()->create( [ 'hero_id' => 1 ] );

        /** when */
        $response = $this->actingAs( $user, 'api' )->getJSON( '/api/planets/5' );

        /** expect */
        $response->assertStatus( 401 );
        $response->assertJsonFragment( [
            'message' => 'Unfortunately! This planet isn\'t correlated with your hero.'
        ] );
    }
}
