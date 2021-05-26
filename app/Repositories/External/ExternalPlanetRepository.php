<?php


namespace App\Repositories\External;


use App\Repositories\Interfaces\HeroRepositoryInterface;
use App\Repositories\Interfaces\HttpRequestRepositoryInterface;
use App\Repositories\Interfaces\PlanetRepositoryInterface;

class ExternalPlanetRepository implements PlanetRepositoryInterface {

    private $heroRepository;
    private $requestRepository;

    public function __construct(
        HeroRepositoryInterface $heroRepository,
        HttpRequestRepositoryInterface $requestRepository
    ) {
        $this->heroRepository = $heroRepository;
        $this->requestRepository = $requestRepository;
    }

    public function getAll( $heroId ) {
        $hero = $this->heroRepository->getById( $heroId );
        $homeworldUrl = $hero->get( 'homeworld' );

        return collect(
            [ $this->getById( $heroId, basename( $homeworldUrl ) ) ]
        );
    }

    public function getById( $heroId, $planetId ) {
        $planetResponse = $this->requestRepository->get( 'https://swapi.dev/api/planets/' . $planetId );

        if ( !$planetResponse->successful() ) {
            throw new \Exception( 'SWP API break down!' );
        }

        return $planetResponse->collect();
    }
}
