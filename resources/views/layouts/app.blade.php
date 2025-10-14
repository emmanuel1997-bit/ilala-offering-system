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

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/images/steward.png') }}" type="image/png">

    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <!-- Icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
        /* ===================== Sidebar ===================== */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #022e1a;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            transition: width 0.3s, transform 0.3s ease-in-out;
            box-shadow: 2px 0 8px rgba(0,0,0,0.15);
            z-index: 1030;
        }
        .sidebar.collapsed {
            width: 64px;
        }
        .sidebar.collapsed .sidebar-header h2,
        .sidebar.collapsed ul li a span,
        .sidebar.collapsed ul li button span {
            display: none !important;
        }
        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            color: #fff;
            font-weight: 500;
            text-decoration: none;
            border-radius: 8px;
            margin: 5px 10px;
            transition: all 0.2s ease-in-out;
        }
        .sidebar ul li a:hover {
            /* background-color: #236121; */
        }
        .sidebar ul li.active > a {
            background-color: #fff;
            color: #157347;
            font-weight: 600;
        }

        /* ===================== Top App Bar ===================== */
        .top-bar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            height: 60px;
            background-color: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            transition: left 0.3s ease-in-out;
            z-index: 1040;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 80vw;
                max-width: 320px;
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .top-bar {
                left: 0;
            }
        }

        /* ===================== Content ===================== */
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease-in-out;
        }
        @media (max-width: 768px) {
            .content {
                margin-left: 0;
            }
        }

        /* ===================== Modal Fix ===================== */
        .modal {
            z-index: 2000 !important;
        }
        .modal-backdrop {
            z-index: 1990 !important;
        }

        /* ===================== Scrollbar ===================== */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-thumb {
            background-color: rgba(255,255,255,0.3);
            border-radius: 3px;
        }
    </style>
</head>
<body class="bg-gray-100">

    @auth
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <button id="collapseSidebarBtn"
                class="absolute top-4 right-4 bg-white text-[#157347] rounded-full shadow p-2 z-50"
                style="width:32px;height:32px;" onclick="toggleCollapseSidebar()" aria-label="Collapse sidebar">
            <i class="fas fa-angle-double-left" id="collapseIcon"></i>
        </button>
        @include('layouts.sidebar')
    </div>

    <!-- Top App Bar -->
    <div class="top-bar">
        <div class="flex items-center gap-2">
            <button class="md:hidden text-green-700 text-xl" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <span class="font-bold text-green-700 text-lg">ILALA SDA CHURCH</span>
        </div>

        <div class="flex items-center gap-4">
            <!-- Language Dropdown -->
            <div class="relative" id="langMenu">
                <button class="flex items-center gap-1 px-2 py-1 rounded hover:bg-gray-100" onclick="toggleLangDropdown()">
                    <i class="fas fa-globe"></i>
                    <span class="hidden md:inline">{{ strtoupper(app()->getLocale()) }}</span>
                    <i class="fas fa-chevron-down text-sm"></i>
                </button>
                <div id="langDropdown" class="absolute right-0 mt-2 w-32 bg-white border rounded shadow-lg hidden z-50">
                    <a href="{{ route('locale.switch', 'en') }}" class="block px-4 py-2 hover:bg-gray-100">English</a>
                    <a href="{{ route('locale.switch', 'sw') }}" class="block px-4 py-2 hover:bg-gray-100">Swahili</a>
                </div>
            </div>

            <!-- Profile Dropdown -->
            <div class="relative" id="profileMenu">
                <button type="button"
                        class="profile-btn flex items-center gap-2 cursor-pointer px-2 py-1 rounded hover:bg-gray-100"
                        onclick="toggleProfileDropdown()">
                    <img src="{{ Auth::user()->profile_photo_url ?? asset('storage/images/steward.png') }}"
                         alt="Profile" class="h-8 w-8 rounded-full object-cover">
                    <span class="hidden md:inline font-medium">{{ Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down text-gray-500"></i>
                </button>
                <div id="profileDropdown"
                     class="absolute right-0 mt-2 w-44 bg-white border rounded-lg shadow-lg hidden z-50">
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

    <!-- Page Content -->
    <div class="content pt-16">
        @yield('content')
    </div>

    @else
    <!-- Guest Layout -->
    <div class="min-h-screen flex items-center justify-center">
        @yield('content')
    </div>
    @endauth

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleCollapseSidebar() {
            const sidebar = document.getElementById('sidebar');
            const icon = document.getElementById('collapseIcon');
            sidebar.classList.toggle('collapsed');
            icon.classList.toggle('fa-angle-double-right');
            icon.classList.toggle('fa-angle-double-left');
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }

        function toggleLangDropdown() {
            document.getElementById('langDropdown').classList.toggle('hidden');
        }

        function toggleProfileDropdown() {
            document.getElementById('profileDropdown').classList.toggle('hidden');
        }

        window.addEventListener('click', function (e) {
            const langMenu = document.getElementById('langMenu');
            const langDropdown = document.getElementById('langDropdown');
            const profileMenu = document.getElementById('profileMenu');
            const profileDropdown = document.getElementById('profileDropdown');

            if (langMenu && !langMenu.contains(e.target)) langDropdown.classList.add('hidden');
            if (profileMenu && !profileMenu.contains(e.target)) profileDropdown.classList.add('hidden');
        });
    </script>

</body>
</html>
