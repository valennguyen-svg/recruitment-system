<?php

namespace App\Http\Middleware;

use App\Constants\LocaleConstants;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get(
            LocaleConstants::SESSION_KEY,
            config('app.locale'),
        );

        if (in_array($locale, LocaleConstants::SUPPORTED, true)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
