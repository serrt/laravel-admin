<?php

namespace App\Http\Middleware;

use Closure;

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
            session([$session_key => $request->all()]);
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
