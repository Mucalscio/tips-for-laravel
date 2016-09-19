@extends('backend')

@section('content')
    <div class="panel panel-default" style="width: 50%;margin-left: 25%;margin-top: 100px;">
        <div class="panel-body">
            欢迎来到<strong>tips</strong>后台!<br><br>
            1.活动管理:为了支持一系列活而设置的。<br><br>
            2.开发文档:根据路由以及参数验证规则自动生成API文档。能自动测试接口的有效性。<br><br>
            3.权限管理:基于路由的权限管理,自动生成可配置权限项,可以创建角色,为角色去分配权限。<br><br>
        </div>
    </div>
@endsection

@section('init')
    <script type="text/javascript">
        //初始化数据
        $(function () {
            var active = 'index';
            $('#'+active).addClass('active');
        });
    </script>
@endsection