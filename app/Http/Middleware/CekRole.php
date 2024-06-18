<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;



class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        //cek apakah di dalam array $roles (parameter)
        //yang dikirim dari route tadi terdapat role yang dimiliki user yang login
        //kalau ya bolh akses
        if(in_array(Auth::user()->role, $roles)){
            return $next($request);
        }
        return response()->json([
            'message'=>'Anda tidak berhak untuk mwngakses halaman ini',
        ]);
    }
}
