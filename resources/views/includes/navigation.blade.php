<nav class="py-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <a href="#" class="font-bold text-2xl text-white tracking-wide mb-2">
            ALVCA MATCHA
        </a>
        <ul class="flex space-x-6">
            <li><a href="/" class="font-medium hover:text-[#184d2e] transition-colors">Home</a></li>
            <li><a href="{{ route('products') }}" class="font-medium hover:text-[#184d2e] transition-colors">Products</a></li>
            <li><a href="{{ route('about') }}" class="font-medium hover:text-[#184d2e] transition-colors">About</a></li>
            <li><a href="{{ route('review') }}" class="font-medium hover:text-[#184d2e] transition-colors">Review</a></li>

            @guest
                {{-- This section shows up if the user is NOT logged in --}}
                <li><a href="{{ route('login') }}" class="font-medium hover:text-[#184d2e] transition-colors">Login</a></li>
            @endguest

            @auth
            {{-- This section shows up if the user IS logged in --}}
            @if(auth()->user()->role === 'admin')
                {{-- Admin Navigation - Simplified --}}
                <li>
                    <a href="{{ route('admin.products.index') }}" 
                       class="font-medium hover:text-[#184d2e] transition-colors">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Products
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders.index') }}" 
                       class="font-medium hover:text-[#184d2e] transition-colors">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Orders
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.deliveries.index') }}" 
                       class="font-medium hover:text-[#184d2e] transition-colors">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Deliveries
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.promos.index') }}" 
                       class="font-medium hover:text-[#184d2e] transition-colors">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Promos
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile') }}" 
                       class="font-medium hover:text-[#184d2e] transition-colors">
                        Profile
                    </a>
                </li>
            @else
                {{-- User Navigation --}}
                <li>
                    <a href="{{ route('keranjang.index') }}" 
                       class="font-medium hover:text-[#184d2e] transition-colors relative">
                        <svg class="w-6 h-6 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <span class="ml-1">Keranjang</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('orders.index') }}" 
                       class="font-medium hover:text-[#184d2e] transition-colors">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Order
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile') }}" 
                       class="font-medium hover:text-[#184d2e] transition-colors">
                        Profile
                    </a>
                </li>
            @endif
        
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="font-medium hover:text-[#184d2e] transition-colors">
                        Logout
                    </button>
                </form>
            </li>
        @endauth
        </ul>
    </div>
</nav>
