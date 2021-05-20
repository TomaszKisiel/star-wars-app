<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

/** @covers \App\Http\Controllers\Auth\RegisterController */
class RegisterControllerTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function user_can_register_with_valid_data() {
        /** when */
        $response = $this->postJSON( '/api/register', $this->getUserData() );

        /** expect */
        $response->assertCreated();
        $this->assertCount( 1, User::all() );

        $this->assertNotNull( $data = $response->json() );
        $this->assertNotNull( $data[ 'user' ] );

        $this->assertEquals( 'Your account has been successfully created! Now You can sign in via login endpoint.', $data[ 'message' ] );

        $response->assertJsonStructure( [
            'message',
            'user' => [
                'id', 'hero_id', 'email', 'created_at', 'updated_at'
            ]
        ] );
    }

    /** @test */
    public function user_can_sign_in_via_registration_credentials() {
        /** when */
        $response = $this->postJSON( '/api/register', $credentials = $this->getUserData() );

        $user = User::find( $response->json()[ 'user' ][ 'id' ] );

        /** expect */
        $this->assertEquals( $credentials[ 'email' ], $user->email );
        $this->assertTrue( Hash::check( $credentials[ 'password' ], $user->password ) );
    }

    /** @test */
    public function user_cannot_register_without_email() {
        /** when */
        $response = $this->postJSON( '/api/register', $this->getUserData( [ 'email' => null ] ) );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonStructure( [
            'message',
            'errors' => [
                'email'
            ]
        ] );
        $response->assertJsonFragment( [
            'errors' => [
                'email' => [
                    'The email field is required.'
                ]
            ]
        ] );
    }

    /** @test */
    public function user_cannot_register_with_invalid_email() {
        /** when */
        $response = $this->postJSON( '/api/register', $this->getUserData( [ 'email' => 'invalid_email' ] ) );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonFragment( [
            'errors' => [
                'email' => [
                    'The email must be a valid email address.'
                ]
            ]
        ] );
    }

    /** @test */
    public function user_cannot_register_with_to_long_email() {
        /** when */
        $response = $this->postJSON( '/api/register', $this->getUserData( [ 'email' => Str::random( 300 ) . '@example.com' ] ) );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonFragment( [
            'errors' => [
                'email' => [
                    'The email must not be greater than 255 characters.'
                ]
            ]
        ] );
    }

    /** @test */
    public function user_cannot_register_with_email_already_in_use() {
        /** given */
        $this->postJSON( '/api/register', $this->getUserData() );

        /** when */
        $response = $this->postJSON( '/api/register', $this->getUserData() );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonFragment( [
            'errors' => [
                'email' => [
                    'The email has already been taken.'
                ]
            ]
        ] );
    }

    /** @test */
    public function user_cannot_register_without_password() {
        /** when */
        $response = $this->postJSON( '/api/register', $this->getUserData( [ 'password' => null ] ) );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonStructure( [
            'message',
            'errors' => [
                'password'
            ]
        ] );
        $response->assertJsonFragment( [
            'errors' => [
                'password' => [
                    'The password field is required.'
                ]
            ]
        ] );
    }

    /** @test */
    public function user_cannot_register_with_too_short_password() {
        /** when */
        $password = '0Rh+';
        $response = $this->postJSON( '/api/register', $this->getUserData( [ 'password' => $password, 'password_confirmation' => $password ] ) );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonFragment( [
            'errors' => [
                'password' => [
                    'The password must be at least 8 characters.'
                ]
            ]
        ] );
    }

    /** @test */
    public function user_cannot_register_with_too_long_password() {
        /** when */
        $password = Str::random( 64 ) . "0Rh-";
        $response = $this->postJSON( '/api/register', $this->getUserData( [ 'password' => $password, 'password_confirmation' => $password ] ) );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonFragment( [
            'errors' => [
                'password' => [
                    'The password must not be greater than 64 characters.'
                ]
            ]
        ] );
    }


    /** @test */
    public function user_cannot_register_with_weak_password() {
        /** when */
        $password = 'password';
        $response = $this->postJSON( '/api/register', $this->getUserData( [ 'password' => $password, 'password_confirmation' => $password ] ) );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonFragment( [
            'errors' => [
                'password' => [
                    'Password is too weak. At least one letter, number and special character are required.'
                ]
            ]
        ] );
    }

    /** @test */
    public function user_cannot_register_without_password_confirmation() {
        /** when */
        $response = $this->postJSON( '/api/register', $this->getUserData( [ 'password_confirmation' => null ] ) );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonFragment( [
            'errors' => [
                'password' => [
                    'The password confirmation does not match.'
                ]
            ]
        ] );
    }


    /** @test */
    public function user_cannot_register_with_password_confirmation_mismatched() {
        /** when */
        $response = $this->postJSON( '/api/register', $this->getUserData( [ 'password_confirmation' => 'Vertex25^' ] ) );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonFragment( [
            'errors' => [
                'password' => [
                    'The password confirmation does not match.'
                ]
            ]
        ] );
    }

    /**
     * There is enormous small probability that this test fail when 10 random numbers from row are the same.
     * These probability is (1/N)^M where N is number of records in SW API heroes database and M is a number
     * of tries. When N = 82 and M = 10 the probability is equal to 7.26e-20 which mean that fail happened
     * very rarely.
     * @test
     * @covers \App\Actions\GetRandomHeroId
     */
    public function user_receives_random_hero_id_during_registration() {
        /** when */
        $herosIds = [];
        for ( $i = 0; $i < 10; $i++ ) {
            $response = $this->postJSON( '/api/register', $this->getUserData( [
                'email' => 'abcd' . $i . '@example.com'
            ] ) );

            array_push( $herosIds, $response->json()[ 'user' ][ 'hero_id' ] );
        }


        /** expect */
        $this->assertCount( 10, $herosIds );
        $this->assertTrue( $this->simplyRandomnessTest( $herosIds ) );
    }

    private function simplyRandomnessTest( array $data = [] ) {
        for ( $i = 0; $i < count( $data ); $i++ ) {
            if ( $i > 0 && $data[$i] != $data[$i-1] ) {
                return true;
            }
        }

        return false;
    }

    private function getUserData( array $data = [] ) {
        return array_merge( [
            'email' => 'john.doe@example.com',
            'password' => 'Vertex25!',
            'password_confirmation' => 'Vertex25!'
        ], $data );
    }
}
