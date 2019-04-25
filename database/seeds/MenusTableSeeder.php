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
                ['name' => 'element', 'key' => 'fa fa-newspaper-o', 'url' => 'admin.index.form'],
                ['name' => 'ajax', 'key' => 'fa fa-pencil-square', 'url' => 'admin.index.ajax']
            ]],
            ['name' => '系统', 'key' => 'fa fa-gear', 'url' => null, 'children' => [
                ['name' => '菜单', 'key' => 'fa fa-list', 'url' => 'admin.menu.index'],
                ['name' => '角色', 'key' => 'fa fa-user-secret', 'url' => 'admin.role.index'],
                ['name' => '权限', 'key' => 'fa fa-battery-full', 'url' => 'admin.permission.index'],
                ['name' => '管理员', 'key' => 'fa fa-users', 'url' => 'admin.admin_user.index']
            ]],
            ['name' => '网站', 'pid' => 0, 'key' => 'fa fa-globe', 'url' => null, 'children' => [
                ['name' => '字典类型', 'key' => 'fa fa-key', 'url' => 'admin.keywords_type.index'],
                ['name' => '字典', 'key' => 'fa fa-key', 'url' => 'admin.keywords.index'],
            ]]
        ];
        $list = $this->getMenu($menus, 0);

        DB::table('menus')->truncate();
        DB::table('menus')->insert($list);
    }

    protected $index = 1;
    protected function getMenu($list, $pid = 0)
    {
        $data = [];
        foreach ($list as $key => $item) {
            $menu = $item;
            $menu['id'] = $this->index;
            $this->index++;
            $menu['pid'] = $pid;
            $menu['sort'] = $key + 1;
            $menu['permission_name'] = data_get($item, 'permission_name', $menu['url']);
            unset($menu['children']);
            array_push($data, $menu);
            if (isset($item['children'])) {
                $children = $this->getMenu($item['children'], $menu['id']);
                $data = array_merge($data, $children);
            }
        }
        return $data;
    }
}
