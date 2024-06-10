<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
 // AdminMiddleware
     public function handle(Request $request, Closure $next)
     {
         if (Auth::check() && Auth::user()->role_id == 1) { // Assuming '1' is the ID for 'admin' role
             return $next($request);
         }
 
         return response()->json(['message' => 'Unauthorized'], 403);
     }
 }