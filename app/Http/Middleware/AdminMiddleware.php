<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            Log::info('Kullanıcı Rolü:', ['roles' => auth()->user()->getRoleNames()]);
        }

        if (auth()->check() && auth()->user()->hasRole('admin')) {
            return $next($request);
        }

        return redirect('/');
    }
}
