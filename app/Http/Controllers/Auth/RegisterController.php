<?php

namespace App\Http\Controllers\Auth;

use App\Actions\CreateNewUser;
use App\Actions\GetRandomHeroId;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
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
     *         @OA\JsonContent(ref="#/components/schemas/UnprocessableResponse")
     *     )
     * )
     * @param RegisterRequest $request
     * @param CreateNewUser   $newUserService
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke( RegisterRequest $request, CreateNewUser $newUserService ) {
        $data = $request->validated();

        $user = $newUserService->set(
            $data['email'],
            $data['password']
        )->execute();

        return response()->json( [
            'message' => 'Your account has been successfully created! Now You can sign in via login endpoint.',
            'user' => $user
        ], 201 );
    }
}
