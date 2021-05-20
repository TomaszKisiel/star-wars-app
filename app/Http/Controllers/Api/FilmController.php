<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckResourceAccess;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FilmController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/films",
     *     summary="films associated to user's hero from star wars",
     *     tags={"films"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="Returns list of films associated with user's star wars hero",
     *         @OA\JsonContent(ref="#/components/schemas/FilmListResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="There is required to provide correct api token to see this resources",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")
     *     ),
     * )
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
     * @OA\Get(
     *     path="/api/films/{film}",
     *     summary="film associated to user's hero from star wars by id",
     *     tags={"films"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *          name="film",
     *          description="Film id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Return film associated with user's star wars hero by id",
     *         @OA\JsonContent(ref="#/components/schemas/Film")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="There is required to provide correct api token to see this resources",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")
     *     ),
     * )
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
