@extends('admin.layouts.iframe')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="{{route('admin.keywords_type.index')}}" class="btn btn-default"> 返回</a>
    </div>

    <div class="box-body">
        <form action="{{route('admin.keywords_type.update',$type)}}" class="form-horizontal validate" method="post">
            {{csrf_field()}}
            {{method_field('put')}}
            <div class="form-group">
                <label for="inputKey" class="control-label col-md-2">key*</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="key" id="inputKey" value="{{$type->key}}" data-rule-required="true"  data-rule-remote="{{route('api.web.unique',['table'=>'keywords_type', 'unique'=>'key', 'ignore'=>$type->key])}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="control-label col-md-2">名称*</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="name" id="inputName" value="{{$type->name}}" data-rule-required="true">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-2">
                    <button type="submit" class="btn btn-primary">提交</button>
                    <a href="{{route('admin.keywords_type.index')}}" class="btn btn-default"> 返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection