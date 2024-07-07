@php 
$sidebar_active = Route::current()->getName();
$expand = explode('.',$sidebar_active);
$sidebar_active = (count($expand) > 0) ? $expand[0] : '';
@endphp

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ ($sidebar_active == 'dashboard') ? 'active' : '' }}" aria-current="page" href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-house"></i>
                    Dashboard
                </a>
            </li>
            @can('panel-user-managment')
            @canany(['users-list', 'users-create', 'users-edit', 'users-delete'])
            <li class="nav-item">
                <a class="nav-link {{ ($sidebar_active == 'users') ? 'active' : '' }}" aria-current="page" href="{{ route('users.index') }}">
                    <i class="fa-solid fa-user"></i>
                    Users
                </a>
            </li>
            @endcanany
            @canany(['roles-list', 'roles-create', 'roles-edit', 'roles-delete'])
            <li class="nav-item">
                <a class="nav-link {{ ($sidebar_active == 'roles') ? 'active' : '' }}" aria-current="page" href="{{ route('roles.index') }}">
                    <i class="fa-solid fa-sliders"></i>
                    Role
                </a>
            </li>
            @endcanany
            @canany(['permissions-list', 'permissions-create', 'permissions-edit', 'permissions-delete'])
            <li class="nav-item">
                <a class="nav-link {{ ($sidebar_active == 'permissions') ? 'active' : '' }}" aria-current="page" href="{{ route('permissions.index') }}">
                    <i class="fa-solid fa-gears"></i>
                    Permissions
                </a>
            </li>
            @endcanany
            @endcan

            @canany(['teachers-list', 'teachers-create', 'teachers-edit', 'teachers-delete'])
            <li class="nav-item">
                <a class="nav-link {{ ($sidebar_active == 'teachers') ? 'active' : '' }}" href="{{ route('teachers.index') }}">
                    <i class="fa-solid fa-chalkboard-user"></i>
                    Teachers
                </a>
            </li>
            @endcanany
            
            @canany(['students-list', 'students-create', 'students-edit', 'students-delete'])
            <li class="nav-item">
                <a class="nav-link {{ ($sidebar_active == 'students') ? 'active' : '' }}" href="{{ route('students.index') }}">
                    <i class="fa-solid fa-graduation-cap"></i>
                    Students
                </a>
            </li>
            @endcanany
            
            @canany(['parents-list', 'parents-create', 'parents-edit', 'parents-delete'])
            <li class="nav-item">
                <a class="nav-link {{ ($sidebar_active == 'parents') ? 'active' : '' }}" href="{{ route('parents.index') }}">
                    <i class="fa-solid fa-user-tie"></i>
                    Parents
                </a>
            </li>
            @endcanany
            
            @canany(['announcements-list', 'announcements-create', 'announcements-edit', 'announcements-delete'])
            <li class="nav-item">
                <a class="nav-link {{ ($sidebar_active == 'announcements') ? 'active' : '' }}" href="{{ route('announcements.index') }}">
                    <i class="fa-solid fa-bullhorn"></i>
                    Announcements
                </a>
            </li>
            @endcanany

            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    {{ __('Logout') }}
                </a>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</nav>