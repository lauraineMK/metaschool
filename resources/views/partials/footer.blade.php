<!-- Footer Content -->
<footer class="text-center mt-4">
    <p>&copy; {{ date('Y') }} MetaSchool. All rights reserved.</p>

    <!-- Dropdown for Languages (visible on small screens) -->
    <div class="dropdown-menu-visible position-top-right">
        <ul class="navbar-nav d-inline">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="languagesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Languages
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languagesDropdown">
                    <li><a class="dropdown-item" href="{{ url('lang/en') }}">English</a></li>
                    <li><a class="dropdown-item" href="{{ url('lang/fr') }}">Français</a></li>
                    <li><a class="dropdown-item" href="{{ url('lang/de') }}">Deutsch</a></li>
                    <li><a class="dropdown-item" href="{{ url('lang/nl') }}">Nederlands</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- Dropup for Languages (visible on larger screens) -->
    <div class="dropup-menu-visible">
        <ul class="navbar-nav d-inline">
            <li class="nav-item dropup">
                <a class="nav-link dropdown-toggle" href="#" id="languagesDropdownDropup" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Languages
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languagesDropdownDropup">
                    <li><a class="dropdown-item" href="{{ url('lang/en') }}">English</a></li>
                    <li><a class="dropdown-item" href="{{ url('lang/fr') }}">Français</a></li>
                    <li><a class="dropdown-item" href="{{ url('lang/de') }}">Deutsch</a></li>
                    <li><a class="dropdown-item" href="{{ url('lang/nl') }}">Nederlands</a></li>
                </ul>
            </li>
        </ul>
    </div>

</footer>
