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
                    <a class="nav-link" href="{{ url('teachers/courses') }}">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('teachers/lessons') }}">Lessons</a>
                </li>
                <!-- Check if the user is a student -->
                @elseif (auth()->user()->role == 'student')
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('students/courses') }}">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('students/lessons') }}">Lessons</a>
                </li>
                @endif

                <!-- Common links for all users -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/about') }}">About</a>
                </li>
            </ul>
            @endauth

            <ul class="navbar-nav ms-auto">
                @guest
                <!-- Links for Guests -->
                @if(Request::is('login'))
                <!-- On the login page -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Back</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link register-link" href="{{ url('/register') }}">Register</a>
                </li>
                @elseif(Request::is('register'))
                <!-- On the register page -->
                <li class="nav-item">
                    <a class="nav-link login-link" href="{{ url('/login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Back</a>
                </li>
                @else
                <!-- Default Links for Guests -->
                <li class="nav-item">
                    <a class="nav-link login-link" href="{{ url('/login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link register-link" href="{{ url('/register') }}">Register</a>
                </li>
                @endif
                @else
                <!-- Links for Authenticated Users -->
                <li class="nav-item">
                    <a class="nav-link profile-link" href="{{ url('/profile') }}">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link logout-link" href="{{ url('/logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout
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
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('teachers/courses') }}">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('teachers/lessons') }}">Lessons</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/about') }}">About</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link login-link" href="{{ url('/login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link register-link" href="{{ url('/register') }}">Register</a>
                </li>
                @endif
            </ul>
            <ul class="navbar-nav mt-2">
                <!-- Authenticated User Links -->
                @auth
                <li class="nav-item">
                    <a class="nav-link profile-link" href="{{ url('/profile') }}">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link logout-link" href="{{ url('/logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout
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
