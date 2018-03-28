@if (count($topics))

    <div class="list-group list-group-flush">
        @foreach ($topics as $topic)
                <a class="list-group-item list-group-item-action" href="{{ route('topics.show', $topic->id) }}">
                    {{ $topic->title }}

                <span class="meta pull-right">
                {{ $topic->reply_count }} 回复
                <span> ⋅ </span>
                    {{ $topic->created_at->diffForHumans() }}
            </span>
                </a>
        @endforeach
    </div>

@else
    <div class="empty-block">暂无数据 ~_~ </div>
@endif
{{-- 分页 --}}
{!! $topics->render() !!}