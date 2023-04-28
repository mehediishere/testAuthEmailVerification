<!DOCTYPE html>
<html>
<head>
    <title>{{ __('Verify Your Email Address') }}</title>
</head>
<body>
<div>
    <h1>{{ __('Verify Your Email Address') }}</h1>
    @if(session('message'))
        <p>{{ session('message') }}</p>
    @endif
    <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
    <p>{{ __('If you did not receive the email') }},</p>
    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">{{ __('click here to request another') }}</button>
    </form>
        <p>{{ __('If you already verified your email, please') }} <a href="{{ route('user.logout') }}">{{ __('log out') }}</a>{{ __(' and log back in.') }}</p>
</div>
</body>
</html>
