<?php

namespace App\Libraries;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/**
 * Description of UserFactory
 *
 * @author Kamlesh Jha <mailtojhajee@gmail.com>
 */
class UserFactory {

    public function __construct() {
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function create(array $data) {
        /*
         * TODO:: 
         * Send an email when User do their sign-up
         */
        return User::create([
                    'name' => isset($data['name']) ? $data['name'] : substr($data['email'], 0, strpos($data['email'], '@')),
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
        ]);
    }

    public function changePassword(array $data) {
        $userid = Auth::guard('api')->user()->id;
        if ((Hash::check($data['old_password'], Auth::user()->password)) == false) {
            return 2;
        } else if ((Hash::check($data['new_password'], Auth::user()->password)) == true) {
            return 3;
        } else {
            return User::where('id', $userid)->update(['password' => Hash::make($data['new_password'])]);
        }
    }

    public function revokeAllTokens() {
        $accessToken = Auth::user()->token();
        $accessToken->revoke();
        return TRUE;
    }

}
