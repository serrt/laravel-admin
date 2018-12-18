<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{config('app.name')}}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @include('admin.layouts.css')
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">
    <!-- 顶部 -->
    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">{{config('app.name')}}</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg">{{config('app.name')}}</span>
        </a>
        <!-- 顶部菜单 -->
        <nav class="navbar navbar-static-top">
            <!-- 隐藏左边菜单-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <!-- 右边部分 -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li>
                        <!-- 日志 -->
                        <a href="{{route('log-viewer::dashboard')}}" target="_blank"><i class="fa fa-flag"></i></a>
                    </li>
                    <li>
                        <!-- 打开右边隐藏的部分 -->
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-user"></i> {{auth()->user()->name?:auth()->user()->username}}</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- 右边隐藏的部分 修改用户登录密码 -->
    <aside class="control-sidebar control-sidebar-dark">
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="">
                <a href="#control-sidebar-skin" data-toggle="tab">
                    <i class="fa fa-wrench"></i>
                </a>
            </li>
            <li class="active">
                <a href="#control-sidebar-password" data-toggle="tab">
                    <i class="fa fa-gears"></i>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" id="control-sidebar-skin">
                <h3 class="control-sidebar-heading">Skins</h3>
                @include('component.skins')
            </div>
            <div class="tab-pane active" id="control-sidebar-password">
                <h3 class="control-sidebar-heading">个人信息</h3>
                <form action="{{route('admin.profile')}}" method="post" class="form-line" autocomplete="off">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="" class="control-label">登录名(不可修改)</label>
                        <span>{{auth()->user()->username}}</span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" name="name" class="form-control" placeholder="Name" value="{{auth()->user()->name}}">
                        <span class="fa fa-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <span class="fa fa-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">修改</button>
                    </div>
                    <div class="form-group">
                        <a href="{{route('admin.logout')}}" class="btn btn-block btn-warning">退出</a>
                    </div>

                </form>
            </div>
        </div>
    </aside>
    <div class="control-sidebar-bg"></div>

    <!-- 左边菜单 js填充 -->
    <aside class="main-sidebar">
        <section class="sidebar">
            <ul class="sidebar-menu">
            @foreach($current_user_menus as $item)
                <li class="treeview {{$item['active']?'active':''}}">
                    <a href="{{isset($item['url'])?url($item['url']):'javascript:void(0)'}}" class="nav-link">
                        <i class="{{$item['icon']}}"></i>
                        <span class="title menu-text">{{$item['text']}}</span>
                        @if(isset($item['children']))
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        @endif
                    </a>
                    @if(isset($item['children']))
                    <ul class="treeview-menu" style="display: {{$item['active']?'block':'none'}}">
                        @foreach($item['children'] as $child)
                        <li class="{{$child['active']?'active':''}}">
                            <a href="{{isset($child['url'])?url($child['url']):'javascript:void(0)'}}" class="nav-link">
                                <i class="{{$child['icon']}}"></i>
                                <span class="title menu-text">{{$child['text']}}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
            @endforeach
            </ul>
        </section>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @if(isset($current_permission) && isset($current_menu))
        <section class="content-header">
            <h1>{{$current_permission->display_name}}</h1>
            <ol class="breadcrumb">
                <li><a href="javascript:void(0);"><i class="fa fa-dashboard"></i> {{$current_menu['text']}}</a></li>
                @if(isset($current_menu['children']))
                @foreach($current_menu['children'] as $item)
                    @if($item['active'])
                        <li class="active">{{$item['text']}}</li>
                    @endif
                @endforeach
                @endif
            </ol>
        </section>
        @endif

        <!-- Main content -->
        <section class="content">
            @if($errors->any())
            <div class="callout callout-danger">
                @foreach($errors->all() as $value)
                <p>{{$value}}</p>
                @endforeach
            </div>
            @endif
            @if(Session::has('flash_message'))
            <div class="callout callout-success">
                <p>{{Session::get('flash_message')}}</p>
            </div>
            @endif
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('admin.layouts.footer')
</div>

@include('admin.layouts.js')
@yield('script')
</body>
</html>