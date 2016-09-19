@extends('backend')

@section('content')
    <div class="panel panel-default" style="width: 50%;margin-left: 25%;margin-top: 100px;">
        <div class="panel-heading">
            <h3 class="panel-title">登陆</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="post" action="{{ url('backend/login') }}">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">邮箱</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="请输入邮箱">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="inputPassword3" name="password" placeholder="请输入密码">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-1">
                        <button type="submit" class="btn btn-primary">登陆</button>
                    </div>
                    <div class="col-sm-9">
                        <div class="checkbox">
                            <label>
                                <a href="#">忘记密码?</a>
                            </label>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
