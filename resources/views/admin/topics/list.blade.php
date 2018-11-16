@extends('admin.index')
@section('manage_content')
<div class="card ">
    <div class="card-header">文章列表</div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>文章名称</th>
                <th>作者名字</th>
                <th>是否置顶</th>
                <th>操作</th>
                <th>置顶</th>
            </tr>
            </thead>
            <tbody>
            @foreach($topics as $topic)
                <tr>
                    <td>{{ $topic->title }}</td>
                    <td>{{ $topic->user->name }}</td>
                    <td><p style="color:blue">{{ $topic->sticky ? '是':'否' }}</p></td>
                    <td>
                        <form action="{{ route('admin::topics.destroy', $topic->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger btn-sm">
                                删除
                            </button>
                        </form>
                    </td>
                    <td>
                        @if($topic->sticky == 1)
                            <form action="{{ route('admin::topics.unset-sticky', $topic->id) }}" method="post">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-info btn-sm">
                                    取消置顶
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin::topics.set-sticky', $topic->id) }}" method="post">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-info btn-sm">
                                    设为置顶
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
        {{ $topics->links() }}
    </div>
</div>
    </div>
</div>
@endsection