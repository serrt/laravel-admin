<?php

namespace App\Http\Controllers\Admin;

use App\Http\Middleware\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * 重写登陆页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        // 登录成功后跳转回来源页面
        session(['login_redirect_to' => url()->previous()]);
        return view('admin.auth.login');
    }

    /**
     * 修改用户信息
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function profile(Request $request)
    {
        $user = Auth::user();

        $refresh = $request->filled('password');

        if ($request->filled('name')) {
            $user->name = $request->input('name');
        }

//        if ($request->filled('username')) {
//            $user->username = $request->input('username');
//        }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return $refresh?$this->logout($request):back();

    }

    public function username()
    {
        return 'username';
    }

    public function redirectTo()
    {
        // 登录成功后跳转回来源页面
        return session()->pull('login_redirect_to', '/');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    protected function loggedOut(Request $request)
    {
        // 清空权限缓存
        Cache::forget('spatie.permission.cache');
        // 清空菜单缓存
        Cache::forget(Permission::MENU_CACHE_KEY);
        return redirect(route('admin.login'));
    }
}
