<div class="card">
    <div class="card-body">
        <a href="{{ route('topics.create') }}" class="btn btn-info btn-block" aria-label="Left Align">
            <i class="material-icons">create</i> 新建帖子
        </a>
    </div>
</div>

@if (count($active_users))
    <div class="card active-users">
        <div class="card-body">

            <div class="text-center">活跃用户</div>
            <hr>
            @foreach ($active_users as $active_user)
                <a class="media" href="{{ route('users.show', $active_user->id) }}">
                        <img src="{{ $active_user->avatar }}" width="24px" height="24px" class="img-responsive rounded-circle mr-3">
                    <div class="media-body">
                        <span class="mt-0 mb-1">{{ $active_user->name }}</span>
                    </div>
                </a>
                <hr>
            @endforeach
        </div>
    </div>
@endif

@if (count($links))
    <div class="card active-users">
        <div class="card-body">

            <div class="text-center">文章推荐</div>
            <hr>
            @foreach ($links as $link)
                <a class="media" href="{{ $link->link }}">
                    <div class="media-body">
                        <span class="mt-0 mb-1">{{ $link->title }}</span>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
@endif