@extends('admin.layouts.iframe')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="javascript:history.back()" class="btn btn-default"> 返回</a>
    </div>

    <div class="box-body">
        <form action="{{route('admin.keywords.store')}}" class="form-horizontal validate" method="post">
            {{csrf_field()}}
            <div class="form-group">
                <label for="inputType" class="control-label col-md-2">类型*</label>
                <div class="col-md-8">
                    <select name="type" id="inputType" class="form-control select2" data-rule-required="true" data-ajax-url="{{route('api.web.keywords_type')}}">
                        @if ($type)
                        <option value="{{$type->id}}" selected="selected">{{$type->name}}</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputKey" class="control-label col-md-2">key*</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="key" id="inputKey" data-rule-required="true" data-rule-remote="{{route('api.web.unique',['table'=>'keywords','unique'=>'key'])}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="control-label col-md-2">名称*</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="name" id="inputName" data-rule-required="true">
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