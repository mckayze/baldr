<!DOCTYPE html>
<html lang="en">
<head>
    @include('templates.backend.master.partials.head')
    @yield('head')
</head>
<body>
<div class="wrapper">
    @include('templates.backend.master.partials.main-header')
    @include('templates.backend.master.partials.sidebar')

    <div class="main-panel">
        @yield('content')
        @include('templates.backend.master.partials.footer')
    </div>

    @include('templates.backend.master.partials.quick-sidebar')
</div>
@include('templates.backend.master.partials.javascript')
@yield('javascript')
</body>
</html>