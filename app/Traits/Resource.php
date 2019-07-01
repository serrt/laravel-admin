<?php

namespace App\Traits;

use App\Http\Middleware\QueryFilter;
use Illuminate\Http\Request;

trait Resource
{
    protected function getPrefix()
    {
        $string = request()->route()->action['as'];

        $ext = explode('.', $string);

        array_pop($ext);

        return implode('.', $ext);
    }

    protected function getFilters()
    {
        $filters = session(QueryFilter::getKey(request()->route()->action['as']));

        return $filters;
    }

    public function create()
    {
        return view($this->getPrefix().'.create');
    }

    public function store(Request $request)
    {
        $model = $this->getModel();

        $model->create($request->all());

        return redirect()->route($this->getPrefix().'.index', $this->getFilters())->with('flash_message', '添加成功');
    }

    public function show($id)
    {
        $model = $this->getModel();
        $info = $model->findOrFail($id);
        
        return view($this->getPrefix().'.show', compact('info'));
    }

    public function edit($id)
    {
        $model = $this->getModel();

        $info = $model->findOrFail($id);

        return view($this->getPrefix().'.edit', compact('info'));
    }

    public function update(Request $request, $id)
    {
        $model = $this->getModel();

        $info = $model->findOrFail($id);

        $info->update($request->all());

        return redirect()->route($this->getPrefix().'.index', $this->getFilters())->with('flash_message', '修改成功');
    }

    public function destroy($id)
    {
        $model = $this->getModel();

        $info = $model->findOrFail($id);

        $info->delete();

        return redirect()->route($this->getPrefix().'.index', $this->getFilters())->with('flash_message', '删除成功');
    }
}
