<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            ['name' => '首页', 'key' => 'fa fa-home', 'url' => 'admin.index.index'],
            ['name' => '表格', 'key' => 'fa fa-table', 'url' => 'admin.index.table'],
            ['name' => '表单', 'key' => 'fa fa-edit', 'url' => null, 'children' => [
                ['name' => '基本表单', 'key' => 'fa fa-newspaper-o', 'url' => 'admin.index.form'],
                ['name' => 'ajax', 'key' => 'fa fa-pencil-square', 'url' => 'admin.index.ajax']
            ]],
            ['name' => '系统', 'key' => 'fa fa-gear', 'url' => null, 'children' => [
                ['name' => '菜单', 'key' => 'fa fa-list', 'url' => 'admin.menu.index'],
                ['name' => '角色', 'key' => 'fa fa-user-secret', 'url' => 'admin.role.index'],
                ['name' => '权限', 'key' => 'fa fa-battery-full', 'url' => 'admin.permission.index'],
                ['name' => '管理员', 'key' => 'fa fa-users', 'url' => 'admin.user.index']
            ]],
            ['name' => '网站', 'pid' => 0, 'key' => 'fa fa-globe', 'url' => null, 'children' => [
                ['name' => '字典类型', 'key' => 'fa fa-key', 'url' => 'admin.keywords_type.index'],
                ['name' => '字典', 'key' => 'fa fa-key', 'url' => 'admin.keywords.index']
            ]],
        ];
        $data = [];
        $user_menu = [];
        $user_id = \App\Models\AdminUser::first()->id;
        $index = 1;
        foreach ($menus as $key => $item) {
            $menu = $item;
            $menu['id'] = $index;
            $index++;
            $menu['pid'] = 0;
            $menu['sort'] = $key+1;
            unset($menu['children']);
            array_push($data, $menu);
            array_push($user_menu, ['user_id'=>$user_id, 'menu_id'=>$menu['id']]);

            if (isset($item['children'])) {
                foreach ($item['children'] as $key1 => $item1) {
                    $menu1 = $item1;
                    $menu1['id'] = $index;
                    $index++;
                    $menu1['pid'] = $menu['id'];
                    $menu1['sort'] = $key1+1;
                    array_push($data, $menu1);
                    array_push($user_menu, ['user_id'=>$user_id, 'menu_id'=>$menu1['id']]);
                }
            }
        }
        DB::table('menus')->truncate();
        DB::table('user_menus')->truncate();
        DB::table('menus')->insert($data);
        DB::table('user_menus')->insert($user_menu);
        // 清空菜单缓存
        Cache::forget(\App\Http\Middleware\Permission::MENU_CACHE_KEY);
    }
}
