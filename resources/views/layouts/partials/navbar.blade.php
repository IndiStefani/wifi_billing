{{-- resources/views/layouts/partials/navbar.blade.php --}}
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        @auth
            <li class="nav-item d-none d-sm-inline-block mr-2">
                <span class="nav-link">{{ auth()->user()->name }}</span>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-default btn-sm nav-link" style="border:none; background:none; padding:0;">Logout</button>
                </form>
            </li>
        @endauth
    </ul>
</nav>
