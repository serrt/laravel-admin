@extends('admin.layouts.iframe')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <a href="{{route('admin.permission.create')}}" class="btn btn-default"><i class="fa fa-plus"></i> 添加</a>
        </div>
        <div class="box-body row">
            <div class="col-md-6" onselectstart="return false;">
                @component('admin.permission.tree', ['permissions'=>$list, 'pid'=>0])
                @endcomponent
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('js/checkbox.js')}}"></script>
@endsection
