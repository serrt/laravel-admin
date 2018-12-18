@extends('admin.layouts.iframe')
@section('content')
    <div class="box">
        <div class="box-header with-border">
            <form action="" class="form-horizontal" autocomplete="off">
                <div class="form-group">
                    <div class="col-md-2 control-label">用户名</div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="name" value="{{request('name')}}" placeholder="登录名/姓名">
                    </div>
                    <label for="select2" class="col-md-2 control-label">角色</label>
                    <div class="col-md-2">
                        <select name="role" class="form-control" id="select2" data-ajax-url="{{route('api.web.role')}}">
                            <option value="">全部</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        <a href="{{route('admin.user.create')}}" class="btn btn-default"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="box-body table-responsive" style="min-height: 350px;">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>登陆名</th>
                    <th>姓名</th>
                    <th>角色</th>
                    <th>创建时间</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $item)
                    <tr>
                        <td>{{$item->id}}</td>
                        <td>
                            <a href="{{route('admin.user.edit', $item)}}" class="btn-link">{{$item->username}}</a>
                        </td>
                        <td>{{$item->name}}</td>
                        <td>
                            {{$item->roles->count()?$item->roles->implode('name', ','):''}}
                        </td>
                        <td>{{$item->created_at}}</td>
                        <td>
                            <a href="{{route('admin.user.show', $item)}}" class="btn btn-info btn-sm">详细</a>
                            <a href="{{route('admin.user.edit', $item)}}" class="btn btn-bitbucket btn-sm">修改</a>
                            <button type="submit" form="delForm{{$item->id}}" class="btn btn-danger btn-sm" title="删除" onclick="return confirm('是否确定？')">删除</button>
                            <form class="form-inline hide" id="delForm{{$item->id}}" action="{{ route('admin.user.destroy', $item) }}" method="post">
                                {{ csrf_field() }} {{ method_field('DELETE') }}
                            </form>
                            <a href="{{route('admin.user.role', $item)}}" class="btn btn-default btn-sm">修改角色</a>
                            <a href="{{route('admin.user.permission', $item)}}" class="btn btn-warning btn-sm">修改权限</a>
                            <a href="{{route('admin.user.menu', $item->id)}}" class="btn btn-success btn-sm">修改菜单</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="box-footer clearfix">
            {{$list->appends(request()->all())->links()}}
        </div>
    </div>
@endsection
@section('script')
<script>
    $(function () {
        var item = {!! json_encode($role) !!}
        $('#select2').select2({
            allowClear: true,
            placeholder: '请选择',
            data: [item],
            dataType: 'json',
            width: '100%',
            ajax: {
                delay: 500,
                data: function (params) {
                    return {
                        key: params.term,
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
                return repo.text?repo.text:repo.name
            },
            templateSelection: function (repo) {
                return repo.text?repo.text:repo.name
            }
        });
        // 初始化 select2
        if (item) {
            $('#select2').val([item.id]).trigger('change');
        }
    })
</script>
@endsection