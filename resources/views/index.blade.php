<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | with iframe</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('adminlte/AdminLTE.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('adminlte/skins/all-skins.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="/" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>A</b>LT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Admin</b>LTE</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <ul class="sidebar-menu">
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="content-wrapper" style="min-height: 421px;">
        <!--bootstrap tab风格 多标签页-->
        <div class="content-tabs">
            <button class="roll-nav roll-left tabLeft" onclick="scrollTabLeft()">
                <i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs menuTabs tab-ui-menu" id="tab-menu">
                <div class="page-tabs-content" style="margin-left: 0px;">

                </div>
            </nav>
            <button class="roll-nav roll-right tabRight" onclick="scrollTabRight()">
                <i class="fa fa-forward" style="margin-left: 3px;"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown tabClose" data-toggle="dropdown">
                    页签操作<i class="fa fa-caret-down" style="padding-left: 3px;"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right" style="min-width: 128px;">
                    <li><a class="tabReload" href="javascript:refreshTab();">刷新当前</a></li>
                    <li><a class="tabCloseCurrent" href="javascript:closeCurrentTab();">关闭当前</a></li>
                    <li><a class="tabCloseAll" href="javascript:closeOtherTabs(true);">全部关闭</a></li>
                    <li><a class="tabCloseOther" href="javascript:closeOtherTabs();">除此之外全部关闭</a></li>
                </ul>
            </div>
            <button class="roll-nav roll-right fullscreen" onclick="App.handleFullScreen()"><i
                    class="fa fa-arrows-alt"></i></button>
        </div>
        <div class="content-iframe " style="background-color: #ffffff; ">
            <div class="tab-content " id="tab-content">

            </div>
        </div>
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.3.8
        </div>
        <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
        reserved.
    </footer>
</div>

<!-- jQuery 2.2.3 -->
<script src="{{asset('js/jquery-2.2.3.min.js')}}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="{{asset('js/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('js/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/AdminLTE.js')}}"></script>

<!--tabs-->
<script src="{{asset('js/app_iframe.js')}}"></script>

<script type="text/javascript">

    $(function () {
        App.setbasePath("./");
        App.setGlobalImgPath("images/");
        addTabs({
            id: 22,
            title: '欢迎页',
            close: true,
            url: "home",
            urlType: 'abosulte',
        });

        App.fixIframeCotent();

        var menus = [
            {
                id: 6,
                text: "菜单B",
                icon: "fa fa-laptop",
                url: "test",
                urlType: 'abosulte',
                targetType: "iframe-tab",
            },
            {
                id: 1,
                text: "菜单组A",
                icon: "fa fa-laptop",
                children: [
                    {
                        id: 5,
                        text: "菜单B",
                        icon: "fa fa-laptop",
                        url: "test",
                        urlType: 'abosulte',
                        targetType: "iframe-tab",
                    },
                    {
                        id: 2,
                        text: "子菜单4",
                        icon: "fa fa-circle-o",
                        children: [
                            {
                                id: 3,
                                text: "子菜单4",
                                icon: "fa fa-circle-o",
                                children: [
                                    {
                                        id: 4,
                                        text: "子菜单4",
                                        icon: "fa fa-circle-o",
                                        url: "test",
                                        urlType: 'abosulte',
                                        targetType: "iframe-tab",
                                    }
                                ]
                            }
                        ],
                    }
                ]
            }
        ];
        $('.sidebar-menu').sidebarMenu({data: menus});
    });
</script>

</body>
</html>