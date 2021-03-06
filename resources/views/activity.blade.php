@extends('backend')

@section('content')
    <link rel="stylesheet" href="/backend_dist/css/activity.css">
    <div class="container-fluid">
        <div class="row">
            <div  class="col-md-2 sidebar">
                @yield('sidebar')
            </div>
            <div  class="col-md-10 sidebar">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">@yield('activity_title') / <small> @yield('operation_title')</small></h3>
                    </div>
                    <div class="panel-body">
                        @yield('activity_content')
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection

@section('init')
    <script type="text/javascript">
        //初始化数据
        $(function () {
            var active = 'activity';
            $('#'+active).addClass('active');
        });
    </script>
@endsection