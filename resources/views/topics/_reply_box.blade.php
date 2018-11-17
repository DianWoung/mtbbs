@include('common.error')

<div class="reply-box">
    <form action="{{ route('replies.store') }}" method="POST" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="topic_id" value="{{ $topic->id }}">
        <div class="form-group">
            <textarea id="reply-box" class="form-control" rows="3" placeholder="分享你的想法" name="content"></textarea>
        </div>
        <button type="submit" class="btn btn-outline-info btn-sm"><i class="fa fa-share"></i>回复</button>
    </form>
</div>
<hr>

@section('scripts')

    $('#reply-box').atwho({
    at: "@",
    delay:750,
    callbacks: {
        remoteFilter: function (query, callback) {
            $.getJSON("/api/users",{name:query},function(usernames){
                callback(usernames)
            });
        }
     }
})

@endsection