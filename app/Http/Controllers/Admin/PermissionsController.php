<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\MenuResource;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class PermissionsController extends Controller
{
    public function index()
    {
        $list = Permission::get();

        return view('admin.permission.index', compact('list'));
    }

    public function create()
    {
        return view('admin.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            'display_name' => 'required'
        ],[
            'name.required' => 'key 值必填',
            'name.unique' => 'key 值 :input 已经存在'
        ]);

        Permission::create($request->all());

        return redirect(route('admin.permission.index'));
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        $parent = PermissionResource::make($permission->parent);

        $menu = MenuResource::make($permission->menu);

        return view('admin.permission.edit', compact('permission', 'parent', 'menu'));
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $unique_rule = Rule::unique('permissions', 'name')->ignore($permission->id, 'id');

        $request->validate([
            'name' => ['required', $unique_rule],
            'display_name' => 'required'
        ],[
            'name.required' => 'key 值必填',
            'name.unique' => 'key 值 :input 已经存在'
        ]);


        $permission->update($request->all());

        return redirect(route('admin.permission.index'))->with('flash_message', '修改成功');
    }

    public function destroy($id)
    {
        $permission = Permission::with('children')->findOrFail($id);
        // 权限子级
        $permissions = $permission->children->push($permission);

        $permission->users->map(function ($item) use ($permissions) {
            $item->revokePermissionTo($permissions);
        });

        $permission->roles->map(function ($item) use ($permissions) {
            $item->revokePermissionTo($permissions);
        });

        $permission->children()->delete();
        $permission->delete();

        return redirect(route('admin.permission.index'))->with('flash_message', '删除成功');
    }
}
