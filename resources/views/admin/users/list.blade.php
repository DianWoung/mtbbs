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
        <th>是否为管理员</th>
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
        <td>{{ $user->hasAnyRole(['Maintainer', 'Founder']) ? '是': '否' }}</td>
        <td>{{ $user->created_at->diffForHumans() }}</td>
        <td width="20%">
            <a href="{{ route('admin::users.edit', $user->id) }}" ><button type="button" class="btn btn-info btn-sm">编辑</button></a>
            @if(Auth::id() !== $user->id)
                <form action="{{ route('admin::users.destroy', $user->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger btn-sm">
                        删除
                    </button>
                </form>
            @endif
            @if($user->hasAnyRole(['Maintainer', 'Founder']) )
                @if(Auth::id() !== $user->id)

                <form action="{{ route('admin::users.unset-admin', $user->id) }}" method="post">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger btn-sm">
                        取消管理员
                    </button>
                </form>
                 @endif
               @else
                <form action="{{ route('admin::users.set-admin', $user->id) }}" method="post">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger btn-sm">
                        设为管理员
                    </button>
                </form>
                @endif
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