<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Exceptions\UnauthorizedException;

class Permission
{
    // 菜单缓存key
    const MENU_CACHE_KEY = 'current_user_menus';

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
        $user = auth('admin')->user();
        $menus = $this->cacheMenus();
        view()->share(self::MENU_CACHE_KEY, $menus);
        if (isset($action['as'])) {
            if (!$user->can($action['as']) && !config('permission.debug')) {
                throw UnauthorizedException::forPermissions([$action['as']]);
            }
            $current_permission = \App\Models\Permission::query()->where('name', $action['as'])->first();
            view()->share('current_permission', $current_permission);
            return $next($request);
        }
        return $next($request);
    }

    protected function cacheMenus()
    {
        $key = self::MENU_CACHE_KEY;
        if (session()->has($key)) {
            $list = session($key);
        } else {
            if (config('permission.debug')) {
                $list = Menu::query()->with('parent')->get();
            } else {
                $urls = auth('admin')->user()->getAllPermissions()->pluck('name');
                $list = Menu::query()->whereIn('url', $urls)->with('parent')->get();
                foreach ($list as $item) {
                    if ($item->pid && $list->where('id', $item->pid)->count() == 0) {
                        $list->push($item->parent);
                    }
                }
            }
            session([$key => $list]);
        }
        $menus = [];
        foreach ($list->where('pid', 0)->sortBy('sort')->all() as $item) {
            $menu = $this->getMenu($list, $item);
            if ($menu['active']) {
                view()->share('current_menu', $menu);
            }
            array_push($menus, $menu);
        }
        return $menus;
    }

    protected function getMenu($list, Menu $item)
    {
        $menu = [
            'id' => $item->id,
            'text' => $item->name,
            'icon' => $item->key?:'fa fa-list',
            'active' => false,
            'description' => $item->description
        ];
        $current_url = url()->current();
        if (!$item->url) {
            $children = [];
            $active = false;
            foreach ($list->where('pid', $item->id)->sortBy('sort')->all() as $item1) {
                $children_menu = $this->getMenu($list, $item1);
                if ($children_menu['active']) {
                    $active = true;
                }
                array_push($children, $children_menu);
            }
            $menu['active'] = $active;
            $menu['children'] = $children;
        } else {
            $url = $item->url;
            if (str_contains($url, '.')) {
                $url = route($url);
            } else {
                $url = url($url);
            }
            if (starts_with($current_url .'/', $url.'/')) {
                $menu['active'] = true;
            }
            $menu['url'] = $url;
            $menu['urlType'] = 'absolute';
            $menu['targetType'] = 'iframe-tab';
        }

        return $menu;
    }
}
