<?php

namespace Tests\Unit\Models;

use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/** @covers \App\Models\ApiToken */
class ApiTokenTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function api_token_has_expected_properties() {
        $this->assertTrue(
            Schema::hasColumns( 'api_tokens', [
                'id', 'user_id', 'api_token', 'created_at', 'updated_at'
            ] )
        );
    }

    /** @test */
    public function api_token_belongs_to_user() {
        $user = User::factory()->create();
        $token = ApiToken::factory()->for( $user )->create();

        $this->assertEquals( $user->id, $token->user->id );
        $this->assertInstanceOf( User::class, $token->user );
    }
}
