<!doctype html>
<head>
@include('includes.meta')

<!-- Style -->
@stack('before-style')
@include('includes.style')
@stack('after-style')

</head>

<body>
@include('sweetalert::alert')

    <!-- Navbar -->
    @include('includes.navbar')

    <!-- side bar -->
    @include('includes.sidebar')


        <div class="content">

         

          <!-- Content -->
          @yield('content')

        </div>

        <div class="clearfix"></div>
    </div>

    @include('includes.footer')

    <!-- Script -->
    @stack('before-script')
    @include('includes.script')
    @stack('after-script')
</body>
</html>