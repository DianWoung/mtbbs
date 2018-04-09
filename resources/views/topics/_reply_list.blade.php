<div class="reply-list list-unstyled">
    @foreach ($replies as $index => $reply)
        <div class=" media"  name="reply{{ $reply->id }}" id="reply{{ $reply->id }}">
                <a href="{{ route('users.show', [$reply->user_id]) }}" class="mr-3">
                    <img class="media-object img-thumbnail" alt="{{ $reply->user->name }}" src="{{ $reply->user->avatar }}"  style="width:48px;height:48px;"/>
                </a>
            <div class="media-body">
                <h5 class="mt-0 mb-1">
                    <a href="{{ route('users.show', [$reply->user_id]) }}" title="{{ $reply->user->name }}">
                        {{ $reply->user->name }}
                    </a>
                    <span> •  </span>
                    <span class="meta" title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</span>

                    {{-- 回复删除按钮 --}}
                    @can('destroy',$reply)
                    <span class="meta pull-right">
                        <form action="{{ route('replies.destroy', $reply->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-sm btn-danger" style="padding: 0">
                            <i class="material-icons">delete</i>
                             </button>
                        </form>
                    </span>
                        @endcan
                </h5>
                    {!! $reply->content !!}
            </div>
            </div>
        <hr>
    @endforeach
</div>
{{-- 分页 --}}
{!! $replies->links() !!}