@extends('admin.layouts.iframe')
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Visitors Report</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body no-padding table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>序号</th>
                        <th>年度</th>
                        <th>人员</th>
                        <th>走访总户数(户)</th>
                        <th>已走访(户)</th>
                        <th>未走访(户)</th>
                        <th>完成度</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>序号</td>
                        <td>年度</td>
                        <td>人员</td>
                        <td>走访总户数(户)</td>
                        <td>已走访(户)</td>
                        <td>未走访(户)</td>
                        <td>完成度</td>
                    </tr>
                    <tr>
                        <td>序号</td>
                        <td>年度</td>
                        <td>人员</td>
                        <td>走访总户数(户)</td>
                        <td>已走访(户)</td>
                        <td>未走访(户)</td>
                        <td>完成度</td>
                    </tr>
                    <tr>
                        <td>序号</td>
                        <td>年度</td>
                        <td>人员</td>
                        <td>走访总户数(户)</td>
                        <td>已走访(户)</td>
                        <td>未走访(户)</td>
                        <td>完成度</td>
                    </tr>
                    <tr>
                        <td>序号</td>
                        <td>年度</td>
                        <td>人员</td>
                        <td>走访总户数(户)</td>
                        <td>已走访(户)</td>
                        <td>未走访(户)</td>
                        <td>完成度</td>
                    </tr>
                    <tr>
                        <td>序号</td>
                        <td>年度</td>
                        <td>人员</td>
                        <td>走访总户数(户)</td>
                        <td>已走访(户)</td>
                        <td>未走访(户)</td>
                        <td>完成度</td>
                    </tr>
                    <tr>
                        <td>序号</td>
                        <td>年度</td>
                        <td>人员</td>
                        <td>走访总户数(户)</td>
                        <td>已走访(户)</td>
                        <td>未走访(户)</td>
                        <td>完成度</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-hacker-news"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Inventory</span>
                <span class="info-box-number">5,200</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 50%"></div>
                </div>
                <span class="progress-description">
                50% Increase in 30 Days
              </span>
            </div>
        </div>
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-heart-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Mentions</span>
                <span class="info-box-number">92,050</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 20%"></div>
                </div>
                <span class="progress-description">
                20% Increase in 30 Days
              </span>
            </div>
        </div>
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-download"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Downloads</span>
                <span class="info-box-number">114,381</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                70% Increase in 30 Days
              </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-map-marker"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Direct Messages</span>
                <span class="info-box-number">163,921</span>

                <div class="progress">
                    <div class="progress-bar" style="width: 40%"></div>
                </div>
                <span class="progress-description">
                40% Increase in 30 Days
              </span>
            </div>
            <!-- /.info-box-content -->
        </div>
    </div>
</div>
@endsection
