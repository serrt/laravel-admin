<?php

namespace App\Http\Middleware;

use App\Models\Menu;
use Closure;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use App\Models\Permission as PermissionModel;

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
        try {
            $action = $request->route()->action;
            $user = auth('admin')->user();
            $menus = $this->cacheMenus();
            view()->share(self::MENU_CACHE_KEY, $menus);
            if (isset($action['as'])) {
                if (!config('permission.debug') && !$user->can($action['as'])) {
                    throw UnauthorizedException::forPermissions([$action['as']]);
                }
                $current_permission = PermissionModel::findByName($action['as']);
                $current_permission->parent = PermissionModel::findById($current_permission->pid);
                view()->share('current_permission', $current_permission);
            }
        } catch (PermissionDoesNotExist $exception) {

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
                $list = Menu::query()->whereIn('permission_name', $urls)->with('parent')->get();
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
        $current_url = url()->full();
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
            if (starts_with($current_url, $url)) {
                $menu['active'] = true;
            }
            $menu['url'] = $url;
            $menu['urlType'] = 'absolute';
            $menu['targetType'] = 'iframe-tab';
        }

        return $menu;
    }
}
