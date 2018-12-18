@extends('admin.layouts.iframe')
@section('content')
<div class="box">
    <div class="box-header with-border">
        <form action="" class="form-horizontal" autocomplete="off" id="searchForm">
            <div class="form-group">
                <label for="" class="col-md-2 control-label">上级</label>
                <div class="col-md-2">
                    <select name="pid" title="上级" class="form-control select2" data-json="{{json_encode($region)}}" data-ajax-url="{{route('api.web.city')}}">
                        <option value=""></option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-2 pull-right">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                </div>
            </div>
        </form>
    </div>

    <div class="box-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>上级</th>
                <th>名称</th>
                <th>code</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->parent?$item->parent->name:'--'}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->code}}</td>
                <td></td>
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