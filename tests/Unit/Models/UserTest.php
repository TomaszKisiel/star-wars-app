<?php

namespace Tests\Unit\Models;

use App\Models\ApiToken;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @covers \App\Models\User */
class UserTest extends TestCase {

    use RefreshDatabase;

    /** @test */
    public function user_has_expected_properties() {
        $this->assertTrue(
            Schema::hasColumns( 'users', [
                'id', 'hero_id', 'email', 'password', 'created_at', 'updated_at'
            ] )
        );
    }

    /** @test */
    public function user_has_api_tokens() {
        $user = User::factory()->hasApiTokens(3)->create();

        $this->assertCount( 3, $tokens = $user->apiTokens );
        $this->assertInstanceOf( ApiToken::class, $tokens[0] );
    }
}
