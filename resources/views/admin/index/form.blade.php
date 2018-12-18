@extends('admin.layouts.iframe')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3>基本表单</h3>
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
                            <label for="" class="col-md-2 control-label">Select2</label>
                            <div class="col-md-8">
                                <select name="" class="form-control select2" data-ajax-url="{{route('api.web.city')}}">
                                    <option value=""></option>
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
                            <label for="" class="col-md-2 control-label">File</label>
                            <div class="col-md-8">
                                <input type="file" class="form-control file-input" data-initial-preview="{{$img_url}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-2 control-label">File preview</label>
                            <div class="col-md-8">
                                <input type="file" class="form-control file-input" data-initial-preview="{{$imgs_url}}">
                                <p class="help-block">添加属性 <b>data-initial-preview="图片地址,图片地址"</b></p>
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
        </div>
    </div>
@endsection