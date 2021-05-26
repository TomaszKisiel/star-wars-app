<?php


namespace App\Repositories\External;


use App\Repositories\Interfaces\FilmRepositoryInterface;
use App\Repositories\Interfaces\HeroRepositoryInterface;
use App\Repositories\Interfaces\HttpRequestRepositoryInterface;
use Illuminate\Support\Facades\Http;

class ExternalFilmRepository implements FilmRepositoryInterface {

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
        $filmsUrls = $hero->get( 'films' );

        $films = collect();
        foreach ( $filmsUrls as $url ) {
            $filmResponse = $this->requestRepository->get( $url );

            if ( ! $filmResponse->successful() ) continue;

            $films->add(
                $filmResponse->collect()
            );
        }

        return $films;
    }

    public function getById( $heroId, $filmId ) {
        $filmResponse = $this->requestRepository->get( 'https://swapi.dev/api/films/' . $filmId );

        if ( ! $filmResponse->successful() ) {
            throw new \Exception('SWP API break down!');
        }

        return $filmResponse->collect();
    }
}
