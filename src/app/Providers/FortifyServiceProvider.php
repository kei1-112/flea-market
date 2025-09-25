<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Illuminate\Auth\Events\Registered;
use App\Http\Responses\RegisterResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::ignoreRoutes();

        //開発用
        RateLimiter::for('login', function (Request $request){
            return Limit::none();
        });
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function (){
            return view('register');
        });

        Fortify::loginView(function (){
            return view('login');
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = \App\Models\User::where('email', $request->email)->first();

            if (
                $user &&
                Hash::check($request->password, $user->password) &&
                $user->hasVerifiedEmail()
            ) {
                return $user;
            }

            return null;
        });
    }

    public function register(){
        $this->app->singleton(RegisterResponseContract::class, RegisterResponse::class);

        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
    }
}
