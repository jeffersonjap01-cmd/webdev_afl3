<nav class="py-4">
    <div class="max-w-6xl mx-auto flex items-center justify-between">
        <a href="#" class="font-bold text-2xl text-white tracking-wide mb-2">
            ALVCA MATCHA
        </a>
        <ul class="flex space-x-6">
            <li><a href="/" class="font-medium hover:text-[#184d2e] transition-colors">Home</a></li>
            <li><a href="/products" class="font-medium hover:text-[#184d2e] transition-colors">Products</a></li>
            <li><a href="/about" class="font-medium hover:text-[#184d2e] transition-colors">About</a></li>
            <li><a href="/contact" class="font-medium hover:text-[#184d2e] transition-colors">Contact</a></li>

            @guest
                {{-- This section shows up if the user is NOT logged in --}}
                <li><a href="{{ route('login') }}" class="font-medium hover:text-[#184d2e] transition-colors">Login</a></li>
            @endguest

            @auth
                {{-- This section shows up if the user IS logged in --}}
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="font-medium hover:text-[#184d2e] transition-colors">Logout</button>
                    </form>
                </li>
            @endauth
        </ul>
    </div>
</nav>
