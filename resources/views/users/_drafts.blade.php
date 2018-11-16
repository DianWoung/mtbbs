@if (count($drafts))

    <div class="list-group list-group-flush">
        @foreach ($drafts as $draft)
            <a class="list-group-item list-group-item-action" href="{{ route('topics.show', $draft->id) }}">
                {{ $draft->title }}

                <span class="meta pull-right">
                    保存时间
                <span> ⋅ </span>
                    <i class="material-icons">access_time</i>{{ $draft->created_at->diffForHumans() }}
            </span>
            </a>
        @endforeach
    </div>

@else
    <div class="empty-block">暂无数据 ~_~ </div>
@endif
{{-- 分页 --}}
{!! $drafts->links() !!}