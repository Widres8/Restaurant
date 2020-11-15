<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@section('head') @include('shared.head') @show
<style>
    @media (max-width: 991.98px) {
        .footer .author>ul li {
            display: inline-block;
            text-align: right;
        }
    }

    .footer,
    .footer a {
        width: 100%;
        left: 0;
        background-color: transparent;
        color: white;
    }
</style>

<body>

    @yield('content') @section('footer') @include('shared.footer') @show
</body>

</html>
