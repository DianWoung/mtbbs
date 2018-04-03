@extends('layouts.app')

@section('content')

        <div class="col-md-10 col-md-offset-1">
            <div class="list-group" id="keyword">
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                    <p class="mb-1">包含"{{ $query }}"的条目有{{ $num }}个</p>
                </div>
                @foreach($topics as $topic)
                <div class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1" style="font-weight:bold;"><a href="{{ route('topics.show', [$topic->id]) }}">{!! str_replace($query,"<span style='color:red;'>".$query."</span>",$topic->title) !!}</a></h5>
                        <small>{{ $topic->updated_at->diffForHumans() }}</small>
                    </div>
                    <div class="d-flex w-100 justify-content-between">
                    <p class="mb-1" style="width: 90%;word-wrap:break-word;
word-break:break-all;">{{ $topic->excerpt }}</p>
                    </div>
                </div>
                 @endforeach
            </div>

            <nav style="margin-top: 15px">
                {!! $topics->render() !!}
            </nav>
            <hr>
        </div>
@endsection