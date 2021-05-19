<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckResourceAccess;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PlanetController extends Controller {

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index() {
        $user = Auth::user();

        $hero = Http::get( 'https://swapi.dev/api/people/' . $user->hero_id )->collect();
        $planetUrl = $hero->get( 'homeworld' );

        $planets = collect();
            $planets->add( Http::get( $planetUrl )->collect() );

        return response()->json( [
            'planets' => $planets->toArray()
        ], 200 );
    }

    /**
     * @param                     $id
     * @param CheckResourceAccess $resourceAccess
     * @return \Illuminate\Http\JsonResponse
     */
    public function show( $id, CheckResourceAccess $resourceAccess ) {
        $user = Auth::user();
        $planet = Http::get( 'https://swapi.dev/api/planets/' . $id )->collect();

        $authenticated = collect( $planet->get( 'residents' ) )->contains( function ($url) use ( $user, $resourceAccess ) {
            return $resourceAccess->handle( $url, '/api/people/' . $user->hero_id );
        });

        if ( ! $authenticated ) {
            return response()->json( [
                'message' => 'Unfortunately! This planet isn\'t correlated with your hero.'
            ], 401 );
        }

        return response()->json( $planet->toArray(), 200 );
    }

}
