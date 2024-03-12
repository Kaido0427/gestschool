<!DOCTYPE html>
<html lang="en">

  @include('includes._body_head')

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        @include('includes._sidebar')

        @include('includes._menu')

        @yield('content')
        
    </div>
      @include('includes._footer')

    @include('includes._body_script')
    
</body>
</html>
