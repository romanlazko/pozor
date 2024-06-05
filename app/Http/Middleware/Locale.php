<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;

class Locale {

    public function __construct(private Application $app, private Request $request) {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->app->setLocale(auth()?->user()?->locale ?? session('locale') ?? config('app.locale'));

        return $next($request);
    }

}