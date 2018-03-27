@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="card col-md-10 col-md-offset-1">
            <div class="card-body">
                <h4>
                    <i class="material-icons">settings</i> 编辑个人资料
                </h4>
            </div>
            <hr>
            @include('common.error')
            <div class="card-body">

                <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="name-field">用户名</label>
                        <input class="form-control" type="text" name="name" id="name-field" value="{{ old('name', $user->name ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="email-field">邮 箱</label>
                        <input class="form-control" type="text" name="email" id="email-field" value="{{ old('email', $user->email ) }}" />
                    </div>
                    <div class="form-group">
                        <label for="introduction-field">个人简介</label>
                        <textarea name="introduction" id="introduction-field" class="form-control" rows="3">{{ old('introduction', $user->introduction ) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="customFile">上传用户头像</label>
                        <input type="file" class="form-control-file" name="avatar" id="customFile">

                    </div>

                    @if($user->avatar)
                        <div class="form-group">
                        <img class="img-thumbnail" src="{{ config('app.url').$user->avatar }}" width="200" />
                        </div>
                    @endif
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection