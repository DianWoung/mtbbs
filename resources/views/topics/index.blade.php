@extends('layouts.app')

@section('title', isset($category) ? $category->name : '话题列表')

@section('content')

    <div class="row">
        <div class="col-lg-9 col-md-9">
            @if (isset($category))
                <div class="alert alert-info" role="alert">
                    {{ $category->name }} ：{{ $category->description }}
                </div>
            @endif

            <div class="card">
                <div class="card-body topic-list">
                    <ul class="nav nav-pills">
                        <li role="presentation" class="nav-item">
                            <a href="#" class="nav-link active">最后回复</a>
                        </li>
                        <li role="presentation" class="nav-item">
                            <a href="#" class="nav-link">最新发布</a>
                        </li>
                    </ul>
                    <br>
                    {{-- 话题列表 --}}
                    @include('topics._topic_list', ['topics' => $topics])
                    {{-- 分页 --}}
                    <br>
                    {!! $topics->render() !!}
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 sidebar">
            @include('topics._sidebar')
        </div>
    </div>

@endsection