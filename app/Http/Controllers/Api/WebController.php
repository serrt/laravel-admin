<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\KeywordsResource;
use App\Http\Resources\KeywordsTypeResource;
use App\Http\Resources\MenuResource;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RegionResource;
use App\Http\Resources\RoleResource;
use App\Models\Keywords;
use App\Models\KeywordsType;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\Region;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Storage;

class WebController extends Controller
{
    public function upload(Request $request)
    {
        $files = $request->file();
        $path = $request->input('path', 'uploads/'.date('Y-m-d'));
        $result = [];
        foreach ($files as $key => $fileData) {
            $item = null;
            if (is_array($fileData)) {
                foreach ($fileData as $file) {
                    $savePath = $file->store($path);
                    $item[] = Storage::url($savePath);
                }
            } else {
                $savePath = $fileData->store($path);
                $item = Storage::url($savePath);
            }
            $result[$key] = $item;
        }
        return $this->json($result);
    }

    public function city(Request $request)
    {
        $query = Region::with('parent');

        if ($request->filled('name') || $request->filled('key')) {
            $query->where('name', 'like', '%' . $request->input('name', $request->input('key')) . '%');
        }

        if ($request->filled('level')) {
            $query->where('level', $request->input('level'));
        }

        $list = $query->paginate();
        return RegionResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    public function permission(Request $request)
    {
        $query = Permission::query();

        if ($request->filled('name')) {
            $query->where('display_name', 'like', '%' . $request->input('display_name') . '%');
        }

        if ($request->filled('pid')) {
            $query->where('pid',  $request->input('pid'));
        }

        $list = $query->paginate();

        return PermissionResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    public function menu(Request $request)
    {
        $query = Menu::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('pid')) {
            $query->where('pid',  $request->input('pid'));
        }

        $list = $query->paginate();

        return MenuResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    public function role(Request $request)
    {
        $query = Role::query();

        if ($request->filled('key')) {
            $query->where('display_name', 'like', '%' . $request->input('key') . '%');
        }

        $list = $query->paginate();

        return RoleResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    public function keywordsType(Request $request)
    {
        $query = KeywordsType::query();

        if ($request->filled('key')) {
            $name = $request->input('key');
            $query->where(function ($query) use ($name) {
                $query->where('name', 'like', '%'.$name.'%');
                $query->orWhere('key', 'like', '%'.$name.'%');
            });
        }

        if ($request->filled('id')) {
            $query->where('id', $request->input('id'));
        }

        $list = $query->paginate();

        return KeywordsTypeResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    public function keywords(Request $request)
    {
        $query = Keywords::query();

        if ($request->filled('key')) {
            $name = $request->input('key');
            $query->where(function ($query) use ($name) {
                $query->where('name', 'like', '%'.$name.'%');
                $query->orWhere('key', 'like', '%'.$name.'%');
            });
        }

        if ($request->filled('type')) {
            $query->where('type_id', $request->input('type'));
        }
        if ($request->filled('type_key')) {
            $type_key = $request->input('type_key');
            $query->where('type_key', $type_key);
        }

        $list = $query->paginate();

        return KeywordsResource::collection($list)->additional(['code' => Response::HTTP_OK, 'message' => '']);
    }

    /**
     * 验证是否唯一
     *
     * @param $table string 验证的数据表名, 必填
     * @param $ignore string 需要忽略的值, 选填
     * @param $unique string 验证的数据表列名, 默认: id
     * @param $ignore_column string 需要忽略的key, 默认: id
     */
    public function unique(Request $request)
    {
        $request->validate([
            'table' => 'required',
        ], [
            'table.required' => 'table 参数必填',
        ]);

        $column = $request->input('unique', 'id');
        $table = $request->input('table');

        $unique_rule = Rule::unique($table, $column);
        if ($request->filled('ignore')) {
            $unique_rule->ignore($request->input('ignore'), $request->input('ignore_column', 'id'));
        }
        $request->validate([
            $column => ['required', $unique_rule]
        ], [
            $column.'.unique' => ':input 已经存在'
        ]);

        return $this->success();
    }
}
