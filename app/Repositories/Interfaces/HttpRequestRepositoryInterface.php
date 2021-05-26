<?php


namespace App\Repositories\Interfaces;


use Illuminate\Http\Client\Response;

interface HttpRequestRepositoryInterface {
    public function get( $url ) : Response;
    public function post( $url ) : Response;
    public function put( $url ) : Response;
    public function patch( $url ) : Response;
    public function head( $url ) : Response;
    public function delete( $url ) : Response;
}
