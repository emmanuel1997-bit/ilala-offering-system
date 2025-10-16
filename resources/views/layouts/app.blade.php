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


    <!-- Favicon -->
    <link rel="icon" href="{{ asset('storage/images/steward.png') }}" type="image/png">

    <!-- Custom CSS -->
    {{-- <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" /> --}}

    <!-- DataTables -->

    <!-- Bootstrap CSS -->
    {{-- <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" /> --}}
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-..." crossorigin="anonymous">

<!-- Bootstrap JS (requires Popper) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-..." crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Icons -->
    {{-- <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" /> --}}

    <style>

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
.modal .form-control {
    background-color: #fff !important;
    color: #000 !important;
    border: 2px solid #ccc !important;
}
.form-check-input {
    width: 1.2em;
    height: 1.2em;
    cursor: pointer;
    accent-color: #064e3b; /* Dark green accent */
    border: 2px solid #ccc;
    border-radius: 4px;
}

.modal label {
    color: #064e3b !important;
    font-weight: 500;
}

.modal-content {
    background-color: #fefefe !important;
    border-radius: 0.75rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}
    .nav-pills .nav-link {
        font-weight: 400;
        font-size: 1rem;
        border-radius: 0.5rem;
        transition: background 0.2s;
        color: #222 !important;
        background: #fff;
    }
    .nav-pills .nav-link.active {
        background: #064e3b !important;
        color: #fff !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .card-header {
        background: #f8f9fa;
    }
    .btn-primary {
        background-color: #064e3b !important;
        border-color: #064e3b !important;
    }

.modal-backdrop.show {
    opacity: 0.7;
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
