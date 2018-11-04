<nav class="col-md-2 d-none d-md-block bg-light sidebar" id="sidebar">
    <div class="sidebar-sticky">
        <ul class="nav flex-column sidebar-menu">
            <li class="nav-item">
                <a class="nav-link" href="{{URL::route('admin-home')}}">
                    <span data-feather="home"></span>
                    Dashboard <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{URL::route('admin-subjects')}}">
                    <span data-feather="clipboard"></span>
                    Subjects
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{URL::route('admin-instructors')}}">
                    <span data-feather="user"></span>
                    Instructors
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{URL::route('admin-students')}}">
                    <span data-feather="users"></span>
                    Students
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{URL::route('admin-settings')}}">
                    <span data-feather="settings"></span>
                    Settings
                </a>
            </li>
        </ul>
    </div>
</nav>

