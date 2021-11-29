<?php

namespace App\Http\Middleware;

use Closure;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            \App::setLocale(session()->get('locale'));
        } else {
            $default = \App\AdminSetting::first()->language;
            $dir = \App\Language::where('name',$default)->first()->direction;
            \App::setLocale($default);
            session()->put('direction', $dir);
            session()->put('locale', $default);
        }
        return $next($request);
    }
}
