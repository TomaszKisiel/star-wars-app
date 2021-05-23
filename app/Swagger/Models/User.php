<?php


namespace App\Swagger\Models;

/**
 * @OA\Schema(
 *     title="User model",
 *     description="User model",
 *     @OA\Xml(
 *         name="User"
 *     )
 * )
 */
class User {

    /**
     * @OA\Property(
     *     title="id",
     *     description="User id",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *     title="hero_id",
     *     description="Correlated star wars hero's id",
     *     format="int64",
     *     example=23
     * )
     *
     * @var integer
     */
    private $hero_id;

    /**
     * @OA\Property(
     *      title="email",
     *      description="Email address of the user",
     *      example="john.doe@example.com"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *     title="created_at",
     *     description="User creation date",
     *     example="2021-05-19 15:30:12",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="updated_at",
     *     description="The last user edition date",
     *     example="2021-05-19 15:30:12",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;
}
