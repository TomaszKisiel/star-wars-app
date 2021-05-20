<?php


namespace App\Swagger\Requests;

/**
 * @OA\Schema(
 *      title="Profile update request",
 *      description="Profile update request body data",
 *      type="object",
 *      required={"email"}
 * )
 */
class ProfileUpdateRequest {

    /**
     * @OA\Property(
     *      title="email",
     *      description="New email address to the user's account.",
     *      example="jane.doe@example.com"
     * )
     * @var string
     */
    public $email;

}
