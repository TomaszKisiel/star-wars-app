<?php


namespace App\Swagger\Responses;

/**
 * @OA\Schema(
 *      title="Unprocessable response",
 *      description="When given data was invalid.",
 *      type="object"
 * )
 */
class UnprocessableResponse {

    /**
     * @OA\Property (
     *     title="message",
     *     example="The given data was invalid."
     * )
     * @var string
     */
    public $message;

    /**
     * @OA\Property(
     *     title="errors",
     *     description="Description of invalid entites",
     *     @OA\Property (
     *         property="email",
     *         example={"The email field is required."}
     *     ),
     *     @OA\Property (
     *         property="password",
     *         example={"The password must be at least 8 characters.","Password is too weak. At least one letter, number and special character are required."}
     *     )
     * )
     *
     * @var object
     */
    private $errors;

}

