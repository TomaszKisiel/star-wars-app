<?php


namespace App\Repositories\External;


use App\Repositories\Interfaces\HttpRequestRepositoryInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ExternalHttpRepository implements HttpRequestRepositoryInterface {

    public function get( $url ) : Response {
        return Http::get( $url );
    }

    public function post( $url ): Response {
        return Http::post( $url );
    }

    public function put( $url ) : Response{
        return Http::put( $url );
    }

    public function patch( $url ) : Response{
        return Http::patch( $url );
    }

    public function head( $url ) : Response{
        return Http::head( $url );
    }

    public function delete( $url ) : Response{
        return Http::delete( $url );
    }
}
