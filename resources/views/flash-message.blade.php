

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <button type="button" class="a-close"></button>
        {{ $message }}
    </div>
@endif


@if ($message = Session::get('error'))
    <div class="alert alert-danger">
        <button type="button" class="a-close"></button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('messages'))
    @foreach($message as $m)
    <div class="alert alert-danger">
        <button type="button" class="a-close"></button>
        <strong>{{ $m }}</strong>
    </div>
    @endforeach
@endif


@if ($message = Session::get('warning'))
    <div class="alert alert-warning">
        <button type="button" class="a-close"></button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('info'))
    <div class="alert alert-info">
        <button type="button" class="a-close"></button>
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($errors->any())
    <div class="alert alert-danger">
        <button type="button" class="a-close"></button>
        {{__('notification.check_error')}}
    </div>
@endif

