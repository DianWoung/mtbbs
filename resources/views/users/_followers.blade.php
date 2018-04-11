{{-- 关注列表 --}}
<div class="card" style="margin-top: 25px;">
    <div class="card-body">
        @if ($tag == 'followers')
        <h5>关注TA的人</h5>
        @elseif($tag == 'following')
        <h5>TA关注的人</h5>
        @endif

        @if (count($followers))
            <ul class="list-group">
                @foreach ($followers as $follower)
                    <li class="list-group-item">
                        <a href="{{route('users.show', $follower->id)}}">
                            <span class="user-avatar pull-left">
                                <img src="{{config('app.url').Auth::user()->avatar}}" class="img-responsive rounded-circle" width="30px" height="30px">
                            </span>
                            <span style="margin-left: 5px">
                            {{ $follower->name }}
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>

        @else
            <div class="empty-block">暂无数据 ~_~ </div>
        @endif

    </div>
</div>