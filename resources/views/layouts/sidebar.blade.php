


<div class="sidebar w-64 h-screen fixed overflow-y-auto" id="sidebar" style="background-color: linear-gradient(to bottom, #064e3b, #064e3b;">
    <!-- Sidebar Header -->
    <div class="sidebar-header flex flex-col items-center py-6 z-10" style="background-color:  linear-gradient(to bottom, #064e3b, #064e3b;">
        <img src="{{ asset('storage/images/steward.png') }}" alt="Ilala SDA Logo" class="w-16 h-16 rounded-full mb-2">
        <h2 class="text-lg font-bold text-white">Ilala SDA</h2>
    </div>

    <!-- Sidebar Menu -->
    <ul class="mt-6 pb-6 text-white">

        @php
            $menuItems = [
                ['route' => 'dashboard.admin', 'icon' => 'home', 'label' => 'Dashboard', 'permission' => 'Dashboard'],
                ['route' => 'members.index', 'icon' => 'user-friends', 'label' => 'Members', 'permission' => 'Members'],
                ['route' => 'stewardship.index', 'icon' => 'coins', 'label' => 'Stewardship', 'permission' => 'Tithes'],
                ['route' => 'income.index', 'icon' => 'wallet', 'label' => 'Income', 'permission' => 'Income'],
                ['route' => 'expenses.index', 'icon' => 'file-invoice-dollar', 'label' => 'Expenses', 'permission' => 'Expenses'],
                ['route' => 'ministries.index', 'icon' => 'church', 'label' => 'Ministries', 'permission' => 'Ministries'],
                ['route' => 'receipts.index', 'icon' => 'receipt', 'label' => 'Receipts', 'permission' => 'Receipts'],
                ['route' => 'announcements.index', 'icon' => 'bullhorn', 'label' => 'Announcements', 'permission' => 'Receipts'],
                 ['route' => 'users.settings', 'icon' => 'cogs', 'label' => 'Settings', 'permission' => 'Settings'],
                ['route' => 'users.index', 'icon' => 'briefcase', 'label' => 'Management', 'permission' => 'Management'],
            ];
        
        @endphp

        @foreach($menuItems as $item)
            @if(auth()->user()->hasPermission($item['permission']))
                <li class="{{ request()->routeIs($item['route'] . '*') ? 'bg-green-600 text-white font-bold shadow-lg' : '' }} hover:bg-green-500 transition-all duration-200 rounded-md mt-2">
                    <a href="{{ route($item['route']) }}" class="flex items-center px-4 py-2">
                        <i class="fas fa-{{ $item['icon'] }} w-5"></i>
                        <span class="ml-3">{{ $item['label'] }}</span>
                    </a>
                </li>
            @endif
        @endforeach

        <div class="border-t border-white-700 my-4 mx-4"></div>

        <!-- Logout -->
        <li class="hover:bg-green-500 transition-all duration-200 mt-2 rounded-md">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex items-center px-4 py-2">
                <i class="fas fa-sign-out-alt w-5"></i>
                <span class="ml-3">Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="GET" class="hidden">
                @csrf
            </form>
        </li>

    </ul>
</div>
