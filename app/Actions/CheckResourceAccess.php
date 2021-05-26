<?php


namespace App\Actions;


class CheckResourceAccess implements ActionInterface {

    private $allowedHeroesUrls;
    private $userHeroId;

    /**
     * @return bool
     */
    public function execute() {
        foreach ( $this->allowedHeroesUrls as $allowedId ) {
            $allowedId = intval( basename( $allowedId ) );

            if ( $allowedId === $this->userHeroId ) {
                return true;
            }
        }

        return false;
    }

    public function set( $allowedHeroesUrls, $userHeroId ) {
        $this->allowedHeroesUrls = $allowedHeroesUrls;
        $this->userHeroId = $userHeroId;

        return $this;
    }

}
