<?php

namespace App\Http\Controllers\Auth;

use App\Actions\IssueNewToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Validation\UnauthorizedException;

class LoginController extends Controller {

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="authenticate existing user",
     *     tags={"auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns new token when valid credentials are provided",
     *         @OA\JsonContent(ref="#/components/schemas/SignInSuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="There is required to provide correct email and password to get token",
     *         @OA\JsonContent(ref="#/components/schemas/SignInFailedResponse")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="The given data was invalid.",
     *         @OA\JsonContent(ref="#/components/schemas/UnprocessableResponse")
     *     )
     * )
     * @param LoginRequest  $request
     * @param IssueNewToken $issueNewToken
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke( LoginRequest $request, IssueNewToken $issueNewToken ) {
        $data = $request->validated();

        try {
            $token = $issueNewToken->set( $data )->execute();
        } catch ( UnauthorizedException $e ) {
            return response()->json([
                'message' => 'Unfortunately! The given credentials don\'t match any existing user.'
            ], 401);
        }

        return response()->json( [
            'message' => 'You have been logged in successfully. You can now access your data via the bearer API token.',
            'token' => $token
        ], 200 );
    }


}
