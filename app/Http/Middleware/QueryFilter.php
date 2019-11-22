<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class QueryFilter
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
        $action = $request->route()->action;
        $route_name = data_get($action, 'as');
        if ($route_name && ends_with($route_name, '.index') && $request->isMethod('get')) {
            $session_key = QueryFilter::getKey($route_name);
            $filters = array_merge(Session::get($session_key, []), $request->all());
            if (count($filters) > 0) {
                Session::put($session_key, $filters);
                foreach ($filters as $key => $value) {
                    $request->offsetSet($key, $value);
                }
            } else {
                Session::forget($session_key);
            }
        }
        return $next($request);
    }
    public static function getKey($route_name)
    {
        $explodes = explode('.', $route_name);
        array_pop($explodes);
        return 'query_'.implode('_', $explodes).'_index';
    }
}