<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckResourceAccess;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PlanetController extends Controller {

    /**
     * @OA\Get(
     *     path="/api/planets",
     *     summary="planets associated to user's hero from star wars",
     *     tags={"planets"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="Returns list of planets associated with user's star wars hero",
     *         @OA\JsonContent(ref="#/components/schemas/PlanetListResponse")
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
        $heroId = $user->hero_id;

        $hero = Cache::remember( 'api_person_' . $heroId, now()->addHours(24), function () use ( $heroId ) {
            return Http::get( 'https://swapi.dev/api/people/' . $heroId )->collect();
        } );

        $planetUrl = $hero->get( 'homeworld' );
        $planetId = basename( $planetUrl );

        $planets = collect();
        $planets->add(
            Cache::remember( 'api_planet_' . $planetId, now()->addHours(24), function () use ( $planetId ) {
                return Http::get( 'https://swapi.dev/api/planets/' . $planetId )->collect();
            } )
        );

        return response()->json( [
            'planets' => $planets->toArray()
        ], 200 );
    }

    /**
     * @OA\Get(
     *     path="/api/planets/{planet}",
     *     summary="planet associated to user's hero from star wars by id",
     *     tags={"planets"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\Parameter(
     *          name="planet",
     *          description="Planet id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Return planet associated with user's star wars hero by id",
     *         @OA\JsonContent(ref="#/components/schemas/Planet")
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

        $planet = Cache::remember( 'api_planet_' . $id, now()->addHours( 24 ), function () use ( $id ) {
            return Http::get( 'https://swapi.dev/api/planets/' . $id )->collect();
        } );

        $authenticated = collect( $planet->get( 'residents' ) )->contains( function ( $url ) use ( $user, $resourceAccess ) {
            return $resourceAccess->execute( $url, '/api/people/' . $user->hero_id );
        } );

        if ( !$authenticated ) {
            return response()->json( [
                'message' => 'Unfortunately! This planet isn\'t correlated with your hero.'
            ], 401 );
        }

        return response()->json( $planet->toArray(), 200 );
    }

}
