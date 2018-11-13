@extends('layouts.app')

@section('title', '后台管理')

@section('content')

    <div class="row">
        <div class="col-lg-3 col-md-3 sidebar">
            @include('admin._menu')
        </div>

        <div class="col-lg-9 col-md-9">
            @yield('manage_content')
        </div>
    </div>

@endsection