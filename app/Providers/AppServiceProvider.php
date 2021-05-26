<?php

namespace App\Providers;

use App\Repositories\Cache\CacheHttpRequestRepository;
use App\Repositories\External\ExternalFilmRepository;
use App\Repositories\External\ExternalHeroRepository;
use App\Repositories\External\ExternalHttpRepository;
use App\Repositories\External\ExternalPlanetRepository;
use App\Repositories\Interfaces\FilmRepositoryInterface;
use App\Repositories\Interfaces\HeroRepositoryInterface;
use App\Repositories\Interfaces\HttpRequestRepositoryInterface;
use App\Repositories\Interfaces\PlanetRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    /**
     * Register any application services.
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot() {
        $this->app->singleton( HttpRequestRepositoryInterface::class, function () {
            $baseRepository = new ExternalHttpRepository();
            $decoratedRepository = new CacheHttpRequestRepository( $baseRepository, $this->app[ 'cache.store' ] );

            return $decoratedRepository;
        } );

        $this->app->singleton( HeroRepositoryInterface::class, ExternalHeroRepository::class );
        $this->app->singleton( FilmRepositoryInterface::class, ExternalFilmRepository::class );
        $this->app->singleton( PlanetRepositoryInterface::class, ExternalPlanetRepository::class );
    }
}
