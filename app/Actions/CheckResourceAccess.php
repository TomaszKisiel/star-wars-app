<?php


namespace App\Actions;


class CheckResourceAccess {

    public function handle( $resource, $match ) {
        $path = parse_url( $resource, PHP_URL_PATH );
        $match = substr( $match, -1 ) === '/' ? $match : $match . '/';

        return $path === $match;
    }

}
