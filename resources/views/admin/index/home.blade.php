@extends('admin.layouts.iframe')
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">运行环境</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <p class="text-bold">System</p>
                        <p>{{php_uname()}}</p>
                    </li>
                    <li class="list-group-item">
                        <b>Server</b>
                        <span class="pull-right">{{$_SERVER['SERVER_SOFTWARE']}}</span>
                    </li>
                    <li class="list-group-item">
                        <b>PHP</b>
                        <span class="pull-right">{{PHP_VERSION}}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Mysql</b>
                        <span class="pull-right">{{data_get(DB::select('select version() as version'), '0.version')}}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Laravel</b>
                        <span class="pull-right">{{\Illuminate\Foundation\Application::VERSION}}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Timezone</b>
                        <span class="pull-right">{{config('app.timezone')}}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Locale</b>
                        <span class="pull-right">{{config('app.locale')}}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">composer 扩展</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="https://github.com/ARCANEDEV/LogViewer" target="_blank">
                            <b class="text-yellow">arcanedev/log-viewer</b>&nbsp;
                            <span class="label label-info">^4.6</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="https://github.com/spatie/laravel-permission" target="_blank">
                            <b class="text-yellow">spatie/laravel-permission</b>&nbsp;
                            <span class="label label-info">^2.19</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="https://github.com/jacobcyl/Aliyun-oss-storage" target="_blank">
                            <b class="text-yellow">jacobcyl/ali-oss-storage</b>&nbsp;
                            <span class="label label-info">^2.1</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="https://github.com/barryvdh/laravel-ide-helper" target="_blank">
                            <b class="text-yellow">barryvdh/laravel-ide-helper</b>&nbsp;
                            <span class="label label-info">^2.5</span>
                            <span class="label label-default">dev</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="https://github.com/barryvdh/laravel-debugbar" target="_blank">
                            <b class="text-yellow">barryvdh/laravel-debugbar</b>&nbsp;
                            <span class="label label-info">^3.2</span>
                            <span class="label label-default">dev</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="https://github.com/Xethron/migrations-generator" target="_blank">
                            <b class="text-yellow">xethron/migrations-generator</b>&nbsp;
                            <span class="label label-info">^2.0</span>
                            <span class="label label-default">dev</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">前端扩展</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="http://getbootstrap.com" target="_blank">
                            <b>boootstrap</b>&nbsp;
                            <span class="label label-info">3.3.7</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="https://adminlte.io" target="_blank">
                            <b>adminlte</b>&nbsp;
                            <span class="label label-info">2.4.5</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="https://fontawesome.io" target="_blank">
                            <b>font-awesome</b>&nbsp;
                            <span class="label label-info">4.7.0</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="https://adminlte.io" target="_blank">
                            <b>bootstrap-fileinput</b>&nbsp;
                            <span class="label label-info">4.5.0</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="https://jqueryvalidation.org" target="_blank">
                            <b>jquery-validate</b>&nbsp;
                            <span class="label label-info">1.17.0</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="https://select2.org" target="_blank">
                            <b>select2</b>&nbsp;
                            <span class="label label-info">4.0.6</span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <a href="https://www.malot.fr/bootstrap-datetimepicker" target="_blank">
                            <b>bootstrap-datetimepicker</b>&nbsp;
                            <span class="label label-info">master</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
