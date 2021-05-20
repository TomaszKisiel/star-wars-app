<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckResourceAccess;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
     *
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
        $planet = Http::get( 'https://swapi.dev/api/planets/' . $id )->collect();

        $authenticated = collect( $planet->get( 'residents' ) )->contains( function ($url) use ( $user, $resourceAccess ) {
            return $resourceAccess->execute( $url, '/api/people/' . $user->hero_id );
        });

        if ( ! $authenticated ) {
            return response()->json( [
                'message' => 'Unfortunately! This planet isn\'t correlated with your hero.'
            ], 401 );
        }

        return response()->json( $planet->toArray(), 200 );
    }

}
