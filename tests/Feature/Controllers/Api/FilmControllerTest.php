<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/** @covers \App\Http\Controllers\Api\FilmController */
class FilmControllerTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_access_his_hero_films() {
        /** given */
        $user = User::factory()->create();

        /** when */
        $response = $this->actingAs( $user, 'api' )->getJSON( '/api/films' );

        /** expect */
        $response->assertStatus( 200 );
        $response->assertJsonStructure( [
            'films' => [
                '*' => [
                    'title',
                    'director',
                    'producer',
                    'created',
                    'edited'
                ]
            ]
        ] );
    }

    /** @test */
    public function unauthenticated_user_cannot_access_films() {
        /** when */
        $response = $this->getJSON( '/api/films' );

        /** expect */
        $response->assertStatus( 401 );
        $response->assertJsonFragment( [
            'message' => 'You\'re unauthenticated because of wrong or not provided api token. Please make sure that your token is correct or sign in again to get new one.'
        ] );
    }

    /**
     * @test
     * @covers \App\Actions\CheckResourceAccess
     */
    public function authenticated_user_can_access_his_hero_film_by_id() {
        /** given */
        $user = User::factory()->create( [ 'hero_id' => 1 ] );

        /** when */
        $response = $this->actingAs( $user, 'api' )->getJSON( '/api/films/1' );

        /** expect */
        $response->assertStatus( 200 );
        $response->assertJsonFragment( [
            'title' => 'A New Hope',
            'director' => 'George Lucas',
            'producer' => 'Gary Kurtz, Rick McCallum',
            'created' => '2014-12-10T14:23:31.880000Z',
        ] );
    }

    /**
     * @test
     * @covers \App\Actions\CheckResourceAccess
     */
    public function authenticated_user_cannot_access_other_hero_film_by_id() {
        /** given */
        $user = User::factory()->create( [ 'hero_id' => 1 ] );

        /** when */
        $response = $this->actingAs( $user, 'api' )->getJSON( '/api/films/5' );

        /** expect */
        $response->assertStatus( 401 );
        $response->assertJsonFragment( [
            'message' => 'Unfortunately! This film isn\'t correlated with your hero.'
        ] );
    }

    /** @test */
    public function films_pulled_from_sw_api_are_cached() {
        Cache::spy();

        /** given */
        $user = User::factory()->create( [ 'hero_id' => 1 ] );

        /** when */
        $this->actingAs( $user, 'api' )->getJSON( '/api/films' );
        $this->actingAs( $user, 'api' )->getJSON( '/api/films/1' );

        /** expect */
        Cache::shouldHaveReceived( 'remember' )
            ->with( 'api_person_1', \Mockery::any(), \Mockery::any() )
            ->once();

        Cache::shouldHaveReceived( 'remember' )
            ->with( 'api_film_1', \Mockery::any(), \Mockery::any() )
            ->once();
    }
}
