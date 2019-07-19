<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\RegionResource;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\Permission;
use Cache;
use Session;

class IndexController extends Controller
{
    /**
     * 后台入口
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index.home');
    }

    public function refresh()
    {
        // 清除权限缓存
        Cache::forget('spatie.permission.cache');

        // 清除菜单缓存
        Session::forget(Permission::MENU_CACHE_KEY);

        return back()->with('flash_message', '清除成功');
    }

    public function table(Request $request)
    {
        $query = Region::query()->with('parent');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        $region = null;
        if ($request->filled('pid')) {
            $pid = $request->input('pid');
            $region = RegionResource::make(Region::query()->findOrFail($pid));
            $query->where('pid', $pid);
        }

        $list = $query->paginate();
        return view('admin.index.table', compact('list', 'region'));
    }

    public function form()
    {
        $img_url = 'https://qiniu.abcdefg.fun/act-pic3.png';
        $imgs_url = 'https://qiniu.abcdefg.fun/act-pic3.png,http://qiniu.abcdefg.fun/act-pic4.png';
        $video_url = 'https://qiniu.abcdefg.fun/mp4-1.mp4,https://qiniu.abcdefg.fun/mp3-1.mp3';

        $city = RegionResource::make(Region::query()->where('level', 1)->first());
        $cities = RegionResource::collection(Region::query()->where('level', 1)->limit(3)->get());
        return view('admin.index.form', compact('img_url', 'imgs_url', 'city', 'cities', 'video_url'));
    }

    public function ajax()
    {
        if (!session()->has('imgs_url')) {
            session(['imgs_url' => ['https://qiniu.abcdefg.fun/act-pic3.png', 'https://qiniu.abcdefg.fun/act-pic4.png']]);
        }
        $imgs_url = session()->get('imgs_url');
        return view('admin.index.ajax', compact('imgs_url'));
    }

    public function upload(Request $request)
    {
        dd($request->all());
        $imgs_url = session()->get('imgs_url');

        // 上传新文件
        if ($request->hasFile('file')) {
            $path = $request->input('path', 'file-input/'.date('Y-m-d'));
            $file_url = Storage::url($request->file('file')->store($path));

            array_push($imgs_url, $file_url);
        }

        // 删除已有的文件
        if ($request->has('key')) {
            $key = $request->input('key');
            if (isset($imgs_url[$key])) {
                unset($imgs_url[$key]);
            }
        }

        // 排序文件
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $new = [];
            foreach ($sort as $key) {
                $new[$key] = $imgs_url[$key];
            }
            $imgs_url = $new;
        }

        session(['imgs_url' => $imgs_url]);
        return $this->json($imgs_url);
    }
}
