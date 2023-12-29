@include('layouts.dashboard._head')

<body class="hold-transition skin-blue sidebar-mini">

<div class="wrapper">

    @include('layouts.dashboard._header')


    @include('layouts.dashboard._aside')

        @yield('content')

    @include('partials._session')


    @include('layouts.dashboard._footer')


</div><!-- end of wrapper -->

{{--<!-- Bootstrap 3.3.7 -->--}}
@include('layouts.dashboard._footer-scripts')
@stack('scripts')

</body>
</html>
