<?php


namespace App\Repositories\Interfaces;


interface PlanetRepositoryInterface {
    public function getAll( $heroId );
    public function getById( $heroId, $planetId);
}
