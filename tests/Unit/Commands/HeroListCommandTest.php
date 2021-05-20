<?php

namespace Tests\Unit\Commands;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HeroListCommandTest extends TestCase {

    use RefreshDatabase, WithFaker;

    /** @test */
    public function show_paginated_list_of_users_with_their_heros() {
        /** given */
        $this->prepareFakeUsers();

        /** expect */
        $this->artisan( 'hero:list' )
            ->expectsTable( [
                'id',
                'email',
                'hero_id',
                'hero_name',
                'hero_url'
            ], [
                [ 1, 'john.doe.1@example.com', 1, 'Luke Skywalker', 'http://swapi.dev/api/people/1/' ],
                [ 2, 'john.doe.2@example.com', 2, 'C-3PO', 'http://swapi.dev/api/people/2/' ],
                [ 3, 'john.doe.3@example.com', 3, 'R2-D2', 'http://swapi.dev/api/people/3/' ],
                [ 4, 'john.doe.4@example.com', 4, 'Darth Vader', 'http://swapi.dev/api/people/4/' ],
                [ 5, 'john.doe.5@example.com', 5, 'Leia Organa', 'http://swapi.dev/api/people/5/' ],
                [ 6, 'john.doe.6@example.com', 6, 'Owen Lars', 'http://swapi.dev/api/people/6/' ],
                [ 7, 'john.doe.7@example.com', 7, 'Beru Whitesun lars', 'http://swapi.dev/api/people/7/' ],
                [ 8, 'john.doe.8@example.com', 8, 'R5-D4', 'http://swapi.dev/api/people/8/' ],
                [ 9, 'john.doe.9@example.com', 9, 'Biggs Darklighter', 'http://swapi.dev/api/people/9/' ],
                [ 10, 'john.doe.10@example.com', 10, 'Obi-Wan Kenobi', 'http://swapi.dev/api/people/10/' ],
            ] );
    }

    /** @test */
    public function list_display_selected_page() {
        /** given */
        $this->prepareFakeUsers();

        /** expect */
        $this->artisan( 'hero:list --page=2' )
            ->expectsTable( [
                'id',
                'email',
                'hero_id',
                'hero_name',
                'hero_url'
            ], [
                [ 11, 'john.doe.11@example.com', 11, 'Anakin Skywalker', 'http://swapi.dev/api/people/11/' ],
                [ 12, 'john.doe.12@example.com', 12, 'Wilhuff Tarkin', 'http://swapi.dev/api/people/12/' ],
                [ 13, 'john.doe.13@example.com', 13, 'Chewbacca', 'http://swapi.dev/api/people/13/' ],
                [ 14, 'john.doe.14@example.com', 14, 'Han Solo', 'http://swapi.dev/api/people/14/' ],
                [ 15, 'john.doe.15@example.com', 15, 'Greedo', 'http://swapi.dev/api/people/15/' ],
                [ 16, 'john.doe.16@example.com', 16, 'Jabba Desilijic Tiure', 'http://swapi.dev/api/people/16/' ],
            ] );
    }

    /** @test */
    public function list_display_selected_amount_of_rows_per_page() {
        /** given */
        $this->prepareFakeUsers();

        /** expect */
        $this->artisan( 'hero:list --per-page=3' )
            ->expectsTable( [
                'id',
                'email',
                'hero_id',
                'hero_name',
                'hero_url'
            ], [
                [ 1, 'john.doe.1@example.com', 1, 'Luke Skywalker', 'http://swapi.dev/api/people/1/' ],
                [ 2, 'john.doe.2@example.com', 2, 'C-3PO', 'http://swapi.dev/api/people/2/' ],
                [ 3, 'john.doe.3@example.com', 3, 'R2-D2', 'http://swapi.dev/api/people/3/' ],
            ] );
    }

    /** @test */
    public function list_display_selected_amount_of_rows_per_page_on_selected_page() {
        /** given */
        $this->prepareFakeUsers();

        /** expect */
        $this->artisan( 'hero:list --page=2 --per-page=3' )
            ->expectsTable( [
                'id',
                'email',
                'hero_id',
                'hero_name',
                'hero_url'
            ], [
                [ 4, 'john.doe.4@example.com', 4, 'Darth Vader', 'http://swapi.dev/api/people/4/' ],
                [ 5, 'john.doe.5@example.com', 5, 'Leia Organa', 'http://swapi.dev/api/people/5/' ],
                [ 6, 'john.doe.6@example.com', 6, 'Owen Lars', 'http://swapi.dev/api/people/6/' ],
            ] );
    }

    private function prepareFakeUsers() {
        for ( $i = 1; $i <= 16; $i++ ) {
            User::factory()->create( [
                'id' => $i,
                'hero_id' => $i,
                'email' => 'john.doe.' . $i . '@example.com',
            ] );
        }
    }

}
