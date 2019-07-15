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

    protected function redirect($uri, $params = [], $message = '')
    {
        $params = array_merge($this->getFilters(), $params);
        $uri = str_contains($uri, '.') ? $uri : $this->getPrefix().'.'.$uri;

        $response = redirect()->route($uri, $params);

        if ($message) {
            $response->with('flash_message', $message);
        }
        return $response;
    }

    public function create()
    {
        return method_exists($this, 'view') ? $this->view('create') : view($this->getPrefix().'.create');
    }

    public function store(Request $request)
    {
        $model = $this->getModel();

        $model->create($request->all());

        if ($request->ajax()) {
            return $this->success([], '添加成功');
        }

        return $this->redirect('index', [], '添加成功');
    }

    public function show($id)
    {
        $model = $this->getModel();
        $info = $model->findOrFail($id);
        
        return method_exists($this, 'view') ? $this->view('show', compact('info')) : view($this->getPrefix().'.show', compact('info'));
    }

    public function edit($id)
    {
        $model = $this->getModel();

        $info = $model->findOrFail($id);

        return method_exists($this, 'view') ? $this->view('edit', compact('info')) : view($this->getPrefix().'.edit', compact('info'));
    }

    public function update(Request $request, $id)
    {
        $model = $this->getModel();

        $info = $model->findOrFail($id);

        $info->update($request->all());

        if ($request->ajax()) {
            return $this->success([], '修改成功');
        }

        return $this->redirect('index', [], '修改成功');
    }

    public function destroy($id, Request $request)
    {
        $model = $this->getModel();

        $info = $model->findOrFail($id);

        $info->delete();

        if ($request->ajax()) {
            return $this->success([], '删除成功');
        }

        return $this->redirect('index', [], '删除成功');
    }
}
