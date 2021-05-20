<?php


namespace App\Swagger\Responses;

/**
 * @OA\Schema(
 *      title="Planets list response",
 *      description="Planets associated to user's hero from star wars",
 *      type="object"
 * )
 */
class PlanetListResponse {

    /**
     * @OA\Property (
     *     title="planets",
     *     description="User associated planets",
     *     @OA\Items(ref="#/components/schemas/Planet")
     * )
     * @var array
     */
    public $planets;

}
