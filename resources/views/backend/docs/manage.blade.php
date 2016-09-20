@extends('backend')

@section('content')
    <style>
        .operate{
            width: 200px;
        }
    </style>
    <div class="panel panel-default" style="
        width: 80%;
        margin-left: auto;
        margin-right: auto;
        margin-top: 30px;">
        <div class="panel-heading container-fluid" style="padding: 5px 15px;">
            <div class="row">
                <div class="col-md-6" style="padding-top: 10px;">
                    <h2 class="panel-title">管理文档</h2>
                </div>
                <div class="col-md-6" style="text-align: right;">
                    <a href="add" class="btn btn-default">
                        <span class="glyphicon glyphicon-plus"></span>添加文档
                    </a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <table class="table">
                <thead>
                    <th>文档名称</th>
                    <th>状态</th>
                    <th>创建日期</th>
                    <th class="operate">操作</th>
                </thead>
                <tbody>
                    <tr>
                        <td>文档一</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
                                    允许游客查看 <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">允许游客查看</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>2016</td>
                        <td>
                            <button type="button" class="btn btn-info btn-xs">预览</button>
                            <button type="button" class="btn btn-primary btn-xs">编辑</button>
                            <button type="button" class="btn btn-success btn-xs">导出</button>
                            <button type="button" class="btn btn-danger btn-xs">删除</button>
                        </td>
                    </tr>
                    <tr>
                        <td>文档二</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-danger btn-xs dropdown-toggle" data-toggle="dropdown">
                                    禁止游客查看 <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">允许游客查看</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>2017</td>
                        <td>
                            <button type="button" class="btn btn-info btn-xs">预览</button>
                            <button type="button" class="btn btn-primary btn-xs">编辑</button>
                            <button type="button" class="btn btn-success btn-xs">导出</button>
                            <button type="button" class="btn btn-danger btn-xs">删除</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="width: 100%;text-align: center;">
                <nav>
                    <ul class="pagination">
                        <li class="disabled"><a href="#">&laquo;</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('init')
    <script type="text/javascript">
        //初始化数据
        $(function () {
            var active = 'docs';
            $('#'+active).addClass('active');
        });
    </script>
@endsection