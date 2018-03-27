@if (count($topics))

    <ul class="list-group list-group-flush">
        @foreach ($topics as $topic)
            <li class="list-group-item flex-column" href="">
                <div class="media">
                 <a class="mr-3" href="{{ route('users.show', [$topic->user_id]) }}">
                     <img class="img-thumbnail" style="width: 52px; height: 52px;" src="{{ $topic->user->avatar }}" title="{{ $topic->user->name }}">
                 </a>
                <div class="media-body">

                    <h5 class="mt-0">
                        <a href="{{ route('topics.show', [$topic->id]) }}">
                            {{ $topic->title }}
                        </a>
                    </h5>

                    <span class="badge badge-secondary badge-pill float-right"> {{ $topic->reply_count }} </span>

                    <div class="media-body meta">
                        <a href="#" title="{{ $topic->category->name }}">
                            <i class="material-icons">folder</i>
                            {{ $topic->category->name }}
                        </a>
                        <span> • </span>
                        <a href="{{ route('users.show', [$topic->user_id]) }}" title="{{ $topic->user->name }}">
                            <i class="material-icons">account_circle</i>
                            {{ $topic->user->name }}
                        </a>
                        <span> • </span>
                        <i class="material-icons">access_time</i>
                        <span class="timeago" title="最后活跃于">{{ $topic->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
                </div>
            </li>
        @endforeach
    </ul>

@else
    <div class="empty-block">暂无数据 ~_~ </div>
@endif