<?php


namespace App\Repositories\External;


use App\Repositories\Interfaces\HeroRepositoryInterface;
use App\Repositories\Interfaces\HttpRequestRepositoryInterface;
use App\Repositories\Interfaces\PlanetRepositoryInterface;

class ExternalHeroRepository implements HeroRepositoryInterface {

    private $requestRepository;

    public function __construct( HttpRequestRepositoryInterface $requestRepository ) {
        $this->requestRepository = $requestRepository;
    }

    public function getById( $id ) {
        $response = $this->requestRepository->get( 'https://swapi.dev/api/people/' . $id );

        if ( ! $response->successful() ) {
            throw new \Exception('SWP API break down!');
        }

        return $response->collect();
    }
}
