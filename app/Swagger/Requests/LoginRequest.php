<?php


namespace App\Swagger\Requests;

/**
 * @OA\Schema(
 *      title="Login request",
 *      description="Login request body data",
 *      type="object",
 *      required={"email", "password"}
 * )
 */
class LoginRequest {

    /**
     * @OA\Property(
     *      title="email",
     *      description="Email address to the user's account.",
     *      example="john.doe@example.com"
     * )
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="password",
     *      description="Password to the user's account.",
     *      example="Vertex25!"
     * )
     * @var string
     */
    public $password;

}
