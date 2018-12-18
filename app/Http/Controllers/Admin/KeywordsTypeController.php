<?php

namespace App\Http\Controllers\Admin;

use App\Models\KeywordsType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Validator;

class KeywordsTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = KeywordsType::query();

        if ($request->filled('key')) {
            $name = $request->input('key');
            $query->where(function ($query) use ($name) {
                $query->where('name', 'like', '%'.$name.'%');
                $query->orWhere('key', 'like', '%'.$name.'%');
            });
        }

        $list = $query->paginate();

        return view('admin.keywords_type.index', compact('list'));
    }

    public function create()
    {
        return view('admin.keywords_type.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:keywords_type,key',
            'name' => 'required'
        ]);

        $type = new KeywordsType();
        $type->key = $request->input('key');
        $type->name = $request->input('name');
        $type->save();

        return redirect(route('admin.keywords_type.index'))->with('flash_message', '添加成功');
    }

    public function edit($id)
    {
        $type = KeywordsType::findOrFail($id);

        return view('admin.keywords_type.edit', compact('type'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'key' => ['required', Rule::unique('keywords_type', 'key')->ignore($id, 'id')],
            'name' => 'required',
        ]);
        $type = KeywordsType::findOrFail($id);
        $type->key = $request->input('key');
        $type->name = $request->input('name');

        $type->save();

        return redirect(route('admin.keywords_type.index'))->with('flash_message', '修改成功');
    }

    public function destroy($id)
    {
        $type = KeywordsType::findOrFail($id);

        $type->keywords()->delete();

        $type->delete();

        return redirect(route('admin.keywords_type.index'))->with('flash_message', '删除成功');
    }

    public function checkType(Request $request)
    {
        $unique_rule = Rule::unique('keywords_type', 'key');
        if ($request->filled('ignore')) {
            $unique_rule->ignore($request->input('ignore'), 'key');
        }
        $validate = Validator::make($request->all(), [
            'key' => ['required', $unique_rule]
        ]);

        $exists = $validate->fails();

        return $this->json([], $exists?Response::HTTP_BAD_REQUEST:Response::HTTP_OK, $exists?$validate->errors('key')->first():'');
    }
}
