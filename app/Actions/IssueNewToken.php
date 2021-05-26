<?php


namespace App\Actions;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;

class IssueNewToken implements ActionInterface {

    private $credentials;

    public function execute() {
        if ( ! Auth::attempt( $this->credentials ) ) {
            throw new UnauthorizedException();
        }

        Auth::user()->apiTokens()->create([
            'api_token' => $token = Str::random(64)
        ]);

        return $token;
    }

    public function set( $credentials ) {
        $this->credentials = $credentials;

        return $this;
    }

}
