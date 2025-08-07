<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class LocalizationMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->hasHeader('Accept-Language')) {
            $lang = $request->header('Accept-Language');
            App::setLocale($lang);
        }
        return $next($request);
    }
}
