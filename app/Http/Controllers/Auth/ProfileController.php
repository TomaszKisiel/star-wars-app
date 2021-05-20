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
     *     path="/api/user/profile",
     *     summary="update user profile data",
     *     tags={"auth"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProfileUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns acknowledge when the user profile has been successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/ProfileUpdateSuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="There is required to provide correct api token to see this resources",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="The given data was invalid.",
     *         @OA\JsonContent(ref="#/components/schemas/UnprocessableResponse")
     *     ),
     * )
     * Handle the incoming request.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke( Request $request ) {
        $this->validation( $data = $request->only(['email']) );

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
        ] )->validate();
    }
}
