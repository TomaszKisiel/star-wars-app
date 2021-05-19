<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller {

    /**
     * @OA\Put(
     *     path="/api/profile/update",
     *     summary="update user profile data",
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
     * Handle the incoming request.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke( Request $request ) {
        $data = $this->validation( $request->all() );

        $user = Auth::user();
        $user->email = $data[ "email" ];
        $user->save();

        return response()->json( [
            "message" => "Great! Your profile has been successfully updated.",
        ], 200 );
    }

    private function validation( array $data = [] ) {
        return Validator::make( $data, [
            'email' => [ 'required', 'email', 'max:255', 'unique:users' ],
        ] )->validated();
    }
}
