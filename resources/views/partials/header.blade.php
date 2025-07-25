<!-- Header Content -->
<header class="shadow-sm bg-white border-bottom">
    <nav class="navbar navbar-expand-lg navbar-light container-fluid px-4">
        <a class="navbar-brand fw-bold d-flex align-items-center text-primary" href="{{ url('/') }}" style="font-size: 2rem; color: #7C3AED !important; letter-spacing: 1px; font-family: 'Inter', 'Segoe UI', Arial, sans-serif;">
            <i class="fas fa-graduation-cap me-2" style="color: #FFD600; font-size: 1.7rem;"></i>MetaSchool
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-lg-flex" id="mainNavbar">
            <ul class="navbar-nav me-auto gap-2 align-items-center">
                <li class="nav-item"><a class="nav-link px-3" href="{{ url('/courses/browse') }}"><i class="fas fa-th-list me-1"></i> Tous les cours</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ url('/about') }}"><i class="fas fa-info-circle me-1"></i> À propos</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ url('/contact') }}"><i class="fas fa-envelope me-1"></i> Contact</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="{{ url('/faq') }}"><i class="fas fa-question me-1"></i> FAQ</a></li>
            </ul>
            <ul class="navbar-nav ms-auto gap-2 align-items-center">
                @guest
                    <li class="nav-item"><a class="nav-link login-link px-3" href="{{ url('/login') }}"><i class="fas fa-sign-in-alt me-1"></i> Connexion</a></li>
                    <li class="nav-item"><a class="nav-link register-link px-3" href="{{ url('/register') }}"><i class="fas fa-user-plus me-1"></i> Inscription</a></li>
                @else
                    <li class="nav-item"><a class="nav-link px-3" href="{{ url('/account') }}"><i class="fas fa-user me-1"></i> Mon compte</a></li>
                    <li class="nav-item">
                        <a class="nav-link logout-link px-3 text-danger" href="{{ url('/logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">@csrf</form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
</header>

<style>
.navbar {
    background: #fff !important;
    min-height: 70px;
    border-radius: 0 0 1rem 1rem;
    box-shadow: 0 2px 16px 0 rgba(124,58,237,0.07);
}
.navbar-brand {
    font-size: 2rem;
    color: #7C3AED !important;
    letter-spacing: 1px;
    text-shadow: none;
    font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
    display: flex;
    align-items: center;
}
.nav-link {
    color: #23272F;
    font-weight: 500;
    border-radius: 2rem;
    transition: background 0.2s, color 0.2s;
    font-size: 1.08rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
}
.nav-link.active, .nav-link:hover {
    background: #F0F4FF;
    color: #7C3AED !important;
}
.login-link, .register-link {
    font-weight: 600;
}
.logout-link {
    color: #E53E3E !important;
}
.navbar-toggler {
    border: none;
    padding: 0.25rem 0.5rem;
}
.navbar-toggler:focus {
    box-shadow: none;
}
@media (max-width: 991px) {
    .navbar-brand { font-size: 1.3rem; }
    .nav-link { font-size: 1rem; }
}
</style>
