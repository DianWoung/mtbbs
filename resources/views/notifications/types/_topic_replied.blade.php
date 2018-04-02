<div class="media">
        <a class="mr-3" href="{{ route('users.show', $notification->data['user_id']) }}">
            <img class="media-object img-thumbnail" alt="{{ $notification->data['user_name'] }}" src="{{ $notification->data['user_avatar'] }}"  style="width:48px;height:48px;"/>
        </a>
    <div class="infos media-body">
        <div class="mt-0">
            <a href="{{ route('users.show', $notification->data['user_id']) }}">{{ $notification->data['user_name'] }}</a>
            评论了
            <a href="{{ $notification->data['topic_link'] }}">{{ $notification->data['topic_title'] }}</a>

            {{-- 回复删除按钮 --}}
            <span class="meta pull-right" title="{{ $notification->created_at }}">
                <i class="material-icons">access_time</i>
                {{ $notification->created_at->diffForHumans() }}
            </span>
        </div>

            {!! $notification->data['reply_content'] !!}

    </div>
</div>
<hr>