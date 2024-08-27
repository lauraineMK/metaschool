<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{ url('/') }}">MetaSchool</a>
    <div class="collapse navbar-collapse">
        @auth
        <!-- Links for Authenticated Users -->
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('teachers/courses') }}">Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/about') }}">About</a>
            </li>
        </ul>
        @endauth

        <ul class="navbar-nav ml-auto">
            @guest
            <!-- Links for Guests -->
            @if(Request::is('login'))
            <!-- On the login page -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Back</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/register') }}">Register</a>
            </li>
            @elseif(Request::is('register'))
            <!-- On the register page -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Back</a>
            </li>
            @else
            <!-- Default Links for Guests -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/login') }}">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/register') }}">Register</a>
            </li>
            @endif
            @else
            <!-- Links for Authenticated Users -->
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/profile') }}">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/logout') }}"
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
</nav>
