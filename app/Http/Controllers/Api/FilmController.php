<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckResourceAccess;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FilmController extends Controller {

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $user = Auth::user();

        $hero = Http::get( 'https://swapi.dev/api/people/' . $user->hero_id )->collect();
        $filmsUrls = $hero->get( 'films' );

        $films = collect();
        foreach ( $filmsUrls as $url ) {
            $films->add( Http::get( $url )->collect() );
        }

        return response()->json( [
            'films' => $films->toArray()
        ], 200 );
    }

    /**
     * @param                     $id
     * @param CheckResourceAccess $resourceAccess
     * @return \Illuminate\Http\JsonResponse
     */
    public function show( $id, CheckResourceAccess $resourceAccess ) {
        $user = Auth::user();
        $film = Http::get( 'https://swapi.dev/api/films/' . $id )->collect();

        $authenticated = collect( $film->get( 'characters' ) )->contains( function ($url) use ( $user, $resourceAccess ) {
           return $resourceAccess->execute( $url, '/api/people/' . $user->hero_id );
        });

        if ( ! $authenticated ) {
            return response()->json( [
                'message' => 'Unfortunately! This film isn\'t correlated with your hero.'
            ], 401 );
        }

        return response()->json( $film->toArray(), 200 );
    }
}
