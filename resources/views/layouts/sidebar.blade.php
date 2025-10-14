<div class="sidebar" id="sidebar">
    <div class="sidebar-header flex flex-col items-center">
        <!-- Church Logo -->
        <img src="{{ asset('storage/images/steward.png') }}" alt="Ilala SDA Logo" class="w-16 h-16 rounded-full mb-2">
        <h2 class="text-lg font-bold">Ilala SDA</h2>
    </div>

    <ul>
        <li class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
            <a href="{{ route('dashboard.admin') }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </li>

        <li class="{{ request()->routeIs('offerings.*') ? 'active open' : '' }}">
            <a href="#" onclick="toggleSubmenu(event)">
                <i class="fas fa-hand-holding-dollar"></i> Offerings
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <ul class="submenu">
                <li class="{{ request()->routeIs('offerings.today') ? 'active' : '' }}">
                    <a href="#">Today's Offerings</a>
                </li>
                <li class="{{ request()->routeIs('offerings.all') ? 'active' : '' }}">
                    <a href="#">All Offerings</a>
                </li>
            </ul>
        </li>

        <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a href="#">
                <i class="fas fa-users"></i> Users
            </a>
        </li>

        <li class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <a href="#">
                <i class="fas fa-chart-line"></i> Reports
            </a>
        </li>

       <li>
    <a href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="GET" class="d-none">
        @csrf
    </form>
    </li>

    </ul>
</div>
