<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Redirect to google for authentication.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handling the the user after getting authentication from goggle.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (InvalidStateException $e) {
            $user = Socialite::driver('google')->stateless()->user();
        }
        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Redirect to facebook for authentication.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handling the the user after getting authentication from facebook.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (InvalidStateException $e) {
            $user = Socialite::driver('facebook')->stateless()->user();
        }
        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Redirect to git hub for authentication.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToGithub()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Handling the the user after getting authentication from git hub.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGithubCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
        } catch (InvalidStateException $e) {
            $user = Socialite::driver('github')->stateless()->user();
        }
        $this->_registerOrLoginUser($user);

        // Return home after login
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Registering the user if not registered and authenticating the user.
     * @return void
     */
    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = !empty($data->name) ? $data->name : $data->email;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        }

        Auth::login($user);
    }
}
