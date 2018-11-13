@extends('admin.index')
@section('manage_content')
    <div class="card">
        <div class="card-header">
            <p>编辑用户信息</p>
        </div>
        <div class="card-body">
            <form  action="{{ route('admin::users.update', $user->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <label for="username">用户名</label>
                    <input type="text" class="form-control" name="name" id="username" aria-describedby="nameHelp" placeholder="输入名称" value="{{ old('name', $user->name) }}">
                    <small id="nameHelp" class="form-text text-muted">汉字或英文均可</small>
                </div>
                <div class="form-group">
                    <label for="InputEmail">Email</label>
                    <input type="email" class="form-control" name="email" id="InputEmail1" aria-describedby="emailHelp" placeholder="Enter email" value="{{ old('email', $user->email) }}">
                    <small id="emailHelp" class="form-text text-muted">必须为有效的邮箱格式</small>
                </div>
                <div class="form-group">
                    <label for="InputPassword">密码</label>
                    <input type="password" class="form-control" name="password" id="InputPassword" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary">提交</button>
            </form>
        </div>
    </div>

@endsection