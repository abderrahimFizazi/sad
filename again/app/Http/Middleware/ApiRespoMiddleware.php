<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ApiRespoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(auth()->user()->tokenCan('server:respo') || auth()->user()->tokenCan('server:admin')){
                return $next($request);
            }
            else{
                return response()->Json([
                    'status' => 403,
                    'message'=> 'Access denied as you are not a responsable'
                ]);
            }
        }
        else{
            return response()->Json([
                'status' => 401,
                'message'=> 'Please Log in First'
            ]);
        }
    }
}