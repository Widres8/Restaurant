<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    @section('head')
        @include('shared.head')
    @show
<body>
    <div class="main-wrapper">
            <div class="app" id="app">
                @section('header')
                    @include('shared.header')
                @show
                @section('sidebar')
                    @include('shared.sidebar')
                @show

                <div class="sidebar-overlay" id="sidebar-overlay"></div>
                <div class="sidebar-mobile-menu-handle" id="sidebar-mobile-menu-handle"></div>
                <div class="mobile-menu-handle"></div>
                <article class="content dashboard-page">
                        @if(session('info'))
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('info') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(count($errors))
                        <div class="container">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="alert alert-danger">
                                        <ul>
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @yield('content')
                </article>
                @section('footer')
                    @include('shared.footer')
                @show
            </div>
        </div>
    <!-- work with scripts for views -->
    @section('scriptsload')
        @include('shared.scripts')
    @show
    @yield('scripts')
</body>
</html>
