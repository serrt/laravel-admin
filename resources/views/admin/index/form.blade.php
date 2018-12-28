@extends('admin.layouts.iframe')
@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">基本表单</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="" class="form-horizontal" role="form" autocomplete="off">
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
                    <label class="col-md-2 control-label">Date Range</label>
                    <div class="col-md-8">
                        <div class="input-group input-daterange">
                            <input type="text" name="start_time" class="form-control">
                            <span class="input-group-addon">至</span>
                            <input type="text" name="end_time" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-8 col-lg-offset-2">
                        <button type="submit" class="btn btn-primary">Submit</button>
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
                        <select name="" class="form-control select2" data-ajax-url="{{route('api.web.city')}}">
                            <option value=""></option>
                        </select>
                        <p class="help-block text-muted">
                            属性 <code>data-ajax-url</code> 填写请求数据的地址, 添加 <code>class="select2"</code>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Example Selected</label>
                    <div class="col-md-8">
                        <select name="" class="form-control select2" data-json="{{json_encode($city)}}" data-ajax-url="{{route('api.web.city')}}">
                            <option value=""></option>
                        </select>
                        <p class="help-block text-muted">
                            属性 <code>data-json</code> 填写 <b>json_encode</b> 后的单个数据
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Example Multiple</label>
                    <div class="col-md-8">
                        <select name="" class="form-control select2" multiple data-ajax-url="{{route('api.web.city')}}">
                            <option value=""></option>
                        </select>
                        <p class="help-block text-muted">
                            添加属性 <code>multiple</code>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">Example Multiple Selected</label>
                    <div class="col-md-8">
                        <select name="" class="form-control select2" multiple data-json="{{json_encode($cities)}}" data-ajax-url="{{route('api.web.city')}}">
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
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <form action="" class="form-horizontal" role="form" autocomplete="off">
                <div class="form-group">
                    <label class="col-md-2 control-label">File</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control file-input">
                        <p class="help-block text-muted">添加 <code>class="file-input"</code></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label">File preview</label>
                    <div class="col-md-8">
                        <input type="file" class="form-control file-input" data-initial-preview="{{$imgs_url}}">
                        <p class="help-block text-muted">添加属性 <code>data-initial-preview="图片地址,图片地址"</code></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection