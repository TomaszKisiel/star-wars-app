<?php

namespace Tests\Feature\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/** @covers \App\Http\Controllers\Auth\ProfileController */
class ProfileControllerTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_update_own_profile() {
        /** given */
        $user = User::factory()->create();

        /** when */
        $email = 'adam.nowak@example.com';
        $response = $this->actingAs( $user, 'api' )->putJSON( '/api/user/profile', [ 'email' => $email ] );


        /** expect */
        $response->assertStatus( 200 );
        $this->assertEquals( $email, User::find( $user->id )->email );
    }

    /**
     * @test
     * @covers \App\Exceptions\Handler
     */
    public function unauthenticated_user_cannot_update_profile() {
        /** when */
        $email = 'adam.nowak@example.com';
        $response = $this->putJSON( '/api/user/profile', [ 'email' => $email ] );

        /** expect */
        $response->assertStatus( 401 );
        $response->assertJsonFragment( [
            'message' => 'You\'re unauthenticated because of wrong or not provided api token. Please make sure that your token is correct or sign in again to get new one.'
        ] );
    }

    /** @test  */
    public function user_can_update_only_own_email() {
        /** given */
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $previousEmail = $otherUser->email;

        /** when */
        $email = 'adam.nowak@gmail.com';
        $response = $this->actingAs( $user, 'api' )->putJSON( '/api/user/profile', [ 'email' => $email ] );

        /** expect */
        $response->assertStatus( 200 );
        $this->assertNotEquals( $otherUser->email, $email );
        $this->assertEquals( $previousEmail, $otherUser->email );
    }

    /** @test */
    public function only_provided_data_are_updated() {
        /** given */
        $user = User::factory()->create();
        $password = $user->password;

        /** when */
        $email = 'adam.nowak@example.com';
        $response = $this->actingAs( $user, 'api' )->putJSON( '/api/user/profile', [ 'email' => $email ] );

        /** expect */
        $response->assertStatus( 200 );
        $this->assertEquals( $password, User::find( $user->id )->password );
    }

    /** @test */
    public function user_cannot_update_email_without_email() {
        /** given */
        $user = User::factory()->create();
        $previousEmail = $user->email;

        /** when */
        $response = $this->actingAs( $user, 'api' )->putJSON( '/api/user/profile', [ 'email' => null ] );

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
        $this->assertEquals( $previousEmail, $user->email );
    }

    /** @test */
    public function user_cannot_update_email_with_invalid_email() {
        /** given */
        $user = User::factory()->create();
        $previousEmail = $user->email;

        /** when */
        $email = 'not_email.com';
        $response = $this->actingAs( $user, 'api' )->putJSON( '/api/user/profile', [ 'email' => $email ] );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonFragment( [
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => [
                    'The email must be a valid email address.'
                ]
            ]
        ] );
        $this->assertEquals( $previousEmail, $user->email );
    }

    /** @test */
    public function user_cannot_update_email_with_too_long_email() {
        /** given */
        $user = User::factory()->create();
        $previousEmail = $user->email;

        /** when */
        $email = Str::random(300) . '@example.com';
        $response = $this->actingAs( $user, 'api' )->putJSON( '/api/user/profile', [ 'email' => $email ] );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonFragment( [
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => [
                    'The email must not be greater than 255 characters.'
                ]
            ]
        ] );
        $this->assertEquals( $previousEmail, $user->email );
    }

    /** @test */
    public function user_cannot_update_email_with_email_already_in_use() {
        /** given */
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $previousEmail = $user->email;

        /** when */
        $response = $this->actingAs( $user, 'api' )->putJSON( '/api/user/profile', [ 'email' => $otherUser->email ] );

        /** expect */
        $response->assertStatus( 422 );
        $response->assertJsonFragment( [
            'message' => 'The given data was invalid.',
            'errors' => [
                'email' => [
                    'The email has already been taken.'
                ]
            ]
        ] );
        $this->assertEquals( $previousEmail, $user->email );
    }

}
