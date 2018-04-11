@if (Session::has('message'))
    <msg-box type="info" message="{{ Session::get('message') }}"></msg-box>
@endif

@if (Session::has('success'))
    <msg-box type="success" message="{{ Session::get('success') }}"></msg-box>
@endif

@if (Session::has('danger'))
    <msg-box type="warning" message="{{ Session::get('warning') }}"></msg-box>
@endif