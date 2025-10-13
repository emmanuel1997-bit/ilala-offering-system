<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ilala SDA Church Offering Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero {
            background-image: url('https://lh3.googleusercontent.com/gps-cs-s/AC9h4nrZqwfw7GQHmzNyuzmE043c4SmasHfTnIYRHmvtpzHL8uKqGe7mXIvxVFLxcUwTlrllevGwxldDS2AjRB59OAeCCSB52Q9emZSCzF336-AJgWo2lbwxdJGneFJwDEMOZt5C1sQxXA=s1360-w1360-h1020-rw');
            background-size: cover;
            background-position: center;
        }
        .hero-overlay {
            background-color: rgba(0, 0, 0, 0.5);
        }
        /* Smooth hide/show animation for navbar */
        .navbar {
            transition: top 0.3s;
        }
    </style>
</head>
<body class="bg-gray-50">
<!-- Top Navigation Bar -->
<nav id="navbar" class="navbar fixed w-full z-50 top-0 left-0 bg-white/80 backdrop-blur-md shadow-md">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="#" class="flex items-center space-x-2">
            <img src="{{ asset('storage/images/steward.png') }}" class="h-10">
            <span class="text-xl font-semibold text-green-600">Ilala SDA Church</span>
        </a>
        <!-- Login button -->
        <a href="{{ route('login') }}" class="bg-green-800 hover:bg-green-800 text-white font-semibold px-4 py-2 rounded-lg shadow transition duration-300">Login</a>
    </div>
</nav>


    <!-- Hero Section -->
    <section class="hero relative h-screen flex items-center justify-center">
        <div class="hero-overlay absolute inset-0"></div>
        <div class="relative text-center text-white px-6">
            <h1 class="text-5xl sm:text-6xl font-extrabold leading-tight drop-shadow-lg">Ilala SDA Church</h1>
            <p class="mt-4 text-lg sm:text-xl text-gray-200 drop-shadow-md">Streamlining offerings with transparency and ease</p>
            <a href="{{ route('login') }}" class="mt-8 inline-block bg-green-800 hover:bg-green-800 text-white font-semibold px-8 py-3 rounded-lg shadow-lg transition duration-300">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-gray-800">Why Use This System?</h2>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">This  system is designed to ensure accountability, efficiency, and user-friendly experience for your church operations.</p>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="feature-card bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Secure Transactions</h3>
                    <p class="text-gray-600">All offerings are securely recorded and managed with transparency and accountability.</p>
                </div>
                <div class="feature-card bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Easy Management</h3>
                    <p class="text-gray-600">Quickly track, record, and report offerings with a user-friendly interface designed for efficiency.</p>
                </div>
                <div class="feature-card bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Reliable Support</h3>
                    <p class="text-gray-600">Our team ensures smooth operation and is ready to assist whenever needed.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-16 bg-green-800 text-white text-center">
        <h2 class="text-3xl font-bold">Ready to streamline your offerings?</h2>
        <p class="mt-4 text-lg">Start managing your church offerings professionally today.</p>
        <a href="{{ route('login') }}" class="mt-6 inline-block bg-white text-green-600 font-semibold px-8 py-3 rounded-lg shadow-lg hover:bg-gray-100 transition duration-300">Get Started</a>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-300 py-6">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p>&copy; {{ date('Y') }} Ilala SDA Church. All rights reserved.</p>
            <p class="mt-2">Designed with ❤️ for your church management</p>
        </div>
    </footer>

    <!-- Scroll Hide/Show Navbar Script -->
    <script>
        let prevScrollpos = window.pageYOffset;
        const navbar = document.getElementById("navbar");
        window.onscroll = function() {
            let currentScrollPos = window.pageYOffset;
            if (prevScrollpos > currentScrollPos) {
                // scrolling up - show navbar
                navbar.style.top = "0";
            } else {
                // scrolling down - hide navbar
                navbar.style.top = "-100px";
            }
            prevScrollpos = currentScrollPos;
        }
    </script>

</body>
</html>
