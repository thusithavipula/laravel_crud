<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Welcome: {{ Auth::user()->name }}</a>
    <button type="button" id="sidebar_toggle" class="btn btn-default">
        <i class="fas fa-align-left"></i>
        <span></span>
    </button>
<!--<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">-->
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <form class="hiddne" id="logout-form" action="{{ route('admin-logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
            <a class="nav-link" href="{{ route('admin-logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
        </li>
    </ul>
</nav>

