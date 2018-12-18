@extends('admin.layouts.iframe')
@section('content')
<div class="box box-info">
    <div class="box-body">
        <form action="{{route('admin.role.update',$role)}}" class="form-horizontal validate" method="post">
            {{csrf_field()}}
            {{method_field('put')}}
            <div class="form-group">
                <label class="control-label col-md-2">权限</label>
                <div class="col-md-8">
                    @include('admin.role.tree', ['permissions'=>$permissions, 'pid'=>0, 'checked' => $role->permissions->pluck('id')])
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