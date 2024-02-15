<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use illuminate\Support\Str;

class SetSanctumGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Str::startsWith($request->getRequestUri(), '/api/adm')){
            config(['sanctun.guard' => 'adms']);
        }else{
            return 'sem guard';

        }elseif(Str::startsWith($request->getRequestUri(), '/api/clientes')){
            config(['sanctum.guard' => 'clientes']);
        }
        return $next($request);
    }
}
