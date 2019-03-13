<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\PermissionResource;
use App\Models\Menu;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenusController extends Controller
{
    public function index()
    {
        $list = Menu::orderBy('sort')->orderBy('id')->get();

        return view('admin.menu.index', compact('list'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = $request->all();

        if ($request->filled('permission_id')) {
            $data['permission_name'] = Permission::findOrFail($request->input('permission_id'))->name;
        }

        Menu::create($data);

        return redirect(route('admin.menu.index'));
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);

        $permission = null;
        if ($menu->permission_name) {
            $permission = PermissionResource::make($menu->permission);
        }

        return view('admin.menu.edit', compact('menu', 'permission'));
    }

    public function update(Request $request, $id)
    {
        $permission = Menu::findOrFail($id);

        $data = $request->all();
        $data['pid'] = $request->input('pid', 0);

        if ($request->filled('permission_id')) {
            $data['permission_name'] = Permission::findOrFail($request->input('permission_id'))->name;
        } else {
            $data['permission_name'] = null;
        }

        $permission->update($data);

        return redirect(route('admin.menu.index'))->with('flash_message', '修改成功');
    }

    public function destroy($id)
    {
        $menu = Menu::with('children')->findOrFail($id);

        // 删除子菜单
        $menu->children()->delete();

        // 删除菜单
        $menu->delete();

        return redirect(route('admin.menu.index'))->with('flash_message', '删除成功');
    }
}
