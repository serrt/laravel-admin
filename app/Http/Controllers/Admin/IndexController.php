<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\RegionResource;
use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    /**
     * 后台入口
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.index.home');;
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
        $img_url = 'http://qiniu.abcdefg.fun/act-pic3.png';
        $imgs_url = 'http://qiniu.abcdefg.fun/act-pic3.png,http://qiniu.abcdefg.fun/act-pic4.png';
        return view('admin.index.form', compact('img_url', 'imgs_url'));
    }

    public function ajax()
    {
        $imgs_url = 'http://qiniu.abcdefg.fun/act-pic3.png,http://qiniu.abcdefg.fun/act-pic4.png';
        return view('admin.index.ajax', compact('imgs_url'));
    }

    public function formUpload(Request $request)
    {
        // 获取上传的文件
        $file = $request->file('file');
        if ($file) {
            // 保存文件
            $file = $file->store('uploads');
            // 获取文件全路径
            $fileUrl = Storage::url($file);
            dump($fileUrl);
        }
    }
}
