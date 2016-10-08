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
                    <a href="create_view" class="btn btn-default">
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
                    @foreach($data as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown">
                                    公开 <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">私密</a></li>
                                </ul>
                            </div>
                        </td>
                        <td>{{ $item->updated_at }}</td>
                        <td>
                            <button type="button" class="btn btn-info btn-xs">预览</button>
                            <a href="{{ url('backend/docs/edit_view/'.$item->id) }}" class="btn btn-primary btn-xs">编辑</a>
                            <button type="button" class="btn btn-success btn-xs">导出</button>
                            <button type="button" class="btn btn-danger btn-xs" onclick="delete_doc({{ $item->id }})">删除</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="width: 100%;text-align: center;">
                <nav>
                    <ul class="pagination">
                        <li {{ $page-1 > 0 ? "" : "class=disabled" }}>
                            <a href="{{ $page-1 > 0 ? $data->url($page-1) : "#" }}">&laquo;</a>
                        </li>
                        <?php
                            if($page <= 3) {
                                $start = 1;
                            } else {
                                $start = $page - 2;
                            }
                        ?>
                        @for($i = $start; $i < $start + 5 && $i <= $data->lastPage() ; $i++)
                            <li {{ $page == $i ? "class=active" : "" }}><a href="{{ $data->url($i) }}">{{ $i }}</a></li>
                        @endfor
                        <li {{ $data->lastPage() != $page && !empty($data->lastPage()) ? "" : "class=disabled" }}>
                            <a href="{{ $data->lastPage() != $page && !empty($data->lastPage()) ? $data->nextPageUrl() : "#" }}">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection

@section('init')
    @include('backend.delete')
    @include('backend.warn')
    <script type="text/javascript">
        //初始化数据
        $(function () {
            var active = 'docs';
            $('#'+active).addClass('active');
        });

        function delete_doc(id) {
            delete_id = id;
            $('#delete_confirm').modal('show');
        }

        $("#delete_yes").click(function () {
            $('#delete_confirm').modal('hide');
            window.location.href = ('{!! url('backend/docs/delete/?page='.$page.'&id=') !!}' + delete_id);
        });
    </script>


@endsection