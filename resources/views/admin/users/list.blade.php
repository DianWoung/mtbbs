@extends('admin.index')
@section('manage_content')
<div class="card">
<div class="card-body">
<h5 class="card-title">用户列表</h5>
<table class="table table-hover">
    <thead>
    <tr>
        <th scope="row">ID</th>
        <th>名字</th>
        <th>邮箱</th>
        <th>头像</th>
        <th>注册时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
    <tr>
        <td>{{ $user->id }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td><img src="{{ $user->avatar }}" width="100px" /></td>
        <td>{{ $user->created_at->diffForHumans() }}</td>
        <td width="20%">
            <a href="{{ route('admin::users.edit', $user->id) }}" ><button type="button" class="btn btn-info btn-sm">编辑</button></a>
            <form action="{{ route('admin::users.destroy', $user->id) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-danger btn-sm">
                    删除
                </button>
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
</div>
    <div class="card-footer">
        {{ $users->links() }}
    </div>
</div>
    @endsection