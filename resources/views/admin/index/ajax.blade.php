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
                        <input type="file" name="file" class="form-control file-input3" multiple>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            var upload_url = "{{route('admin.index.upload')}}";
            var imgs = JSON.parse('{!! json_encode($imgs_url) !!}');
            var preview_config = [], preview = [];
            for (var i in imgs) {
                var item = imgs[i];
                var item_split = item.split('/');
                preview_config.push({
                    key: i,
                    caption: item_split[item_split.length - 1],
                    type: 'image',
                    fileType: 'image',
                    url: upload_url,
                });
                preview.push(item);
            }
            var element = $('.file-input3');
            element.fileinput({
                language: 'zh',
                overwriteInitial: false,

                initialPreview: preview,
                initialPreviewAsData: true,
                initialPreviewConfig: preview_config,

                uploadUrl: upload_url,

                removeFromPreviewOnError: true,
                browseLabel: '选择',
                browseClass: 'btn bg-purple',
            }).on('fileuploaded', function (event, data, previewId, index) {
                console.log('fileuploaded');
            }).on('filesorted', function (event, params) {
                console.log('File sorted');
                var data = [];
                for (var i in params.stack) {
                    data.push(params.stack[i].key);
                }
                $.post(upload_url, {sort: data}).then(function (res) {
                    console.log(res)
                });
            });
        })
    </script>
@endsection