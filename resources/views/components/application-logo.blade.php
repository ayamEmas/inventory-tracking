@php
    $isLoginPage = request()->is('/');
@endphp

<img src="{{ asset('image/qul.png') }}" alt="QHSB Logo" class="{{ $isLoginPage ? 'h-16' : 'h-12' }}">
