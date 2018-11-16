@extends('layouts.app')

@section('title', '后台管理')

@section('content')

    <div class="row">
        <div class="col-lg-2 col-md-2 sidebar">
            @include('admin._menu')
        </div>

        <div class="col-lg-10 col-md-10">
            @yield('manage_content')
        </div>
    </div>

@endsection