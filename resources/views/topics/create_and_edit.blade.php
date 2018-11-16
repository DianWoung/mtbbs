@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="card">

                <div class="card-body">
                    <h2 class="text-center">
                        <i class="glyphicon glyphicon-edit"></i>
                        @if($topic->id)
                            编辑话题
                        @else
                            新建话题
                        @endif
                    </h2>

                    <hr>

                    @include('common.error')

                    @if($topic->id)
                        <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8">
                            <input type="hidden" name="_method" value="PUT">
                            @else
                                <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8">
                                    @endif

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <input class="form-control" type="text" name="title" value="{{ old('title', $topic->title ) }}" placeholder="请填写标题" required/>
                                    </div>

                                    <div class="form-group">
                                        <select class="form-control" name="category_id" required>
                                            <option value="" hidden disabled selected>请选择分类</option>
                                            @foreach ($categories as $value)
                                                <option value="{{ $value->id }}" {{ $topic->category_id == $value->id ? 'selected' : ''}}>{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" style="display:none">
                                        <text-body :val="textinput" name="body" input="{{ old('body', $topic->body) }}" @edittext="edittext" style="height: 100%"></text-body>
                                    </div>

                                    <div class="form-group">
                                        <md-editor :value="textinput" @edittextbody="edittextbody"></md-editor>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="0" id="save" name="is_publish" {{ old('is_publish', $topic->is_publish) ? '':'checked' }}>
                                            <label class="form-check-label" for="save">
                                                保存草稿
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" value="1" id="publish" name="is_publish" {{ old('is_publish', $topic->is_publish) ? 'checked':'' }}>
                                            <label class="form-check-label" for="publish">
                                                直接发布
                                            </label>
                                        </div>
                                    </div>

                                    <div class="well well-sm">
                                        <button type="submit" class="btn btn-info"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 保存</button>
                                    </div>
                                </form>
                </div>
            </div>
        </div>
    </div>
@endsection