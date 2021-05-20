<?php


namespace App\Swagger\Responses;

/**
 * @OA\Schema(
 *      title="Registration created response",
 *      description="Registration response after user being created.",
 *      type="object"
 * )
 */
class RegisterCreatedResponse {

    /**
     * @OA\Property (
     *     title="message",
     *     example="Your account has been successfully created! Now You can sign in via login endpoint."
     * )
     * @var string
     */
    public $message;

    /**
     * @OA\Property(
     *     title="user",
     *     description="Created user data"
     * )
     *
     * @var \App\Swagger\Models\User
     */
    private $user;

}
