<div class="card">
    <div class="card-body">
        <a href="{{ route('topics.create') }}" class="btn btn-info btn-block" aria-label="Left Align">
            <i class="material-icons">create</i> 新建帖子
        </a>
    </div>
</div>
@if (count($links))
    <div class="card active-users">
        <div class="card-body">

            <div class="text-center">文章推荐</div>
            <hr>
            @foreach ($links as $link)
                <a class="media" href="{{ $link->link }}">
                    <div class="media-body">
                        <span class="media-heading">{{ $link->title }}</span>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
@endif