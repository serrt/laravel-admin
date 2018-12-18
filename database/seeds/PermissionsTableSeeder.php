<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use App\Models\AdminUser;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 清空权限缓存
        app()['cache']->forget('spatie.permission.cache');

        // 清空已有的权限
        $tableNames = config('permission.table_names');
        foreach ($tableNames as $key=>$value) {
            DB::table($value)->truncate();
        }

        // 获取路由上的所有路由
        $route_list = app('router')->getRoutes()->getRoutes();
        $data = [];
        foreach ($route_list as $item) {
            $action = $item->action;
            // 路由必须命名
            if (!isset($action['as'])) {
                continue;
            }
            // 取出admin下面的路由
            if (strpos($action['prefix'], 'admin') !== false) {
                $ext = explode('.', $action['as']);
                // 仅限3级
                if (count($ext) == 3) {
                    $num1 = $ext[0];
                    $num2 = $ext[0].'.'.$ext[1];
                    $num3 = $action['as'];
                    $data[$num1][$num2][] = $num3;
                }
            }
        }

        // 所有的菜单
        $menus = \App\Models\Menu::query()->pluck('id', 'url')->toArray();

        $index1 = 1;
        $guard = 'admin';
        $permissions = collect();
        foreach ($data['admin'] as $key1 => $item1) {
            $permission = Permission::create([
                'guard_name' => 'admin',
                'name' => $key1,
                'display_name' => __('permission.'.$key1),
                'pid' => 0,
                'menu_id' => isset($menus[$key1])?$menus[$key1]:null,
            ]);
            $index1++;
            $index2=1;
            $permissions->push($permission);
            foreach ($item1 as $value) {
                $explode_value = explode('.',$value);
                $need_trans = 'permission.'.$explode_value[2];
                $trans = __($need_trans);
                if ($trans == $need_trans) {
                    $trans = __('permission.'.$value);
                }
                $tran = $trans.'-'.$permission->display_name;
                $sub_permission = Permission::create([
                    'guard_name' => $guard,
                    'name' => $value,
                    'display_name' => $tran,
                    'pid' => $permission->id,
                    'menu_id' => isset($menus[$value])?$menus[$value]:null,
                ]);
                $index2++;
                $permissions->push($sub_permission);
            }
        }
        $role = Role::query()->updateOrCreate(['name'=>'administer'], ['guard_name' => $guard, 'display_name' => '超级管理员']);
        $role->givePermissionTo($permissions);

        $user = AdminUser::first();
        $user->assignRole($role);
    }
}
