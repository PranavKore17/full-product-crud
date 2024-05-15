<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AlreadyLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(Session()->has('id') && (url('/')==$request->url() || url('registration')==$request->url())){ // if user is not logged in then redirect it to login page
            return back();

        // if(!Session()->has('loginId')){
        //     return redirect()->route('login')->with('fail','You have to login first');

        }
        return $next($request);
    }
}
