<?php


namespace App\Swagger\Responses;

/**
 * @OA\Schema(
 *      title="Sign in failed response",
 *      description="When email and password are invalid or missing",
 *      type="object"
 * )
 */
class SignInFailedResponse {

    /**
     * @OA\Property (
     *     title="message",
     *     example="Unfortunately! The given credentials don\'t match any existing user."
     * )
     * @var string
     */
    public $message;

}
