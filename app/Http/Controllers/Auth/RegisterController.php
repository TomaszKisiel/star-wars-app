<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller {

    /**
     * @OA\Post (
     *     path="/api/register",
     *     summary="create new user account",
     *     tags={"auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/RegisterRequest")
     *     ),
     *     @OA\Response (
     *         response=201,
     *         description="New user was successfully created.",
     *         @OA\JsonContent(ref="#/components/schemas/RegisterCreatedResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="The given data was invalid.",
     *         @OA\JsonContent(ref="#/components/schemas/RegisterUnprocessableResponse")
     *     )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke( Request $request ) {
        $data = $this->validation( $request->all() );

        $user = User::create( [
            'hero_id' => 1,
            'email' => $data['email'],
            'password' => Hash::make( $data[ 'password' ] )
        ] );

        return response()->json( [
            'message' => 'Your account has been successfully created! Now You can sign in via login endpoint.',
            'user' => $user
        ], 201 );
    }

    private function validation( array $data = [] ) {
        return Validator::make( $data, [
            'email' => [ 'required', 'email', 'max:255', 'unique:users' ],
            'password' => [ 'required', 'min:8', 'max:64', 'regex:/(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\W])/', 'confirmed' ]
        ], [
            'password.regex' => 'Password is too weak. At least one letter, number and special character are required.'
        ] )->validated();
    }

}
