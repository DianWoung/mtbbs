@if (count($topics))

    <ul class="list-group list-group-flush">
        @if(count($sticky))
        @foreach ($sticky as $stick)
            <li class="list-group-item flex-column">
                <div class="media">
                    <a class="mr-3" href="{{ route('users.show', [$stick->user_id]) }}">
                        <img class="img-thumbnail rounded-circle" style="width: 52px; height: 52px;" src="{{ $stick->user->avatar }}" title="{{ $stick->user->name }}">
                    </a>
                    <div class="media-body">

                        <h5 class="mt-0">
                            <span class="badge badge-info">置顶</span>
                            <a href="{{ route('topics.show', [$stick->id]) }}">
                                {{ $stick->title }}
                            </a>
                        </h5>

                        <span class="badge badge-secondary badge-pill float-right" style="background-color: #cccccc"> {{ $stick->reply_count }} </span>

                        <div class="media-body meta">
                            <a href="{{ route('categories.show', $stick->category->id) }}" title="{{ $stick->category->name }}">
                                <i class="material-icons md-18">folder</i>
                                {{ $stick->category->name }}
                            </a>
                            <span> • </span>
                            <a href="{{ route('users.show', [$stick->user_id]) }}" title="{{ $stick->user->name }}">
                                <i class="material-icons md-18">account_circle</i>
                                {{ $stick->user->name }}
                            </a>
                            <span> • </span>
                            <i class="material-icons md-18">access_time</i>
                            <span class="timeago" title="最后活跃于">{{ $stick->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        @endif
        @foreach ($topics as $topic)
            <li class="list-group-item flex-column">
                <div class="media">
                 <a class="mr-3" href="{{ route('users.show', [$topic->user_id]) }}">
                     <img class="img-thumbnail rounded-circle" style="width: 52px; height: 52px;" src="{{ $topic->user->avatar }}" title="{{ $topic->user->name }}">
                 </a>
                <div class="media-body">
                    <h5 class="mt-0">
                        <a href="{{ route('topics.show', [$topic->id]) }}">
                            {{ $topic->title }}
                        </a>
                    </h5>

                    <span class="badge badge-secondary badge-pill float-right" style="background-color: #cccccc"> {{ $topic->reply_count }} </span>

                    <div class="media-body meta">
                        <a href="{{ route('categories.show', $topic->category->id) }}" title="{{ $topic->category->name }}">
                            <i class="material-icons md-18">folder</i>
                            {{ $topic->category->name }}
                        </a>
                        <span> • </span>
                        <a href="{{ route('users.show', [$topic->user_id]) }}" title="{{ $topic->user->name }}">
                            <i class="material-icons md-18">account_circle</i>
                            {{ $topic->user->name }}
                        </a>
                        <span> • </span>
                        <i class="material-icons md-18">access_time</i>
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