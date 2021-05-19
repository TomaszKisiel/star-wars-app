<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginControllerTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function user_can_sign_in_with_correct_credentials() {
        /** given */
        $this->prepareFakeUser();

        /** when */
        $response = $this->postJson( '/api/login', $this->getUserData() );

        /** expect */
        $response->assertSuccessful();

        $this->assertNotNull( $data = $response->json() );
        $this->assertNotNull( $data[ 'token' ] );

        $this->assertEquals( 'You have been logged in successfully. You can now access your data via the bearer API token.', $data[ 'message' ] );

        $response->assertJsonStructure( [
            'message',
            'token'
        ] );
    }

    /** @test */
    public function user_cannot_sign_in_with_invalid_credentials() {
        /** given */
        $this->prepareFakeUser();

        /** when */
        $response = $this->postJson( '/api/login', $this->getUserData( [ 'password' => 'Vertex25^' ] ) );

        /** expect */
        $response->assertStatus( 401 );
        $response->assertJsonFragment( [
            'message' => 'Unfortunately! The given credentials don\'t match any existing user.',
        ] );
    }

    /** @test */
    public function user_cannot_sign_in_without_email() {
        /** given */
        $this->prepareFakeUser();

        /** when */
        $response = $this->postJson( '/api/login', $this->getUserData( [ 'email' => null ] ) );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonFragment( [
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => [
                    'The email field is required.'
                ]
            ]
        ] );
    }

    /** @test */
    public function user_cannot_sign_in_without_password() {
        /** given */
        $this->prepareFakeUser();

        /** when */
        $response = $this->postJson( '/api/login', $this->getUserData( [ 'password' => null ] ) );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonFragment( [
            'message' => 'The given data was invalid.',
            'errors' => [
                'password' => [
                    'The password field is required.'
                ]
            ]
        ] );
    }

    /** @test */
    public function user_receives_valid_token_after_signing_in() {
        /** given */
        $this->prepareFakeUser();
$this->withoutExceptionHandling();

        /** when */
        $response = $this->postJson( '/api/login', $this->getUserData() );
        $token = $response->json()[ "token" ];

        $response = $this->withHeaders( [ 'Authorization' => 'Bearer ' . $token ] )->getJSON( '/api/films' );

        /** expect */
        $response->assertSuccessful();
    }

    private function prepareFakeUser() {
        $credentials = $this->getUserData();

        return User::factory()->create( [
            'hero_id' => 1,
            'email' => $credentials[ 'email' ],
            'password' => Hash::make( $credentials[ 'password' ] )
        ] );
    }

    private function getUserData( array $data = [] ) {
        return array_merge( [
            'email' => 'john.doe@example.com',
            'password' => 'Vertex25!',
        ], $data );
    }
}
