<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller {

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="authenticate existing user",
     *     tags={"auth"},
     *     @OA\RequestBody(
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description=""
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description=""
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description=""
     *     ),
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke( Request $request ) {
        $this->validation( $data = $request->only(['email', 'password']) );

        if ( ! Auth::attempt( $data ) ) {
            return response()->json([
                'message' => 'Unfortunately! The given credentials don\'t match any existing user.'
            ], 401);
        }

        $token = Str::random(64);
        Auth::user()->apiTokens()->create([
            'api_token' => $token
        ]);

        return response()->json( [
            'message' => 'You have been logged in successfully. You can now access your data via the bearer API token.',
            'token' => $token
        ], 200 );
    }

    private function validation( array $data = [] ) {
        return Validator::make( $data, [
            'email' => [ 'required' ],
            'password' => [ 'required' ]
        ] )->validate();
    }
}
