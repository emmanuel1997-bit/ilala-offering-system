<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ilala SDA Church Offering Management</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
     <link rel="icon" href="{{ asset('storage/images/steward.png') }}" type="image/png">

    <style>
        /* Sidebar styling */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #022e1a;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            transition: width 0.3s, transform 0.3s ease-in-out;
            overflow-y: auto;
            z-index: 1200;
            box-shadow: 2px 0 8px rgba(0,0,0,0.15);
        }
        .sidebar.collapsed {
            width: 64px;
        }
        .sidebar.collapsed .sidebar-header h2,
        .sidebar.collapsed ul li a span,
        .sidebar.collapsed ul li button span {
            display: none !important;
        }
        .sidebar.collapsed ul li a,
        .sidebar.collapsed ul li button {
            justify-content: center;
        }

        .sidebar .sidebar-header {
            padding: 20px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            border-radius: 8px;
            margin: 5px 10px;
        }

        .sidebar ul li a:hover {
            background-color: #236121;
        }

        .sidebar ul li.active > a {
            background-color: #fff;
            color: #157347;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .sidebar ul li.active > a i {
            color: #157347;
        }

        .sidebar ul li ul.submenu {
            display: none;
        }

        .sidebar ul li.open > ul.submenu {
            display: block;
        }

        .sidebar ul li ul.submenu li a {
            padding-left: 40px;
            background-color: #12803d;
        }

        .sidebar ul li ul.submenu li.active > a {
            background-color: #fff;
            color: #157347;
        }

        .sidebar-toggle {
            display: none;
            background-color: #512b06;
            color: #fff;
            width: 40px;
            height: 40px;
            text-align: center;
            line-height: 40px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                box-shadow: 2px 0 8px rgba(0,0,0,0.15);
                width: 80vw;
                max-width: 320px;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .sidebar-toggle {
                display: flex !important;
            }
            .content {
                margin-left: 0 !important;
            }
            .top-bar {
                left: 0 !important;
            }
        }

        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgba(255,255,255,0.3);
            border-radius: 3px;
        }

        /* Top App Bar */
        .top-bar {
            position: fixed;
            top: 0;
            left: 250px; /* same as sidebar width */
            right: 0;
            height: 60px;
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 20px;
            z-index: 1200;
            transition: left 0.3s ease-in-out;
        }

        @media (max-width: 768px) {
            .top-bar {
                left: 0;
            }
        }

        .top-bar .profile-menu {
            position: relative;
        }

        .top-bar .profile-btn {
            display: flex;
            align-items: center;
            cursor: pointer;
            gap: 8px;
            padding: 6px 12px;
            border-radius: 8px;
            transition: background 0.2s;
        }

        .top-bar .profile-btn:hover {
            background-color: #f3f4f6;
        }

        .top-bar .profile-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 50px;
            background-color: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            min-width: 180px;
            z-index: 1300;
        }

        .top-bar .profile-dropdown a {
            display: block;
            padding: 10px 15px;
            color: #374151;
            text-decoration: none;
            transition: background 0.2s;
        }

        .top-bar .profile-dropdown a:hover {
            background-color: #f3f4f6;
        }

        .profile-menu.open .profile-dropdown {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100">

    @auth
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar">
            <!-- Collapse/Expand Button -->
            <button id="collapseSidebarBtn" class="absolute top-4 right-4 bg-white text-[#157347] rounded-full shadow p-2 z-50" style="width:32px;height:32px;" onclick="toggleCollapseSidebar()" aria-label="Collapse sidebar">
                <i class="fas fa-angle-double-left" id="collapseIcon"></i>
            </button>
            @include('layouts.sidebar')
        </div>

        <!-- Top App Bar -->
<div class="top-bar flex items-center justify-between px-4 md:px-6">
    <!-- Left: optional logo or title -->
    <div class="flex items-center gap-2">
        <button class="md:hidden text-green-700 text-xl" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
        <span class="font-bold text-green-700 text-lg">ILALA SDA CHURCH</span>
    </div>

    <!-- Right: profile & language -->
    <div class="flex items-center gap-4">
        <!-- Language Switcher -->
        <div class="relative" id="langMenu">
            <button class="flex items-center gap-1 px-2 py-1 rounded hover:bg-gray-100" onclick="toggleLangDropdown()">
                <i class="fas fa-globe"></i>
                <span class="hidden md:inline">{{ strtoupper(app()->getLocale()) }}</span>
                <i class="fas fa-chevron-down text-sm"></i>
            </button>
            <div class="absolute right-0 mt-2 w-32 bg-white border rounded shadow-lg hidden z-50" id="langDropdown">
                <a href="
                {{ route('locale.switch', 'en') }}
                 " class="block px-4 py-2 hover:bg-gray-100">English</a>
                <a href="
                {{ route('locale.switch', 'sw') }}
                 " class="block px-4 py-2 hover:bg-gray-100">Swahili</a>
                <!-- Add more languages if needed -->
            </div>
        </div>

        <!-- Profile Menu -->
       <div class="relative" id="profileMenu">
    <button type="button"
        class="profile-btn flex items-center gap-2 cursor-pointer px-2 py-1 rounded hover:bg-gray-100 focus:outline-none"
        onclick="toggleProfileDropdown()">
        <img src="{{ Auth::user()->profile_photo_url ?? asset('storage/images/steward.png') }}"
            alt="Profile" class="h-8 w-8 rounded-full object-cover">
        <span class="hidden md:inline font-medium">{{ Auth::user()->name }}</span>
        <i class="fas fa-chevron-down text-gray-500"></i>
    </button>

    <div id="profileDropdown"
        class="absolute right-0 mt-2 w-44 bg-white border rounded-lg shadow-lg hidden z-50 transition-all duration-200 ease-in-out">
        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">
    <i class="fas fa-user mr-2 text-green-600"></i> Profile
    </a>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="block px-4 py-2 hover:bg-gray-100">
           <i class="fas fa-sign-out-alt mr-2 text-red-500"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
    </div>
</div>

    </div>
</div>



        <!-- Authenticated Page Content -->
        <div class="content pt-16">
            @yield('content')
        </div>
    @else
        <!-- Guest (Login/Register) Page -->
        <div class="min-h-screen flex items-center justify-center">
            @yield('content')
        </div>
    @endauth

    <script>
        // Collapse/Expand sidebar
        function toggleCollapseSidebar() {
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('collapseIcon');
            sidebar.classList.toggle('collapsed');
            if (sidebar.classList.contains('collapsed')) {
                icon.classList.remove('fa-angle-double-left');
                icon.classList.add('fa-angle-double-right');
            } else {
                icon.classList.remove('fa-angle-double-right');
                icon.classList.add('fa-angle-double-left');
            }
        }
        // Toggle submenu visibility
        function toggleSubmenu(event) {
            event.preventDefault();
            const parent = event.currentTarget.parentElement;
            parent.classList.toggle('open');
        }

        // Toggle sidebar visibility on small screens
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }

        // Toggle profile dropdown
        function toggleProfileDropdown() {
            const menu = document.getElementById('profileMenu');
            menu.classList.toggle('open');
        }
    </script>

    <script>
    function toggleLangDropdown() {
        document.getElementById('langDropdown').classList.toggle('hidden');
    }

    function toggleProfileDropdown() {
        document.getElementById('profileMenu').querySelector('.profile-dropdown').classList.toggle('hidden');
    }

    // Close dropdowns if clicked outside
    document.addEventListener('click', function(e) {
        const langMenu = document.getElementById('langMenu');
        const profileMenu = document.getElementById('profileMenu');

        if (!langMenu.contains(e.target)) {
            document.getElementById('langDropdown').classList.add('hidden');
        }

        if (!profileMenu.contains(e.target)) {
            profileMenu.querySelector('.profile-dropdown').classList.add('hidden');
        }
    });
</script>
<script>
    // Toggle Language Dropdown
    function toggleLangDropdown() {
        const dropdown = document.getElementById('langDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Toggle Profile Dropdown
    function toggleProfileDropdown() {
        const dropdown = document.getElementById('profileDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Close dropdowns when clicking outside
    window.addEventListener('click', function (e) {
        const langMenu = document.getElementById('langMenu');
        const langDropdown = document.getElementById('langDropdown');
        const profileMenu = document.getElementById('profileMenu');
        const profileDropdown = document.getElementById('profileDropdown');

        // Close language dropdown
        if (langMenu && !langMenu.contains(e.target)) {
            langDropdown.classList.add('hidden');
        }

        // Close profile dropdown
        if (profileMenu && !profileMenu.contains(e.target)) {
            profileDropdown.classList.add('hidden');
        }
    });
</script>


</body>
</html>
