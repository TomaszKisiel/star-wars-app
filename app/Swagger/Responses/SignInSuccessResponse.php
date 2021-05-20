<?php


namespace App\Swagger\Responses;

/**
 * @OA\Schema(
 *      title="Sign in success response",
 *      description="When email and password are valid",
 *      type="object"
 * )
 */
class SignInSuccessResponse {

    /**
     * @OA\Property (
     *     title="message",
     *     format="string",
     *     example="You have been logged in successfully. You can now access your data via the bearer API token."
     * )
     * @var string
     */
    public $message;

    /**
     * @OA\Property (
     *     title="token",
     *     description="Bearer token that you can use to get to secure endpoints",
     *     format="string",
     *     example="ogDCM1z1vrwHDhRwMEBby5AlmvY0WrmOGkfN7Rn0LyckOkbeEI4l9IanRwBrKdCl"
     * )
     * @var string
     */
    public $token;

}
