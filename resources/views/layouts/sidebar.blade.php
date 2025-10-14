<div class="sidebar w-64 h-screen fixed overflow-y-auto" id="sidebar" style="background-color: linear-gradient(to bottom, #064e3b, #064e3b);">
    <!-- Sidebar Header -->
    <div class="sidebar-header flex flex-col items-center py-6  z-10" style="background-color: linear-gradient(to bottom, #064e3b, #064e3b;">
        <img src="{{ asset('storage/images/steward.png') }}" alt="Ilala SDA Logo" class="w-16 h-16 rounded-full mb-2">
        <h2 class="text-lg font-bold text-white">Ilala SDA</h2>
    </div>

    <!-- Sidebar Menu -->
    <ul class="mt-6 pb-6 text-white">
        <!-- Dashboard -->
        <li class="{{ request()->routeIs('dashboard.admin') ? 'bg-green-600 text-white font-bold shadow-lg' : '' }} hover:bg-green-500 transition-all duration-200 rounded-md">
            <a href="{{ route('dashboard.admin') }}" class="flex items-center px-4 py-2">
                <i class="fas fa-home w-5"></i>
                <span class="ml-3">Dashboard</span>
            </a>
        </li>

        <!-- Members -->
        <li class="{{ request()->routeIs('members.*') ? 'bg-green-600 text-white font-bold shadow-lg' : '' }} hover:bg-green-500 transition-all duration-200 rounded-md mt-2">
            <a href="{{ route('members.index') }}" class="flex items-center px-4 py-2">
                <i class="fas fa-user-friends w-5"></i>
                <span class="ml-3">Members</span>
            </a>
        </li>

        <!-- Offerings -->
        <li class="{{ request()->routeIs('offerings.*') ? 'bg-green-600 text-white font-bold shadow-lg' : '' }} hover:bg-green-500 transition-all duration-200 rounded-md mt-2">
            <a href="{{ route('offerings.index') }}" class="flex items-center px-4 py-2">
                <i class="fas fa-hand-holding-usd w-5"></i>
                <span class="ml-3">Offerings</span>
            </a>
        </li>

        <!-- Tithes -->
        <li class="{{ request()->routeIs('tithes.*') ? 'bg-green-600 text-white font-bold shadow-lg' : '' }} hover:bg-green-500 transition-all duration-200 rounded-md mt-2">
            <a href="{{ route('tithes.index') }}" class="flex items-center px-4 py-2">
                <i class="fas fa-coins w-5"></i>
                <span class="ml-3">Tithes</span>
            </a>
        </li>

        <!-- Thanksgiving -->
        <li class="{{ request()->routeIs('thanksgiving.*') ? 'bg-green-600 text-white font-bold shadow-lg' : '' }} hover:bg-green-500 transition-all duration-200 rounded-md mt-2">
            <a href="{{ route('thanksgiving.index') }}" class="flex items-center px-4 py-2">
                <i class="fas fa-pray w-5"></i>
                <span class="ml-3">Thanksgiving</span>
            </a>
        </li>

        <!-- Income -->
        <li class="{{ request()->routeIs('income.*') ? 'bg-green-600 text-white font-bold shadow-lg' : '' }} hover:bg-green-500 transition-all duration-200 rounded-md mt-2">
            <a href="{{ route('income.index') }}" class="flex items-center px-4 py-2">
                <i class="fas fa-wallet w-5"></i>
                <span class="ml-3">Income</span>
            </a>
        </li>

        <!-- Expenses -->
        <li class="{{ request()->routeIs('expenses.*') ? 'bg-green-600 text-white font-bold shadow-lg' : '' }} hover:bg-green-500 transition-all duration-200 rounded-md mt-2">
            <a href="{{ route('expenses.index') }}" class="flex items-center px-4 py-2">
                <i class="fas fa-file-invoice-dollar w-5"></i>
                <span class="ml-3">Expenses</span>
            </a>
        </li>

        <!-- Ministries -->
        <li class="{{ request()->routeIs('ministries.*') ? 'bg-green-600 text-white font-bold shadow-lg' : '' }} hover:bg-green-500 transition-all duration-200 rounded-md mt-2">
            <a href="{{ route('ministries.index') }}" class="flex items-center px-4 py-2">
                <i class="fas fa-church w-5"></i>
                <span class="ml-3">Ministries</span>
            </a>
        </li>

        <!-- Receipts -->
        <li class="{{ request()->routeIs('receipts.*') ? 'bg-green-600 text-white font-bold shadow-lg' : '' }} hover:bg-green-500 transition-all duration-200 rounded-md mt-2">
            <a href="{{ route('receipts.index') }}" class="flex items-center px-4 py-2">
                <i class="fas fa-receipt w-5"></i>
                <span class="ml-3">Receipts</span>
            </a>
        </li>

        <!-- Messages -->
        <li class="{{ request()->routeIs('messages.*') ? 'bg-green-600 text-white font-bold shadow-lg' : '' }} hover:bg-green-500 transition-all duration-200 rounded-md mt-2">
            <a href="{{ route('messages.index') }}" class="flex items-center px-4 py-2">
                <i class="fas fa-envelope w-5"></i>
                <span class="ml-3">Messages</span>
            </a>
        </li>

        <!-- Settings -->
        <li class="{{ request()->routeIs('settings.*') ? 'bg-green-600 text-white font-bold shadow-lg' : '' }} hover:bg-green-500 transition-all duration-200 rounded-md mt-2">
            <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-2">
                <i class="fas fa-cogs w-5"></i>
                <span class="ml-3">Settings</span>
            </a>
        </li>

        <div class="border-t border-green-700 my-4 mx-4"></div>

        <!-- Users -->
      <li class="{{ request()->routeIs('users.*') ? 'bg-green-600 text-white font-bold shadow-lg' : '' }} hover:bg-green-500 transition-all duration-200 rounded-md mt-2">
    <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2">
        <i class="fas fa-briefcase w-5"></i>
        <span class="ml-3">Management</span>
    </a>
</li>


        <!-- Logout -->
        <li class="hover:bg-green-500 transition-all duration-200 mt-2 rounded-md">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex items-center px-4 py-2">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span class="ml-3">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}"  class="hidden">
                @csrf
            </form>
        </li>
    </ul>
</div>
