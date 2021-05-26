<?php


namespace App\Actions;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateNewUser implements ActionInterface {

    private $email;
    private $password;
    private $randomHeroService;

    public function __construct( GetRandomHeroId $randomHeroService ) {
        $this->randomHeroService = $randomHeroService;
    }

    public function execute() {
        $heroId = $this->randomHeroService->execute();

        return User::create( [
            'hero_id' => $heroId,
            'email' => $this->email,
            'password' => Hash::make( $this->password )
        ] );
    }

    public function set( $email, $password ) {
        $this->email = $email;
        $this->password = $password;

        return $this;
    }
}
