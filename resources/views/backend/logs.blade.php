@extends('backend')

@section('content')
    <iframe id="logs_view"
            src="{{ url('backend/logs') }}"
            frameborder="0"
            style="border: 0"
            width="100%"
            scrolling="no"
    ></iframe>
@endsection

@section('init')
    <script>

        //初始化菜单
        $(function () {
            var active = 'logs';
            $('#'+active).addClass('active');
        });

        //加载日志视图
        $("#logs_view").on("load",function(){
            //加载完成，需要执行的代码
            var logs_view = $("#logs_view");
            var height = logs_view.contents().find("body").height() + 30;
            logs_view.height(height);
        });

    </script>
@endsection