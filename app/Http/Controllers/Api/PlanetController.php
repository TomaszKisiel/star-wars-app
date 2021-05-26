<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckResourceAccess;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\Interfaces\PlanetRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class PlanetController extends Controller {

    private $planetRepository;

    public function __construct(PlanetRepositoryInterface $planetRepository) {
        $this->planetRepository = $planetRepository;
    }

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
        $user = User::find( Auth::user()->getAuthIdentifier() );
        $planets = $this->planetRepository->getAll( $user->hero_id );

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
        $user = User::find( Auth::user()->getAuthIdentifier() );
        $planet = $this->planetRepository->getById( $user->hero_id, $id );

        $authorized = $resourceAccess->set(
            $planet->get('residents'),
            $user->hero_id
        )->execute();

        if ( !$authorized ) {
            return response()->json( [
                'message' => 'Unfortunately! This planet isn\'t correlated with your hero.'
            ], 401 );
        }

        return response()->json( $planet->toArray(), 200 );
    }

}
