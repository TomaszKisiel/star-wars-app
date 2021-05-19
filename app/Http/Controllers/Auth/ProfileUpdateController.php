<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileUpdateController extends Controller {

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
     *
     * Handle the incoming request.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke( Request $request ) {
        //
    }
}
