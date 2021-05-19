<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Star Wars API",
 *     version="0.1",
 *     description="API documentation for Star Wars app.",
 *     @OA\Contact( email="tkisiel5w4@yahoo.com" ),
 *     @OA\License( name="MIT" )
 * )
 * @OA\Tag(
 *     name="auth",
 *     description="registration, authentication and profile updated",
 * )
 * @OA\Tag(
 *     name="films",
 *     description="films corelated with user's star wars hero",
 * )
 * @OA\Tag(
 *     name="planets",
 *     description="planets corelated with user's star wars hero",
 * )
 * @OA\Server(
 *     url=SWAGGER_HOST,
 *     description="Star Wars API Server",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
