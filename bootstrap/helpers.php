<?php

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function respond($status, $respond)
{
    return response()->json(['status' => $status, is_string($respond) ? 'message' : 'data' => $respond]);
}

function succeed($respond = 'Request success!')
{
    return respond(true, $respond);
}

function failed($respond = 'Request failed!')
{
    return respond(false, $respond);
}

function make_excerpt($value, $length = 200)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($value)));
    return str_limit($excerpt, $length);
}
