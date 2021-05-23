<?php


namespace App\Actions;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GetRandomHeroId {

    /**
     * @return int
     */
    public function execute() {
        $page = $this->getRandomPage();
        $heroId = $this->getRandomHeroId( $page );

        return $heroId;
    }

    /**
     * @return int
     */
    private function getRandomPage() {
        $people = Cache::remember( 'api_people_page_1', now()->addHours(24), function() {
            return Http::get('https://swapi.dev/api/people')->collect();
        });

        $peopleCount = $people->get('count');
        $peoplePerPage = count( $people->get('results') );

        $pages = ceil( $peopleCount / $peoplePerPage );

        return rand(1,$pages);
    }

    /**
     * @param int $page
     * @return int
     */
    private function getRandomHeroId( int $page ) {
        $people = Cache::remember( 'api_people_page_' . $page, now()->addHours(24), function() use ($page) {
           return Http::get('https://swapi.dev/api/people/?page=' . $page )->collect();
        });

        $peopleOnPage = count( $people->get('results') );
        $heroIndex = rand( 0, $peopleOnPage - 1 );

        $hero = $people->get('results')[ $heroIndex ];

        return intval( basename( $hero['url'] ) );
    }

}
