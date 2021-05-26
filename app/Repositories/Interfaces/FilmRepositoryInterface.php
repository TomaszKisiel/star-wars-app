<?php


namespace App\Repositories\Interfaces;


interface FilmRepositoryInterface {
    public function getAll( $heroId );
    public function getById( $heroId, $filmId);
}
