<?php


namespace App\Actions;


use Illuminate\Support\Facades\Auth;

class UpdateProfile implements ActionInterface {

    private $email;

    public function execute() {
        $user = Auth::user();
        $user->email = $this->email;
        $user->save();
    }

    public function set( $email ) {
        $this->email = $email;

        return $this;
    }
}
