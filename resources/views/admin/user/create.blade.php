@extends('admin.layouts.iframe')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <a href="{{route('admin.user.index')}}" class="btn btn-default"> 返回</a>
        </div>

        <div class="box-body">
            <form action="{{route('admin.user.store')}}" class="form-horizontal validate" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="inputUserName" class="control-label col-md-2">登录名*</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="username" id="inputUserName"
                               data-rule-required="true"
                               data-rule-remote="{{route('api.web.unique',['table'=>'admin_users','unique'=>'username'])}}">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="control-label col-md-2">密码*</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" name="password" id="inputPassword"
                               data-rule-required="true">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputName" class="control-label col-md-2">姓名</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="name" id="inputName">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">角色</label>
                    <div class="col-md-8">
                        <select name="roles[]" class="form-control select2" data-ajax-url="{{route('api.web.role')}}" multiple>
                            <option value=""></option>
                        </select>
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