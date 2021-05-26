<?php


namespace App\Repositories\Cache;


use App\Repositories\Interfaces\HttpRequestRepositoryInterface;
use Illuminate\Contracts\Cache\Repository as Cache;
use Illuminate\Http\Client\Response;


class CacheHttpRequestRepository implements HttpRequestRepositoryInterface {

    private $wrappedRepository;
    private $cache;

    private static $TTL = 24 * 60 * 60;

    public function __construct( HttpRequestRepositoryInterface $wrappedRepository, Cache $cache ) {
        $this->wrappedRepository = $wrappedRepository;
        $this->cache = $cache;
    }

    public function get( $url ) : Response {
        return $this->cache->remember( $url, self::$TTL, function () use ( $url ) {
            return $this->wrappedRepository->get( $url );
        } );
    }

    public function post( $url ) : Response {
        throw new \Exception( 'Not implemented yet.' );
    }

    public function put( $url ) : Response {
        throw new \Exception( 'Not implemented yet.' );
    }

    public function patch( $url ) : Response {
        throw new \Exception( 'Not implemented yet.' );
    }

    public function head( $url ) : Response {
        throw new \Exception( 'Not implemented yet.' );
    }

    public function delete( $url ) : Response {
        throw new \Exception( 'Not implemented yet.' );
    }
}
