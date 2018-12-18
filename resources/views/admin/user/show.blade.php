@extends('admin.layouts.iframe')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>登录名</b>
                            <code class="pull-right">{{$user->username}}</code>
                        </li>
                        <li class="list-group-item clearfix">
                            <b>姓名</b>
                            <code class="pull-right">{{$user->name}}</code>
                        </li>
                        <li class="list-group-item">
                            <b>创建时间</b>
                            <code class="pull-right">{{$user->created_at}}</code>
                        </li>
                    </ul>

                    <a href="javascript:history.back()" class="btn btn-default btn-block">返回</a>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#permission" data-toggle="tab">权限</a>
                    </li>
                    <li>
                        <a href="#role" data-toggle="tab">角色</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="permission" onselectstart="return false;">
                        @include('admin.user.tree', ['permissions'=>$user_permissions, 'pid'=>0, 'checked' => collect()])
                    </div>
                    <div class="tab-pane" id="role">
                        <ul class="list-group">
                            @foreach($user_roles as $role)
                            <li class="list-group-item">
                                <a href="{{route('admin.role.edit', $role->id)}}">{{$role->name}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('js/checkbox.js')}}"></script>
@endsection