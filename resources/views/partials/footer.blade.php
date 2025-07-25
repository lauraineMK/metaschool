<!-- Footer Content -->
<footer class="footer w-100 mt-auto py-3" style="background: #f7f7fa; color: #444; border-top: 1.5px solid #e5e7eb; position: fixed; left: 0; bottom: 0; z-index: 100; box-shadow: 0 -2px 12px 0 rgba(60,60,60,0.04);">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
        <div class="mb-2 mb-md-0 small" style="color: #222;">
            <span class="fw-bold">MetaSchool</span> &copy; {{ date('Y') }}
        </div>
        <ul class="list-inline mb-2 mb-md-0">
            <li class="list-inline-item"><a href="{{ url('/about') }}" class="text-secondary text-decoration-none small">À propos</a></li>
            <li class="list-inline-item"><a href="{{ url('/students/courses') }}" class="text-secondary text-decoration-none small">Cours</a></li>
            <li class="list-inline-item"><a href="{{ url('/students/lessons') }}" class="text-secondary text-decoration-none small">Leçons</a></li>
            <li class="list-inline-item"><a href="{{ url('/contact') }}" class="text-secondary text-decoration-none small">Contact</a></li>
        </ul>
        <div class="dropdown">
            <a class="text-secondary dropdown-toggle text-decoration-none small" href="#" id="languagesDropdownFooter" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-globe"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languagesDropdownFooter">
                <li><a class="dropdown-item" href="{{ url('lang/en') }}">English</a></li>
                <li><a class="dropdown-item" href="{{ url('lang/fr') }}">Français</a></li>
                <li><a class="dropdown-item" href="{{ url('lang/de') }}">Deutsch</a></li>
                <li><a class="dropdown-item" href="{{ url('lang/nl') }}">Nederlands</a></li>
            </ul>
        </div>
    </div>
</footer>
