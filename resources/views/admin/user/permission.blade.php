@extends('admin.layouts.iframe')
@section('content')
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <ul>
        <li>这里是用户 <b>独立</b> 享有的权限, 如果想修改 <b>角色权限</b> <a href="{{route('admin.role.index')}}" class="alert-link">点击这里</a></li>
    </ul>
</div>
<div class="box box-info">
    <div class="box-header with-border">
        <a href="javascript:history.back()" class="btn btn-default"> 返回</a>
    </div>

    <div class="box-body">
        <form action="{{route('admin.user.update',$user)}}" class="form-horizontal validate" method="post">
            {{csrf_field()}}
            {{method_field('put')}}
            <div class="form-group">
                <label class="control-label col-md-2">权限</label>
                <div class="col-md-8">
                    @include('admin.role.tree', ['permissions'=>$permissions, 'pid'=>0, 'checked' => $user_permissions])
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
@section('script')
    <script src="{{asset('js/checkbox.js')}}"></script>
@endsection