<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class Heroes extends Command {

    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'heroes:list {--page=1 : List page number to display} {--per-page=10 : Amount of displayed user per page}';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Shows list of registered user with their heroes from star wars.';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return int
     */
    public function handle() {
        $page = $this->option('page');
        $perPage = $this->option('per-page');

        $headers = [ 'id', 'email', 'hero_id', 'hero_name', 'hero_url' ];

        $data = User::skip( ( $page - 1 ) * $perPage)
            ->take($perPage)
            ->get(['id', 'email', 'hero_id'])
            ->map( function( $user ) {
                $hero = Http::get('https://swapi.dev/api/people/' . $user->hero_id )->collect();

                return [
                    $user->id,
                    $user->email,
                    $user->hero_id,
                    $hero->get('name'),
                    $hero->get('url'),
                ];
            } );

        $this->table( $headers, $data );

        return 0;
    }
}
