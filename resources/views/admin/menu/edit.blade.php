@extends('admin.layouts.iframe')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="javascript:history.back()" class="btn btn-default"> 返回</a>
    </div>

    <div class="box-body">
        <form action="{{route('admin.menu.update', $menu)}}" class="form-horizontal validate" method="post">
            {{csrf_field()}}
            {{method_field('put')}}
            <div class="form-group">
                <label for="inputName" class="control-label col-md-2">名称*</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="name" id="inputName" value="{{$menu->name}}" data-rule-required="true">
                </div>
            </div>
            <div class="form-group">
                <label for="selectPid" class="control-label col-md-2">上级</label>
                <div class="col-md-8">
                    <select name="pid" class="form-control" id="selectPid" data-ajax-url="{{route('api.web.menu')}}">
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputUrl" class="control-label col-md-2">链接</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="url" id="inputUrl" value="{{$menu->url}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputKey" class="control-label col-md-2">key</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="key" id="inputKey" value="{{$menu->key}}">
                    <span class="help-block">编辑图标, 例如: fa fa-edge, <a href="https://adminlte.io/themes/AdminLTE/pages/UI/icons.html" target="_blank">查看全部图标</a></span>
                </div>
            </div>
            <div class="form-group">
                <label for="inputSort" class="control-label col-md-2">排序</label>
                <div class="col-md-8">
                    <input type="number" class="form-control" name="sort" value="{{$menu->sort}}" id="inputSort" data-rule-digits="true" data-rule-min="0">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-2">
                    <button type="submit" class="btn btn-primary">提交</button>
                    <a href="javascript:history.back()" class="btn btn-default"> 返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    $(function () {
        var item = JSON.parse('{!! json_encode($menu->parent) !!}');
        if (!item) {
            item = {id: 0, name: '无上级', key: 'fa fa-question'};
        }
        $('#selectPid').select2({
            placeholder: '请选择',
            allowClear: true,
            data: [item],
            dataType: 'json',
            ajax: {
                delay: 500,
                data: function (params) {
                    return {
                        name: params.term,
                        page: params.page || 1
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.data,
                        pagination: {
                            more: data.meta?data.meta.current_page < data.meta.last_page:false
                        }
                    };
                },
            },
            escapeMarkup: function (markup) { return markup; },
            templateResult: function (repo) {
                return repo.id?'<i class="'+repo.key+'"></i>'+'--'+repo.name:''
            },
            templateSelection: function (repo) {
                return repo.id?'<i class="'+repo.key+'"></i>'+'--'+repo.name:''
            }
        });
        if (item) {
            $('#selectPid').val([item.id]).trigger('change');
        }
    })
</script>
@endsection