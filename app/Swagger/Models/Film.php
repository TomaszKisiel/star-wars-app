<?php


namespace App\Swagger\Models;

/**
 * @OA\Schema(
 *     title="Film model",
 *     description="Film model",
 *     @OA\Xml(
 *         name="Film"
 *     )
 * )
 */
class Film {

    /**
     * @OA\Property (
     *     title="title",
     *     description="Film title",
     *     format="string",
     *     example="A New Hope"
     * )
     * @var string
     */
    public $title;

    /**
     * @OA\Property (
     *     title="episode_id",
     *     description="Film id",
     *     format="int64",
     *     example=1
     * )
     * @var integer
     */
    public $episode_id;

    /**
     * @OA\Property (
     *     title="opening_crawl",
     *     description="Opening crawler of film",
     *     format="string",
     *     example="Far, far away..."
     * )
     * @var string
     */
    public $opening_crawl;


    /**
     * @OA\Property (
     *     title="director",
     *     description="Film's director",
     *     format="string",
     *     example="George Lucas"
     * )
     * @var string
     */
    public $director;

    /**
     * @OA\Property (
     *     title="producer",
     *     description="Film's producer",
     *     format="string",
     *     example="Gary Kurtz, Rick McCallum"
     * )
     * @var string
     */
    public $producer;

    /**
     * @OA\Property (
     *     title="release_date",
     *     description="Date the movie was released",
     *     format="date",
     *     example="1977-05-25"
     * )
     * @var \DateTime
     */
    public $release_date;

    /**
     * @OA\Property (
     *     title="characters",
     *     description="Urls of characters that were featured in the film",
     *     format="array",
     *     @OA\Items(
     *         example="http://swapi.dev/api/people/1/"
     *     )
     * )
     * @var array
     */
    public $characters;

    /**
     * @OA\Property (
     *     title="planets",
     *     description="Urls of planets that were featured in the film",
     *     format="array",
     *     @OA\Items( example="http://swapi.dev/api/planets/1/" )
     * )
     * @var array
     */
    public $planets;

    /**
     * @OA\Property (
     *     title="starships",
     *     description="Urls of starships that were featured in the film",
     *     format="array",
     *     @OA\Items( example="http://swapi.dev/api/starships/1/" )
     * )
     * @var array
     */
    public $starships;

    /**
     * @OA\Property (
     *     title="vehicles",
     *     description="Urls of vehicles that were featured in the film",
     *     format="array",
     *     @OA\Items( example="http://swapi.dev/api/vehicles/1/" )
     * )
     * @var array
     */
    public $vehicles;

    /**
     * @OA\Property (
     *     title="species",
     *     description="Urls of species that were featured in the film",
     *     format="array",
     *     @OA\Items( example="http://swapi.dev/api/species/1/" )
     * )
     * @var array
     */
    public $species;

    /**
     * @OA\Property(
     *     title="created",
     *     description="Film creation date",
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
     *     description="The last film edition date",
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
     *     example="http://swapi.dev/api/films/1"
     * )
     * @var string
     */
    public $url;

}
