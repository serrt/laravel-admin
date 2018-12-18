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
<body class="hold-transition skin-blue sidebar-mini fixed" style="overflow: hidden">
<div class="wrapper">
    <!-- 顶部 -->
    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">{{substr(config('app.name'), 0, 2)}}</span>
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

    <!-- 右边隐藏的部分 -->
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
                @component('component.skins')
                @endcomponent
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
            </ul>
        </section>
    </aside>

    <!-- 多标签页 -->
    <div class="content-wrapper" id="content-wrapper">
        <div class="content-tabs">
            <button class="roll-nav roll-left tabLeft" onclick="scrollTabLeft()">
                <i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs menuTabs tab-ui-menu" id="tab-menu">
                <div class="page-tabs-content">
                </div>
            </nav>
            <button class="roll-nav roll-right tabRight" onclick="scrollTabRight()">
                <i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown tabClose" data-toggle="dropdown">
                    页签操作<i class="fa fa-caret-down" style="padding-left: 3px;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a class="tabReload" href="javascript:refreshTab();">刷新当前</a></li>
                    <li><a class="tabCloseCurrent" href="javascript:closeCurrentTab();">关闭当前</a></li>
                    <li><a class="tabCloseAll" href="javascript:closeOtherTabs(true);">全部关闭</a></li>
                    <li><a class="tabCloseOther" href="javascript:closeOtherTabs();">除此之外全部关闭</a></li>
                </ul>
            </div>
            <button class="roll-nav roll-right fullscreen" onclick="App.handleFullScreen()"><i class="fa fa-arrows-alt"></i></button>
        </div>
        <div class="content-iframe">
            <!-- iframe内页 -->
            <div class="tab-content " id="tab-content">

            </div>
        </div>
    </div>

    @include('admin.layouts.footer')

</div>

@include('admin.layouts.js')

<!-- FastClick -->
<script src="{{asset('js/fastclick.js')}}"></script>

<!--tabs-->
<script src="{{asset('js/app_iframe.js')}}"></script>

<script type="text/javascript">

    $(function () {
        App.setbasePath("./");
        App.setGlobalImgPath("images/");

        var menus = JSON.parse('{!! json_encode($current_user_menus) !!}');

        $('.sidebar-menu').sidebarMenu({data: menus});

        var firstMenu = getFirstMenu(menus);
        if (firstMenu) {
            addTabs(firstMenu);
        }

        function getFirstMenu(menus, i = 0)
        {
            var firstMenu = null ;
            if (menus.length > 0) {
                firstMenu = menus[i];
                if (!firstMenu.url && firstMenu.children) {
                    return getFirstMenu(firstMenu.children, i);
                }
                if (!firstMenu.title) {
                    firstMenu.title = firstMenu.text;
                }
            }
            firstMenu.close = true;
            return firstMenu;
        }

        App.fixIframeCotent();
    });
</script>

</body>
</html>