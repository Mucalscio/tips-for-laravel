@extends('backend')

@section('content')
    <style>
        .common-width{
            width: 80%;
        }
    </style>
    <div class="panel panel-default common-width" style="
        margin-left: auto;
        margin-right: auto;
        margin-top: 30px;">
        <div class="panel-heading" style="padding: 5px 15px;height: 45px;">
            <h3 class="panel-title" style="margin-top: 10px;">添加文档</h3>
        </div>
        <div class="panel-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#base" role="tab" data-toggle="tab">基本设置</a></li>
                <li role="presentation"><a href="#category" role="tab" data-toggle="tab">分类设置</a></li>
                <li role="presentation"><a href="#interface" role="tab" data-toggle="tab">接口设置</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <!-- 基本参数设置 -->
                <div role="tabpanel" class="tab-pane active" id="base">
                    <form class="form-horizontal" role="form" style="margin-top: 30px;">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">文档名称</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name" placeholder="请输入文档名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="author" class="col-sm-2 control-label">作者</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="author" id="author" placeholder="请输入作者">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">保存</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- 分类设置 -->
                <div role="tabpanel" class="tab-pane" id="category">
                    <form class="form-horizontal" role="form" style="margin-top: 30px;">
                        <div class="input-group common-width" style="
                            margin-left: auto;
                            margin-right: auto;">
                            <input type="text" class="form-control" placeholder="请输入分类">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">添加</button>
                            </span>
                        </div>
                    </form>
                    <table class="table common-width" style="
                            margin-top: 30px;
                            margin-left: auto;
                            margin-right: auto;">
                        <tbody>
                        <tr>
                            <td>分类一</td>
                            <td>2016</td>
                            <td style="width: 80px;">
                                <button type="button" class="btn btn-danger btn-xs">删除</button>
                            </td>
                        </tr>
                        <tr>
                            <td>分类二</td>
                            <td>2017</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-xs">删除</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- 接口设置 -->
                <div role="tabpanel" class="tab-pane" id="interface">
                    <form class="form-inline common-width container-fluid" role="form" style="
                            margin-top: 30px;
                            margin-left: auto;
                            margin-right: auto;">
                        <div class="form-group col-md-5">
                            <input type="text" class="form-control" id="exampleInputEmail2" placeholder="接口" style="width: 100%;">
                        </div>
                        <div class="form-group col-md-5">
                            <input type="text" class="form-control" id="exampleInputPassword2" placeholder="类型" style="width: 100%;">
                        </div>
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-default">添加</button>
                        </div>
                    </form>
                    <table class="table common-width" style="
                            margin-top: 30px;
                            margin-left: auto;
                            margin-right: auto;">
                        <tbody>
                        <tr>
                            <td>分类一</td>
                            <td>2016</td>
                            <td style="width: 80px;">
                                <button type="button" class="btn btn-danger btn-xs">删除</button>
                            </td>
                        </tr>
                        <tr>
                            <td>分类二</td>
                            <td>2017</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-xs">删除</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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