<?php


namespace App\Swagger\Responses;

/**
 * @OA\Schema(
 *      title="Films list response",
 *      description="Films associated to user's hero from star wars",
 *      type="object"
 * )
 */
class FilmListResponse {

    /**
     * @OA\Property (
     *     title="films",
     *     description="User associated films",
     *     @OA\Items(ref="#/components/schemas/Film")
     * )
     * @var array
     */
    public $films;

}
