@extends('admin.layouts.iframe')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="javascript:history.back()" class="btn btn-default"> 返回</a>
    </div>

    <div class="box-body">
        <form action="{{route('admin.role.update',$role)}}" class="form-horizontal validate" method="post">
            {{csrf_field()}}
            {{method_field('put')}}
            <div class="form-group">
                <label class="control-label col-md-2">使用区域</label>
                <div class="col-md-8 checkbox">
                    <label><input type="radio" name="guard" value="admin" {{$role->guard_name=='admin'?'checked':''}}> 后台</label>
                    <p class="help-block">目前只支持后台</p>
                </div>
            </div>
            <div class="form-group">
                <label for="inputDisplayName" class="control-label col-md-2">名称*</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="display_name" value="{{$role->display_name}}" id="inputDisplayName" data-rule-required="true">
                    <p class="help-block">角色的中文名称, 不能重复</p>
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="control-label col-md-2">key*</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="name" value="{{$role->name}}" id="inputName" data-rule-required="true" data-rule-remote="{{route('api.web.unique',['table'=>'roles', 'unique'=>'name', 'ignore'=>$role->name])}}">
                    <p class="help-block">角色的英文名称, 不能重复</p>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-2">
                    <button type="submit" class="btn btn-primary">提交</button>
                    <a href="{{route('admin.role.index')}}" class="btn btn-default"> 返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
    <script src="{{asset('js/checkbox.js')}}"></script>
@endsection