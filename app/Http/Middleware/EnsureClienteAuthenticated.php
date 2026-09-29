<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureClienteAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('cliente')) {
            return redirect()->route('tienda.login');
        }

        return $next($request);
    }
}
