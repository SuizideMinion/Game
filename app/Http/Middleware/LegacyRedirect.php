<?php

namespace App\Http\Middleware;

use Closure;

class LegacyRedirect
{
    public function handle($request, Closure $next)
    {
        // Prüfen, ob die URL zum Legacy-Code gehört
        if (strpos($request->path(), 'legacy') !== false) {
            return redirect('/legacy/' . $request->path());
        }

        return $next($request);
    }
}
