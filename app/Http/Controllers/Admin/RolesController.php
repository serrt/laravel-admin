<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::query();

        if ($request->filled('key')) {
            $key = $request->input('key');
            $query->where(function ($query) use ($key) {
                $query->where('display_name', 'like', '%'.$key.'%');
                $query->orWhere('name', 'like', '%'.$key.'%');
            });
        }

        $list = $query->paginate();

        return view('admin.role.index', compact('list'));
    }

    public function create()
    {
        $list = Permission::get();

        return view('admin.role.create', compact('list'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'display_name' => 'required'
        ]);

        $role = Role::create($request->all());
        $role->givePermissionTo($request->input('permissions'));

        return redirect(route('admin.role.index'))->with('flash_message', '添加成功');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('admin.role.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $role->update($request->all());

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->input('permissions'));
        }

        return redirect(route('admin.role.index'))->with('flash_message', '修改成功');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        // 删除关联的 role_permissions
        $role->permissions()->detach();

        $role->delete();

        return back()->with('flash_message', '删除成功');
    }

    public function permission($id)
    {
        $role = Role::findOrFail($id);

        $permissions = Permission::get();

        return view('admin.role.permission', compact('role', 'permissions'));
    }
}
