@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('content')
    <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
            <div class="card">
                <div class="card-body">

                        <img class="img-fluid img-thumbnail rounded" src="{{ config('app.url').$user->avatar }}" width="300px" height="300px">
                        <div class="media-body">
                            <hr>
                            <div class="follow-info row">
                                <div class="col-sm-4">
                                    <a class="counter" href="{{ route('users.following', $user->id) }}">{{ $user->followingCount }}</a>
                                    <a class="text" href="">关注</a>
                                </div>
                                <div class="col-sm-4">
                                    <a class="counter" href="{{ route('users.followers', $user->id) }}">{{ $user->followersCount }}</a>
                                    <a class="text" href="">关注者</a>
                                </div>
                                <div class="col-sm-4">
                                    <a class="counter" href="{{ route('users.show', $user->id) }}">{{ $user->topicsCount }}</a>
                                    <a class="text" href="">文章</a>
                                </div>
                            </div>

                            @if(Auth::user()->id !== $user->id)
                            <hr>
                            <follow-button id="{{ $user->id }}" status="{!! Auth::user()->isFollowed($user->id)? "true":"false" !!}"></follow-button>
                            @endif
                            <hr>
                            <h4><strong>个人简介</strong></h4>
                            <p>{{ $user->introduction }} </p>
                            <hr>
                            <h4><strong>注册于</strong></h4>
                            <p>{{ $user->created_at->diffForHumans() }}</p>
                            <hr>
                            <h4><strong>最后活跃</strong></h4>
                            <p title="{{  $user->last_actived_at }}">{{ $user->last_actived_at->diffForHumans() }}</p>
                        </div>
                    </div>

            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-body">
                    <h2 style="font-size:30px;">{{ $user->name }} <small>{{ $user->email }}</small></h2>
                </div>
            </div>
            @if($type == 'tab')
            @include('users._tab',['user' => $user])
                @endif
            @if($type == 'followers')
                @include('users._followers',['followers' => $followers, 'tag' => $tag])
                @endif

        </div>
    </div>
@stop