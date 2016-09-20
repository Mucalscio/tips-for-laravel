<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/backend_dist/css/bootstrap.css">
    <link rel="icon" href="/backend_dist/images/favicon.ico" type="image/x-icon" />
    <title>tips-backend</title>
</head>
<body>
<nav class="navbar navbar-default" role="navigation" style="margin-bottom: auto;">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="/backend" style="padding: 15px 40px;"> <strong> Tips </strong> </a>
        </div>
        @if(Session::has('login'))
        <div>
            <ul class="nav navbar-nav">
                <li id="index"><a href="/backend">主页</a></li>
                <li id="activity" role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        活动管理 <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" style="max-height: 500px;overflow: scroll;">
                        <li><a href="/backend/activity/badminton">羽毛球比赛</a></li>
                        <li class="divider"></li>
                        <li><a href="/backend/activity/pool_party">泳池派对</a></li>
                        <li class="divider"></li>
                        <li><a href="#">徒步五十里</a></li>
                    </ul>
                </li>
                @if(env('APP_ENV') != 'production')
                <li id="docs"><a href="/backend/docs/manage">开发文档</a></li>
                @endif
                <li id="permission"><a href="#">权限管理</a></li>
                <li id="logs"><a href="{{ url('backend/logs_view') }}">查看日志</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right" style="margin-right: 10px;">
                <a class="btn btn-default navbar-btn" href="{{ url('backend/logout') }}">注销登陆</a>
            </ul>
        </div>
        @endif
    </div>
</nav>
<div id="content">
    @yield('content')
</div>
</body>
<script src="/backend_dist/js/jquery-3.0.0.js"></script>
<script src="/backend_dist/js/bootstrap.js"></script>
<script src="/backend_dist/js/backend.js"></script>
@yield('init')
</html>
