<?php


namespace App\Swagger\Responses;

/**
 * @OA\Schema(
 *      title="Sign in success response",
 *      description="When email and password are valid",
 *      type="object"
 * )
 */
class ProfileUpdateSuccessResponse {

    /**
     * @OA\Property (
     *     title="message",
     *     format="string",
     *     example="Great! Your profile has been successfully updated."
     * )
     * @var string
     */
    public $message;

}
