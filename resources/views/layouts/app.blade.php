<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ilala SDA Church Offering Management</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* Sidebar styling */
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #157347;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            transition: width 0.3s ease, transform 0.3s ease;
            overflow-y: auto;
            z-index: 1000;
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
            transition: background 0.2s;
        }

        .sidebar ul li a:hover,
        .sidebar ul li.active > a {
            background-color: #0f5a32;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        .sidebar ul li ul.submenu {
            display: none;
            list-style: none;
            padding-left: 0;
        }

        .sidebar ul li.open > ul.submenu {
            display: block;
        }

        .sidebar ul li ul.submenu li a {
            padding-left: 40px;
            background-color: #12803d;
        }

        /* Sidebar toggle button */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 15px;
            left: 15px;
            background-color: #157347;
            color: #fff;
            width: 40px;
            height: 40px;
            text-align: center;
            line-height: 40px;
            cursor: pointer;
            border-radius: 5px;
            z-index: 1100;
        }
      /* Sidebar links default */
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

/* Hover state */
.sidebar ul li a:hover {
    background-color: #0f5a32;
}

/* ✅ Active state (the selected one) */
.sidebar ul li.active > a {
    background-color: #fff;            /* White background */
    color: #157347;                    /* Text turns green */
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1); /* Soft shadow */
}

/* Active icon color */
.sidebar ul li.active > a i {
    color: #157347;
}

/* Icons spacing */
.sidebar ul li a i {
    margin-right: 10px;
}

/* Submenu links */
.sidebar ul li ul.submenu li a {
    padding-left: 40px;
    background-color: #12803d;
}

/* Active submenu item */
.sidebar ul li ul.submenu li.active > a {
    background-color: #fff;
    color: #157347;
    font-weight: 600;
}

.sidebar ul li ul.submenu li.active > a i {
    color: #157347;
}

        /* Responsive behavior */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-toggle {
                display: block;
            }

            .content {
                margin-left: 0 !important;
            }
        }

        /* Main content */
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Sidebar Toggle -->
    <div class="sidebar-toggle" onclick="toggleSidebar()">☰</div>

    <!-- Sidebar -->
    @auth


    @include('layouts.sidebar')

    @else

    <!-- Main content -->
    <div class="content">
        @yield('content')

    </div>
     @endauth

    <script>
        function toggleSubmenu(event) {
            event.preventDefault();
            const parent = event.currentTarget.parentElement;
            parent.classList.toggle('open');
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
    </script>
</body>
</html>
