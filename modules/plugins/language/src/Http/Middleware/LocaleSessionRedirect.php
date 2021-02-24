<?php

namespace EG\Language\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Language;

class LocaleSessionRedirect extends LaravelLocalizationMiddlewareBase
{


    public function handle($request, Closure $next)
    {
        // If the URL of the request is in exceptions.
        if ($this->shouldIgnore($request)) {
            return $next($request);
        }

        $params = explode('/', $request->path());

        session(['language' => Language::getDefaultLocale()]);
        app()->setLocale(session('language'));

        if (count($params) > 0 && Language::checkLocaleInSupportedLocales($params[0])) {
            session(['language' => $params[0]]);

            app()->setLocale(session('language'));

            return $next($request);
        }

        $locale = session('language', false);

        if ($locale && Language::checkLocaleInSupportedLocales($locale) && !(Language::getDefaultLocale() === $locale && Language::hideDefaultLocaleInURL())) {
            app('session')->reflash();
            $redirection = Language::getLocalizedURL($locale);

            return new RedirectResponse($redirection, 302, ['Vary' => 'Accept-Language']);
        }

        return $next($request);
    }
}
