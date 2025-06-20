<nav class="h-full bg-white dark:bg-gray-800 shadow-md">
    <div class="p-6 space-y-6">
        <!-- Logo -->
        <div class="flex items-center justify-center">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="block h-20 w-auto text-gray-800 dark:text-gray-200">
            </a>
        </div>

        <!-- Navigation Links -->
        <ul class="space-y-2 text-sm">
            <li>
                <a href="{{ route('dashboard') }}"
                   class="block px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{request()->routeIs('dashboard') ? 'bg-gray-200 dark:bg-gray-700 font-bold' : '' }}">
                    Dashboard
                </a>
            </li>

            @if(auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('products.index') }}"
                       class="block px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->is('products*') ? 'bg-gray-200 dark:bg-gray-700 font-bold' : '' }}">
                        Manage Products
                    </a>
                </li>
                <li>
                    <a href="{{ route('sales-orders.index') }}"
                       class="block px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->is('sales-orders') ? 'bg-gray-200 dark:bg-gray-700 font-bold' : '' }}">
                        View Sales Orders
                    </a>
                </li>
            @elseif(auth()->user()->role === 'salesperson')
                <li>
                    <a href="{{ route('sales-orders.create') }}"
                       class="block px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->is('sales-orders/create') ? 'bg-gray-200 dark:bg-gray-700 font-bold' : '' }}">
                        Create Sales Order
                    </a>
                </li>
                <li>
                    <a href="{{ route('sales-orders.index') }}"
                       class="block px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 {{ request()->is('sales-orders') ? 'bg-gray-200 dark:bg-gray-700 font-bold' : '' }}">
                        My Sales Orders
                    </a>
                </li>
            @endif
            
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 rounded hover:bg-red-100 dark:hover:bg-red-700 text-red-600 dark:text-red-300">
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</nav>
