<?php

namespace App\Http\Middleware;
use App\Users as user;
use Closure;

class CheckAuthLoginPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(isset($_COOKIE['token']) && isset($_COOKIE['login'])){
            $token = $_COOKIE['token'];
            $login = $_COOKIE['login'];
            $usr = user::where('login', $login)->first();
            if($usr != null)
                if (strcmp($usr->token, $token) == 0)
                    return redirect('/profile');
        }
        return $next($request);
    }
}