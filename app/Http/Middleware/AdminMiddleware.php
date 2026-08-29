<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('login')->withErrors([
                'email' => 'Silakan masuk terlebih dahulu untuk mengakses halaman admin.',
            ]);
        }

        if (Auth::user()->role !== 'admin') {
            abort(Response::HTTP_FORBIDDEN, 'Akses ditolak. Anda tidak memiliki izin administrator.');
        }

        return $next($request);
    }
}
