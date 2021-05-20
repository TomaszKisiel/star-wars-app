<?php


namespace App\Swagger\Responses;

/**
 * @OA\Schema(
 *      title="Unauthenticated response",
 *      description="When token is invalid or missing",
 *      type="object"
 * )
 */
class UnauthenticatedResponse {

    /**
     * @OA\Property (
     *     title="message",
     *     example="You're unauthenticated because of wrong or not provided api token. Please make sure that your token is correct or sign in again to get new one."
     * )
     * @var string
     */
    public $message;

}
