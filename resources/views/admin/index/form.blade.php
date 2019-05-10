@extends('admin.layouts.iframe')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">基本表单</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <form action="" class="form-horizontal validate" role="form" autocomplete="off">
                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Input</label>
                    <div class="col-md-8">
                        <input type="text" name="" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-md-2 control-label">Select</label>
                    <div class="col-md-8">
                        <select name="" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="year" class="col-md-2 control-label">Year</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control year" id="year">
                    </div>
                </div>
                <div class="form-group">
                    <label for="month" class="col-md-2 control-label">Month</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control month" id="month">
                    </div>
                </div>
                <div class="form-group">
                    <label for="date" class="col-md-2 control-label">Date</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control date" id="date">
                    </div>
                </div>
                <div class="form-group">
                    <label for="datetime" class="col-md-2 control-label">Date Time</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control datetime" id="datetime">
                    </div>
                </div>
                <div class="form-group">
                    <label for="time" class="col-md-2 control-label">Time</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control time" id="time">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Date Range</label>
                    <div class="col-md-8">
                        <div class="input-group date-range">
                            <input type="text" name="start_time" class="form-control">
                            <span class="input-group-addon">至</span>
                            <input type="text" name="end_time" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Date Time Range</label>
                    <div class="col-md-8">
                        <div class="input-group datetime-range">
                            <input type="text" name="start_time" class="form-control">
                            <span class="input-group-addon">至</span>
                            <input type="text" name="end_time" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="submit" class="btn btn-primary" id="loading-button" data-loading-text="Loading..." autocomplete="off">Submit</button>
                        <a href="javascript:history.back();" class="btn btn-default">返回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="https://select2.org" target="_blank">Select2</a>
            </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="" class="form-horizontal" role="form" autocomplete="off">
                <div class="form-group">
                    <label class="col-md-2 control-label">Example</label>
                    <div class="col-md-8">
                        <select name="select2[]" class="form-control select2" multiple="multiple">
                            <option value="1">1</option>
                            <option value="2" selected="selected">2</option>
                            <option value="3" selected="selected">3</option>
                            <option value="4">4</option>
                        </select>
                        <p class="help-block text-muted">
                            添加 <code>class="select2"</code>, <code>multiple</code> 属性表示允许多选, <code>option</code> 标签添加 <code>selected</code>属性表示选中状态
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Ajax</label>
                    <div class="col-md-8">
                        <select name="" class="form-control select2" data-ajax-url="{{route('api.web.city', ['level' => 1])}}">
                            <option value=""></option>
                        </select>
                        <p class="help-block text-muted">
                            属性 <code>data-ajax-url</code> 填写请求数据的地址, 添加 <code>class="select2"</code>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Ajax Selected</label>
                    <div class="col-md-8">
                        <select name="" class="form-control select2" data-json="{{json_encode($city)}}" data-ajax-url="{{route('api.web.city', ['level' => 1])}}">
                            <option value=""></option>
                        </select>
                        <p class="help-block text-muted">
                            属性 <code>data-json</code> 填写 <b>json_encode</b> 后的单个数据
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Ajax Multiple</label>
                    <div class="col-md-8">
                        <select name="" class="form-control select2" multiple data-ajax-url="{{route('api.web.city', ['level' => 1])}}">
                            <option value=""></option>
                        </select>
                        <p class="help-block text-muted">
                            添加属性 <code>multiple</code>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Ajax Multiple Selected</label>
                    <div class="col-md-8">
                        <select name="select2-ajax-multiple-selected" id="select2-ajax-multiple-selected" class="form-control select2" multiple data-json="{{json_encode($cities)}}" data-ajax-url="{{route('api.web.city', ['level' => 1])}}">
                            <option value=""></option>
                        </select>
                        <p class="help-block text-muted">
                            添加属性 <code>multiple</code>, 属性 <code>data-json</code> 填写 <b>json_encode</b> 后的多个数组
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="http://plugins.krajee.com/file-input" target="_blank">File input</a>
            </h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <form action="{{route('admin.index.upload')}}" class="form-horizontal validate" method="post" enctype="multipart/form-data" role="form" autocomplete="off">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-md-2 control-label">File</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control file-input" name="file" data-rule-required="true" data-preview="{{$video_url}}">
                        <p class="help-block text-muted">添加 <code>class="file-input"</code></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">File preview</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control file-input" data-preview="{{$imgs_url}}">
                        <p class="help-block text-muted">添加属性 <code>data-preview="图片地址,图片地址"</code></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="javascript:history.back();" class="btn btn-default">返回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
    $(function () {
        $('.select2[data-ajax-url]').on('select2:unselecting', function (e) {
            var item = e.params.args.data;
            var data = $(this).select2('data');
            var val = [];
            for (var i in data) {
                if (item.id != data[i].id) {
                    val.push(data[i].id);
                }
            }
            $(this).val(val).trigger('change');
            return true;
        });
    })
</script>
@endsection


