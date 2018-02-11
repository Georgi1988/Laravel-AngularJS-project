<?php

namespace App\Http\Middleware;

use App;
use Closure;
use mProvider;

class LocaleMiddleware
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
		if ($request->session()->has('site_local')) {
			$locale = $request->session()->get('site_local');
			App::setLocale($locale);
		} else {
			$locale = App::getLocale();
		}

		view()->share('locale', $locale);
		
		if (null !== $request->session()->get('site_priv')) {
			mProvider::$user_priv = $request->session()->get('site_priv');

			$login_info = $request->session()->get('total_info');

			mProvider::$dealer_level = $login_info['dealer_id'];
			mProvider::$view_prefix_priv = $request->session()->get('site_priv').".";
		}

		view()->share('user_priv', mProvider::$user_priv);

        return $next($request);
    }
}
