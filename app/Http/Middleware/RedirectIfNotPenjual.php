<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotPenjual
{
public function handle(Request $request, Closure $next): mixed
{
    if (!Auth::guard('penjual')->check()) {
        logger('❌ Guard penjual tidak login. Session hilang atau expired.');
        return redirect()->route('penjual.login');
    }

    logger('✅ Penjual login: ' . Auth::guard('penjual')->id());

    return $next($request);
}



}
