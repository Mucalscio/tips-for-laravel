@extends('backend')

@section('content')
    <style>
        .common-width{
            width: 80% !important;
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
                <li role="presentation"><a href="#category" role="tab" data-toggle="tab">添加分类</a></li>
                <li role="presentation"><a href="#interface" role="tab" data-toggle="tab">添加接口</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <!-- 基本参数设置 -->
                <div role="tabpanel" class="tab-pane active" id="base">
                    <form class="form-horizontal" method="post" action="{{ empty($id) ? "create" : "edit" }}" id="base_form" role="form" style="margin-top: 30px;">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">文档名称</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="name" id="name" placeholder="请输入文档名称" value="{{ $name or '' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="author" class="col-sm-2 control-label">作者</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="author" id="author" placeholder="请输入作者" value="{{ $author or '' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" id="base_btn" data-loading-text="正在提交..." class="btn btn-primary">{{ empty($id) ? "创建" : "修改" }}</button>
                                <a href="{{ url('backend/docs/manage') }}" class="btn btn-default" style="margin-left: 20px">返回列表</a>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- 分类设置 -->
                <div role="tabpanel" class="tab-pane" id="category">
                    <form class="form-horizontal" id="category_form" role="form" style="margin-top: 30px;">
                        <div class="input-group common-width" style="
                            margin-left: auto;
                            margin-right: auto;">
                            <input type="text" name="name" id="category_name" class="form-control" placeholder="请输入分类">
                            <span class="input-group-btn">
                                <button id="category_btn"  data-loading-text="正在提交..." class="btn btn-default" type="button">添加</button>
                            </span>
                        </div>
                    </form>
                    <table class="table common-width" style="
                            margin-top: 30px;
                            margin-left: auto;
                            margin-right: auto;">
                        <tbody id="category_body">
                        </tbody>
                    </table>
                </div>
                <!-- 接口设置 -->
                <div role="tabpanel" class="tab-pane" id="interface">
                    <form class="form-inline common-width container-fluid" role="form" style="
                            margin-top: 30px;
                            margin-left: auto;
                            margin-right: auto;">
                        <div class="form-group col-md-6">
                            <select id="interface_select" class="form-control" style="width: 100%;">
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <input type="text" id="interface_name" class="form-control" placeholder="请输入接口名" style="width: 100%;">
                        </div>
                        <div class="form-group col-md-2">
                            <button type="button" onclick="create_interface()" class="btn btn-default">添加</button>
                        </div>
                    </form>
                    <table class="table common-width" style="
                            margin-top: 30px;
                            margin-left: auto;
                            margin-right: auto;">
                        <tbody>
                        <tr>
                            <td>接口一</td>
                            <td>分类</td>
                            <td>2015</td>
                            <td style="width: 80px;">
                                <button type="button" class="btn btn-danger btn-xs">删除</button>
                            </td>
                        </tr>
                        <tr>
                            <td>接口二</td>
                            <td>分类</td>
                            <td>2016</td>
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
    @include('backend.delete')
    @include('backend.warn')
    @include('backend.docs.markdown')
    <script type="text/javascript">
        //初始化数据
        $(function () {
            var active = 'docs';
            $('#'+active).addClass('active');
        });

        //设置文档ID
        var docs_id = {{ $id or 0}};
        function get_doc_id() {
            if(docs_id == 0) {
                return false;
            } else {
                return docs_id;
            }
        }

        $('#base_btn').on('click', function () {
            $(this).button('loading');
        });

        $('#category_btn').on('click', function () {
            if(docs_id == 0) {
                warn('提示', '请先创建文档');
                return false;
            }
            var $btn = $(this).button('loading');
            form = $('#category_form');
            $.ajax({
                cache: true,
                type: "POST",
                url: '{{ empty($id) ? "" : url("backend/docs/category/create/".$id) }}',
                data: form.serialize(),// 你的formid
                async: true,
                error: function(request) {
                    alert("连接异常");
                },
                success: function(json) {
                    $btn.button('reset');
                    switch (json.status) {
                        case 1:
                            var id = json.data.id;
                            var name = json.data.name;
                            var created_at = json.data.created_at;
                            create_category_item(id, name, created_at);
                            $("#category_name").val('');
                            warn('成功', "创建成功");
                            break;
                        case -1:
                            warn('操作失败', json.data);
                            break;
                        case -2:
                            warn('操作失败', json.data);
                            break;
                    }
                }
            });
        });

        function create_category_item(id, name, created_at) {
            var tr = '<tr id="cat'+id+'"> <td>'+name+'</td> <td>'+created_at+'</td> <td style="width: 80px;">' +
                    ' <button type="button" onclick="delete_category('+id+')" class="btn btn-danger btn-xs">删除</button> </td> </tr>';
            $('#category_body').prepend(tr);
        }

        //获取分类列表
        if(docs_id != 0) {
            $.ajax({
                cache: true,
                type: "GET",
                url: '{{ empty($id) ? "" : url("backend/docs/category/list/".$id) }}',
                async: true,
                error: function (request) {
                    alert("连接异常");
                },
                success: function (json) {
                    switch (json.status) {
                        case 1:
                            cats = json.data.data;
                            cats.forEach(function (cat) {
                                create_category_item(cat.id, cat.name, cat.created_at);
                                create_category_select(cat.id, cat.name);
                            });
                            break;
                        default :
                            warn('警告', json.data);
                            break;
                    }
                }
            });
        }

        function delete_category(id) {
            delete_id = id;
            $('#delete_confirm').modal('show');
        }

        function delete_category_confirm(id) {
            $.ajax({
                cache: true,
                type: "DELETE",
                url: '{{ url("backend/docs/category/delete/") }}' + '/' + id,
                async: true,
                error: function (request) {
                    alert("连接异常");
                },
                success: function (json) {
                    switch (json.status) {
                        case 1:
                            $('#cat'+id).remove();
                            warn('成功','删除成功');
                            break;
                        default :
                            warn('失败', json.data);
                            break;
                    }
                }
            });
        }

        $("#delete_yes").click(function () {
            $('#delete_confirm').modal('hide');
            delete_category_confirm(delete_id);
        });

        //添加接口JS
        var interface_list;
        if(docs_id != 0) {
            $.ajax({
                cache: true,
                type: "GET",
                url: '{{ url("backend/docs/interface/get/") }}',
                async: true,
                error: function (request) {
                    alert("连接异常");
                },
                success: function (json) {
                    switch (json.status) {
                        case 1:
                            interface_list = json.data;
                            //console.warn(inters);
                            interface_list.forEach(function (inter) {
                                create_interface_select(inter.uri);
                            });
                            break;
                        default :
                            warn('警告', json.data);
                            break;
                    }
                }
            });
        }

        function create_interface_select(uri) {
            option = '<option value="'+uri+'">'+uri+'</option>';
            $('#interface_select').append(option);
        }

        function create_category_select(id, name) {
            option = '<option value="'+id+'">'+name+'</option>';
            $('#category_select').append(option);
        }

        function create_interface() {
            $('#markdown').modal('show');
            uri = $('#interface_select').val();
            name = $('#interface_name').val();
            create_markdown_document(uri,name);
        }

        function create_markdown_document(uri, name) {
            //console.warn(interface_list);
            interface_list.forEach(function (inter) {
                markdown_text = $('#markdown_editor');
                if(uri == inter.uri) {
                    string = "### " + name + "\n";
                    string += "- 提交方式:" + inter.method + "\n";
                    markdown_text.html(string);
                }
            });
        }

    </script>
@endsection
