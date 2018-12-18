@extends('admin.layouts.iframe')
@section('content')
<div class="box box-info">
    <div class="box-header with-border">
        <a href="javascript:history.back()" class="btn btn-default"> 返回</a>
    </div>

    <div class="box-body">
        <form action="{{route('admin.user.update',$user)}}" class="form-horizontal validate" method="post">
            {{csrf_field()}}
            {{method_field('put')}}
            <div class="form-group">
                <label for="inputUserName" class="control-label col-md-2">登录名*</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="username" id="inputUserName" value="{{$user->username}}"
                           data-rule-required="true"
                           data-rule-remote="{{route('api.web.unique',['table'=>'admin_users','unique'=>'username','ignore'=>$user->id])}}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="control-label col-md-2">密码</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" name="password" id="inputPassword">
                    <p class="help-block">需要强制修改密码, 请填写此项;忽略则不修改密码</p>
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="control-label col-md-2">姓名</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="name" value="{{$user->name}}" id="inputName">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-2 col-md-2">
                    <button type="submit" class="btn btn-primary">提交</button>
                    <a href="{{route('admin.user.index')}}" class="btn btn-default"> 返回</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection