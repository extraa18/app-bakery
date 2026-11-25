<nav class="site-nav">
    <div class="brand">🥐 Toko Bakery</div>
    @auth
        <ul>
            <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
        </ul>
        <div class="navbar-user">
            <span>{{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    @endauth
    @guest
        <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Login</a>
    @endguest
</nav>