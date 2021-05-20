<?php


namespace App\Swagger\Models;

/**
 * @OA\Schema(
 *     title="Planet model",
 *     description="Planet model",
 *     @OA\Xml(
 *         name="Planet"
 *     )
 * )
 */
class Planet {

    /**
     * @OA\Property (
     *     title="name",
     *     description="Planet name",
     *     format="string",
     *     example="Tatooine"
     * )
     * @var string
     */
    public $title;

    /**
     * @OA\Property (
     *     title="rotation_period",
     *     description="Time the planet rotates",
     *     format="int64",
     *     example=24
     * )
     * @var integer
     */
    public $rotation_period;

    /**
     * @OA\Property (
     *     title="orbital_period",
     *     description="Time the planet orbits",
     *     format="int64",
     *     example="304"
     * )
     * @var integer
     */
    public $orbital_period;


    /**
     * @OA\Property (
     *     title="diameter",
     *     description="Planet's diameter",
     *     format="int64",
     *     example="10465"
     * )
     * @var string
     */
    public $diameter;

    /**
     * @OA\Property (
     *     title="climate",
     *     description="Planet's climate",
     *     format="string",
     *     example="arid"
     * )
     * @var string
     */
    public $climate;

    /**
     * @OA\Property (
     *     title="gravity",
     *     description="Gravitational coefficient of the planet",
     *     format="string",
     *     example="1 standard"
     * )
     * @var string
     */
    public $gravity;

    /**
     * @OA\Property (
     *     title="terrain",
     *     description="Type of surface on the planet",
     *     format="string",
     *     example="desert"
     * )
     * @var string
     */
    public $terrain;

    /**
     * @OA\Property (
     *     title="surface_water",
     *     description="Amount of water reservoirs on the planet",
     *     format="int64",
     *     example="1"
     * )
     * @var integer
     */
    public $surface_water;

    /**
     * @OA\Property (
     *     title="population",
     *     description="Amount of intelligent beings inhabiting the planet",
     *     format="int64",
     *     example="200000"
     * )
     * @var string
     */
    public $population;

    /**
     * @OA\Property (
     *     title="residents",
     *     description="Urls of characters associated with planet",
     *     format="array",
     *     @OA\Items(
     *         example="http://swapi.dev/api/people/1/"
     *     )
     * )
     * @var array
     */
    public $residents;

    /**
     * @OA\Property (
     *     title="films",
     *     description="Urls of films where planet featured",
     *     format="array",
     *     @OA\Items( example="http://swapi.dev/api/films/1/" )
     * )
     * @var array
     */
    public $films;

    /**
     * @OA\Property(
     *     title="created",
     *     description="Planet creation date",
     *     example="2021-05-19 15:30:12",
     *     format="datetime",
     *     type="string"
     * )
     * @var \DateTime
     */
    private $created;

    /**
     * @OA\Property(
     *     title="edited",
     *     description="The last planet edition date",
     *     example="2021-05-19 15:30:12",
     *     format="datetime",
     *     type="string"
     * )
     * @var \DateTime
     */
    private $edited;

    /**
     * @OA\Property (
     *     title="url",
     *     description="Resource url",
     *     format="uri",
     *     example="http://swapi.dev/api/planets/1"
     * )
     * @var string
     */
    public $url;

}
