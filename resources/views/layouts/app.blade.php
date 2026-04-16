<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Blood Bank')</title>
    <link rel="stylesheet" href="{{ asset('legacy/style/app-modern.css') }}">
    @stack('styles')
</head>
<body>
    <header class="site-header">
        <div class="nav-shell">
            <a class="brand" href="{{ route('home') }}">
                <span class="brand-dot" aria-hidden="true"></span>
                Blood Donor Mgmt
            </a>

            <button class="nav-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="site-navigation" onclick="toggleSiteNav(this)">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="nav-cluster" id="site-navigation">
                <nav class="nav-links">
                    <a href="{{ route('why.bdms') }}" class="{{ request()->routeIs('why.bdms') ? 'active' : '' }}">Why BDMS</a>
                    <a href="{{ route('get.involved') }}" class="{{ request()->routeIs('get.involved') ? 'active' : '' }}">Get Involved</a>
                    <a href="{{ route('looking.for.blood') }}" class="{{ request()->routeIs('looking.for.blood', 'availability.*') ? 'active' : '' }}">Looking For Blood</a>
                    <a href="{{ route('our.achievements') }}" class="{{ request()->routeIs('our.achievements') ? 'active' : '' }}">Our Achievements</a>
                    @auth
                        @if(auth()->user()->hasRole('donor') || auth()->user()->hasRole('receiver'))
                            <a href="{{ route('dashboard.user') }}" class="{{ request()->routeIs('dashboard.user') ? 'active' : '' }}">User Dashboard</a>
                        @endif
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('dashboard.admin') }}" class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">Admin Dashboard</a>
                        @endif
                    @endauth
                </nav>

                <div class="header-actions">
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="logout-form">
                        @csrf
                        <button type="submit" class="btn">Logout</button>
                    </form>
                @else
                    <a class="btn" href="{{ route('login.form') }}">Login</a>
                    <a class="btn primary" href="{{ route('register.form') }}">Register</a>
                @endauth
                </div>
            </div>
        </div>
    </header>

    <main class="app-wrap">
        @if(session('status'))
            <div class="notice">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="error-list">
                <strong>Please check the form fields.</strong>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="footer-shell">
            <div class="footer-brand">
                <h3>Blood Donor Mgmt</h3>
                <p>Helping people find compatible blood faster through a reliable donor and request network.</p>
            </div>

            <div class="footer-links">
                <h4>Explore</h4>
                <a href="{{ route('why.bdms') }}">Why BDMS</a>
                <a href="{{ route('get.involved') }}">Get Involved</a>
                <a href="{{ route('looking.for.blood') }}">Looking For Blood</a>
                <a href="{{ route('our.achievements') }}">Our Achievements</a>
            </div>

            <div class="footer-links">
                <h4>Quick Actions</h4>
                <a href="{{ route('availability.index') }}">Search Availability</a>
                <a href="{{ route('register.form') }}">Register Account</a>
                <a href="{{ route('login.form') }}">Login</a>
                @auth
                    <a href="{{ auth()->user()->hasRole('admin') ? route('dashboard.admin') : route('dashboard.user') }}">Go to Dashboard</a>
                @endauth
            </div>

            <div class="footer-meta">
                <h4>Support</h4>
                <p>Need urgent blood? Use donor availability search first, then contact matching donors directly.</p>
                <p class="footer-note">Built with care for faster blood access and safer donor coordination.</p>
            </div>
        </div>
    </footer>

    <script>
    function toggleSiteNav(button) {
        const nav = document.getElementById('site-navigation');
        if (!nav) return;
        const isOpen = nav.classList.toggle('is-open');
        button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }
    </script>
    @stack('scripts')
</body>
</html>
