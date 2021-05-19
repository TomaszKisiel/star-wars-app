<?php


namespace App\Swagger\Requests;

/**
 * @OA\Schema(
 *      title="Registration request",
 *      description="Registration request body data",
 *      type="object",
 *      required={"email", "password", "password_confirmation"}
 * )
 */
class RegisterRequest {

    /**
     * @OA\Property(
     *      title="email",
     *      description="Email address for the user being created.",
     *      example="john.doe@example.com"
     * )
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="password",
     *      description="Password for the user being created.",
     *      example="Vertex25!"
     * )
     * @var string
     */
    public $password;

    /**
     * @OA\Property(
     *      title="password",
     *      description="Password confirmation for the user being created.",
     *      example="Vertex25!"
     * )
     * @var string
     */
    public $password_confirmation;

}
