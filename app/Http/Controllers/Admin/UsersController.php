<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\RoleResource;
use App\Models\AdminUser;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;
use App\Http\Middleware\Permission as PermissionMiddleware;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = AdminUser::query()->with('roles');

        if ($request->filled('name')) {
            $name = $request->input('name');
            $query->where(function ($query) use ($name) {
                $query->where('name', 'like', '%'.$name.'%');
                $query->orWhere('username', 'like', '%'.$name.'%');
            });
        }

        $role = null;
        if ($request->filled('role')) {
            $role_id = $request->input('role');
            $role = Role::find($role_id);
            $query->whereHas('roles', function ($query) use ($role_id) {
                $query->where('role_id', $role_id);
            });
        }

        $list = $query->paginate();

        return view('admin.user.index', compact('list', 'role'));
    }

    public function show($id)
    {
        $user = AdminUser::findOrFail($id);
        $user_permissions = $user->getAllPermissions();
        $user_roles = $user->roles;
        return view('admin.user.show', compact('user', 'user_permissions', 'user_roles'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admin_users,username',
            'password' => 'required'
        ]);

        $user = new AdminUser();
        $user->username = $request->input('username');
        $user->name = $request->input('name');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $user->syncRoles($request->input('roles'));

        return redirect(route('admin.user.index'))->with('flash_message', '添加成功');
    }

    public function edit($id)
    {
        $user = AdminUser::with('roles')->findOrFail($id);


        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = AdminUser::findOrFail($id);
        if ($request->filled('username')) {
            $request->validate([
                'username' => ['required', Rule::unique('admin_users', 'username')->ignore($id, 'id')],
            ]);
            $user->username = $request->input('username');
            $user->name = $request->input('name');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }
            $user->save();
        }

        // 更新角色
        if ($request->filled('roles')) {
            $user->syncRoles($request->input('roles'));
            // if (auth('admin')->id() == $user->id) {
            //     // 清空权限缓存
            //     Cache::forget('spatie.permission.cache');
            // }
        }

        // 更新权限
        if ($request->filled('permissions')) {
            $user->syncPermissions($request->input('permissions'));
            if (auth('admin')->id() == $user->id) {
                // 清空权限缓存
                Cache::forget('spatie.permission.cache');
            }
        }

        // 更新菜单
        if ($request->filled('menus')) {
            $user->menus()->sync($request->input('menus'));
            if (auth('admin')->id() == $user->id) {
                // 清空菜单缓存
                Cache::forget(PermissionMiddleware::MENU_CACHE_KEY);
            }
        }

        return redirect(route('admin.user.index'))->with('flash_message', '修改成功');
    }

    public function destroy($id)
    {
        $user = AdminUser::findOrFail($id);

        // 删除拥有的角色
        $user->roles()->detach();

        // 删除用户拥有的权限
        $user->revokePermissionTo($user->permissions);

        // 删除拥有的菜单
        $user->menus()->detach();

        $user->delete();

        return redirect(route('admin.user.index'))->with('flash_message', '删除成功');
    }

    public function role($id)
    {
        $user = AdminUser::findOrFail($id);

        $user_roles = RoleResource::collection($user->roles);

        return view('admin.user.role', compact('user', 'user_roles'));
    }

    public function permission($id)
    {
        $user = AdminUser::findOrFail($id);

        $permissions = Permission::get();

        $user_permissions = $user->permissions;

        return view('admin.user.permission', compact('user', 'user_permissions', 'permissions'));
    }

    public function menu($id)
    {
        $list = Menu::orderBy('sort')->orderBy('id')->get();

        $user = AdminUser::findOrFail($id);

        return view('admin.user.menu', compact('list', 'user'));
    }
}
