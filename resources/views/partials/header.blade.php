<!-- Header Content -->
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ url('/') }}">MetaSchool</a>

        <!-- Hamburger menu button for screens between 600px and 767px -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon">☰</span>
            <span class="navbar-toggler-close" style="display: none;">✖</span>
        </button>

        <!-- Main navigation for larger screens (from 758px) -->
        <div class="collapse navbar-collapse d-lg-flex" id="mainNavbar">
            @auth
            <!-- Links for Authenticated Users -->
            <ul class="navbar-nav me-auto">
                <!-- Check if the user is a teacher -->
                @if (auth()->user()->role == 'teacher')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('teachers/courses') ? 'active' : '' }}" href="{{ url('teachers/courses') }}">{{ __('messages.courses') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('teachers/lessons') ? 'active' : '' }}" href="{{ url('teachers/lessons') }}">{{ __('messages.lessons') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('teachers/quizzes') ? 'active' : '' }}" href="{{ url('teachers/quizzes') }}">{{ __('messages.quizzes') }}</a>
                </li>
                <!-- Check if the user is a student -->
                @elseif (auth()->user()->role == 'student')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('students/courses') ? 'active' : '' }}" href="{{ url('students/courses') }}">{{ __('messages.courses') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('students/lessons') ? 'active' : '' }}" href="{{ url('students/lessons') }}">{{ __('messages.lessons') }}</a>
                </li>
                @endif

                <!-- Common links for all users -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">{{ __('messages.about') }}</a>
                </li>
            </ul>
            @endauth

            <ul class="navbar-nav ms-auto">
                @guest
                <!-- Links for Guests -->
                @if(Request::is('login'))
                <!-- On the login page -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">{{ __('messages.back') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link register-link" href="{{ url('/register') }}">{{ __('messages.register') }}</a>
                </li>
                @elseif(Request::is('register'))
                <!-- On the register page -->
                <li class="nav-item">
                    <a class="nav-link login-link" href="{{ url('/login') }}">{{ __('messages.login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">{{ __('messages.back') }}</a>
                </li>
                @else
                <!-- Default Links for Guests -->
                <li class="nav-item">
                    <a class="nav-link login-link" href="{{ url('/login') }}">{{ __('messages.login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link register-link" href="{{ url('/register') }}">{{ __('messages.register') }}</a>
                </li>
                @endif
                @else
                <!-- Links for Authenticated Users -->
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('account') ? 'active' : '' }}" href="{{ url('/account') }}">{{ __('messages.account') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link logout-link" href="{{ url('/logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('messages.logout') }}
                    </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endguest
            </ul>
        </div>

        <!-- Dropdown menu for screens between 600px and 767px -->
        <div class="collapse d-lg-none" id="dropdownMenu">
            <ul class="navbar-nav">
                <!-- Main Navigation Links -->
                @auth
                <!-- Check if the user is a teacher -->
                @if (auth()->user()->role == 'teacher')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('teachers/courses') ? 'active' : '' }}" href="{{ url('teachers/courses') }}">{{ __('messages.courses') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('teachers/lessons') ? 'active' : '' }}" href="{{ url('teachers/lessons') }}">{{ __('messages.lessons') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('teachers/quizzes') ? 'active' : '' }}" href="{{ url('teachers/quizzes') }}">{{ __('messages.quizzes') }}</a>
                </li>
                <!-- Check if the user is a student -->
                @elseif (auth()->user()->role == 'student')
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('students/courses') ? 'active' : '' }}" href="{{ url('students/courses') }}">{{ __('messages.courses') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('students/lessons') ? 'active' : '' }}" href="{{ url('students/lessons') }}">{{ __('messages.lessons') }}</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/about') }}">{{ __('messages.about') }}</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link login-link" href="{{ url('/login') }}">{{ __('messages.login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link register-link" href="{{ url('/register') }}">{{ __('messages.register') }}</a>
                </li>
                @endif
            </ul>
            <ul class="navbar-nav mt-2">
                <!-- Authenticated User Links -->
                @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('account') ? 'active' : '' }}" href="{{ url('/account') }}">{{ __('messages.account') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link logout-link" href="{{ url('/logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('messages.logout') }}
                    </a>
                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @endauth
            </ul>
        </div>

        <!-- Account and Home buttons for screens less than 599px -->
        <div class="home-and-account-btn-container">
            <a class="nav-link home-btn" href="{{ url('/') }}">
                <i class="fas fa-home"></i>
            </a>
            <a class="nav-link account-btn" href="{{ url('/account') }}">
                <i class="fas fa-user"></i>
            </a>
        </div>

    </nav>
</header>
