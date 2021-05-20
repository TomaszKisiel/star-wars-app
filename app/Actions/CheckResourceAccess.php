<?php


namespace App\Actions;


class CheckResourceAccess {


    /**
     * @param string $resource
     * @param string $match
     * @return bool
     */
    public function execute( string $resource, string $match ) {
        $path = parse_url( $resource, PHP_URL_PATH );
        $match = substr( $match, -1 ) === '/' ? $match : $match . '/';

        return $path === $match;
    }

}
