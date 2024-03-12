<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ URL::asset('dist/img/logo.png') }}" alt="AppLogo" height="60" width="60">
</div>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a class="nav-link">Tableau de bord</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link"> @yield('title')</a>
        </li>
    </ul>

</nav>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <a href="/logout"><img src="{{ URL::asset('dist/img/logo.png') }}" class="img-circle elevation-2"
                        alt="User Image"> </a>
            </div>
            <div class="info">
                <a href="#" class="d-block"> {{ Auth::user()->name . ' ' . Auth::user()->firstname }} </a>
            </div>
        </div>
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                @if (Auth::user() && Auth::user()->type == 'student')
                    @include('includes._student_sidebar')
                @elseif ((Auth::user() && Auth::user()->type == 'admin') || Auth::user()->type == 'personal')
                    @include('includes._admin_sidebar')
                @elseif (Auth::user() && Auth::user()->type == 'teacher')
                    @include('includes._teacher_sidebar')
                @elseif (Auth::user())
                @endif
            </ul>
        </nav>
    </div>

</aside>
