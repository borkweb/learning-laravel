<?php
namespace App\Repositories;

use DB;
use App\Models\User;
use App\Util\Central;

class UserRepository
{
    /**
     * Finds or creates a user based on email
     *
     * @param object $user_data
     *
     * @return null|User
     */
    public function findByEmailOrCreate( $user_data ) {
        $username = str_replace( '@tri.be', '', $user_data->email );

        return User::firstOrCreate( [
            'username' => $username,
            'email'    => $user_data->email,
        ], (array) $user_data );
    }

    /**
     * Fetches a user by user_id
     *
     * @param string $user_id
     *
     * @return User
     */
    public function get_user_by_id( $user_id ) {
        $user = User::where( 'id', $user_id )
            ->first();

        return $user;
    }

    /**
     * Fetches a user by username
     *
     * @param string $username
     *
     * @return User
     */
    public function get_user_by_username( $username ) {
        $user = User::where( 'username', $username )
            ->first();

        return $user;
    }
}
