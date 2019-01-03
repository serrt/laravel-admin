@extends('admin.layouts.iframe')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <div class="box-title">多文件管理</div>
        </div>
        <div class="box-body">
            <form action="" class="form-horizontal" role="form">
                <div class="form-group">
                    <div class="col-md-12">
                        <input type="file" name="files2" class="form-control file-input3" data-upload-url="{{route('api.web.upload')}}" data-initial-preview="{{$imgs_url}}" multiple>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            $('.file-input3').fileinput({
                language: 'zh',
                overwriteInitial: false,
                initialPreviewAsData: true,
                showAjaxErrorDetails: false,
                initialPreviewDelimiter: ',',
                browseClass: 'btn bg-purple'
            });
        })
    </script>
@endsection