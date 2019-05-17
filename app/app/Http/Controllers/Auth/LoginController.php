<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * @var UserRepository
     */
    private $user_repository;

    /**
     * LoginController constructor.
     *
     * @param UserRepository $user_repository
     */
    public function __construct( UserRepository $user_repository ) {
        $this->user_repository = $user_repository;
    }

    /**
     * Ensures that the login form is redirected to the google login page
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm( Request $request )
    {
        return $this->login( $request );
    }

    /**
     * Redirect to Google's OAuth
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return Socialite::driver( 'google' )
            ->with( [ 'hd' => 'tri.be' ] )
            ->redirect();
    }

    /**
     * Callback route for login
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function loginCallback( Request $request )
    {
        $driver = Socialite::driver( 'google' );

        // if we are on the callback route and there isn't a code GET param, try the login process again
        if ( ! $request->has( 'code' ) ) {
            return redirect( '/login' );
        }

        $user = $this->user_repository->findByEmailOrCreate( $driver->user() );

        // if a user cannot be found or created, prompt for a fresh login
        if ( ! $user ) {
            return redirect( '/login' );
        }

        Auth::login( $user, true );

        return redirect( '/' );
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut()
    {
        Auth::logout();
        return redirect( '/' );
    }
}
