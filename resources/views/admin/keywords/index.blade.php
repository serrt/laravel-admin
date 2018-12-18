@extends('admin.layouts.iframe')

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <form action="" class="form-horizontal" autocomplete="off">
                <div class="form-group">
                    <label for="selectType" class="col-md-2 control-label">类型</label>
                    <div class="col-md-2">
                        <select name="type" id="selectType" class="form-control select2" data-json="{{json_encode($type)}}" data-ajax-url="{{route('api.web.keywords_type')}}">
                        </select>
                    </div>
                    <div class="col-md-2 control-label">关键字</div>
                    <div class="col-md-2">
                        <input type="text" class="form-control" name="key" value="{{request('key')}}" placeholder="key/名称">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4 pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        <a href="{{route('admin.keywords.create')}}" class="btn btn-default"><i class="fa fa-plus"></i> 添加</a>
                    </div>
                </div>
            </form>
        </div>

        <div class="box-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th>类型</th>
                    <th>key</th>
                    <th>名称</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($list as $item)
                    <tr>
                        <td>
                            <a href="{{route('admin.keywords.create', ['type'=>$item->type])}}" class="btn-link" title="添加">{{$item->keyType->name}}</a>
                        </td>
                        <td>{{$item->key}}</td>
                        <td>
                            <a href="{{route('admin.keywords.edit', $item)}}" title="修改" class="btn-link">{{$item->name}}</a>
                        </td>
                        <td>
                            <a href="{{route('admin.keywords.edit', $item)}}" class="btn btn-info btn-sm">修改</a>
                            <button type="submit" form="delForm{{$item->id}}" class="btn btn-default btn-sm" title="删除" onclick="return confirm('是否确定？')">删除</button>
                            <form class="form-inline hide" id="delForm{{$item->id}}" action="{{ route('admin.keywords.destroy', $item) }}" method="post">
                                {{ csrf_field() }} {{ method_field('DELETE') }}
                            </form>
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