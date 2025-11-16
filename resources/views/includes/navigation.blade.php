<nav class="py-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <a href="#" class="font-bold text-2xl text-white tracking-wide mb-2">
            ALVCA MATCHA
        </a>
        <ul class="flex space-x-6">
            <li><a href="/" class="font-medium hover:text-[#184d2e] transition-colors">Home</a></li>
            <li><a href="{{ route('products') }}" class="font-medium hover:text-[#184d2e] transition-colors">Products</a></li>
            <li><a href="{{ route('about') }}" class="font-medium hover:text-[#184d2e] transition-colors">About</a></li>
            <li><a href="{{ route('contact') }}" class="font-medium hover:text-[#184d2e] transition-colors">Contact</a></li>

            @guest
                {{-- This section shows up if the user is NOT logged in --}}
                <li><a href="{{ route('login') }}" class="font-medium hover:text-[#184d2e] transition-colors">Login</a></li>
            @endguest

            @auth
            {{-- This section shows up if the user IS logged in --}}
            @if(auth()->user()->role === 'admin')
                <li>
                    <a href="{{ route('admin.products.index') }}" 
                       class="font-medium hover:text-[#184d2e] transition-colors">
                        <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                        Admin
                    </a>
                </li>
            @endif
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
                <a href="{{ route('user.profile') }}" 
                   class="font-medium hover:text-[#184d2e] transition-colors">
                Profile
                </a>
            </li>
        
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
