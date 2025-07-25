@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="hero-section rounded-4 mb-5 fade-in" style="background: linear-gradient(90deg,#7C3AED 0%,#4F46E5 100%); color: #fff;">
    <div class="container py-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 order-2 order-lg-1">
                <h1 class="hero-title mb-3 fw-bold" style="font-size:2.7rem;">MetaSchool&nbsp;: <span style="color: #FFD600;">Apprenez, progressez, réussissez</span></h1>
                <p class="hero-subtitle mb-4 lead">Des cours premium, des instructeurs experts, une progression claire. Rejoignez la nouvelle génération de l'apprentissage en ligne.</p>
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i>Un seul cours à la fois pour une concentration maximale</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i>Progression visuelle et suivi personnalisé</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i>Ressources téléchargeables et vidéos premium</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-warning me-2"></i>Support instructeur et FAQ intégrée</li>
                </ul>
                <div class="d-flex gap-3 flex-wrap mb-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-light btn-lg px-5 fw-bold">
                            <i class="fas fa-tachometer-alt me-2"></i>Tableau de bord
                        </a>
                        @if(auth()->user()->isStudent())
                            <a href="{{ url('/students/courses') }}" class="btn btn-warning btn-lg px-5 fw-bold text-dark">
                                <i class="fas fa-book-reader me-2"></i>Mes cours
                            </a>
                        @endif
                        <a href="{{ url('/courses') }}" class="btn btn-outline-light btn-lg px-5 fw-bold">
                            <i class="fas fa-search me-2"></i>Voir les cours
                        </a>
                    @else
                        <a href="{{ url('/courses') }}" class="btn btn-warning btn-lg px-5 fw-bold text-dark">
                            <i class="fas fa-search me-2"></i>Voir les cours
                        </a>
                    @endauth
                </div>
            </div>
            <div class="col-lg-6 text-center order-1 order-lg-2 d-flex justify-content-end align-items-center">
                <div class="hero-image mt-4 mt-lg-0">
                    <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=600&q=80" alt="Apprentissage en ligne MetaSchool" class="img-fluid rounded-4 shadow-lg border border-3 border-light" style="max-height: 340px; background: #fff;" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 fade-in" style="background: #fff; color: #23272F;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-3" style="color: #7C3AED;">Découvrez nos catégories de cours</h2>
                <p class="lead text-secondary">Trouvez la formation qui correspond à votre projet professionnel ou personnel.</p>
            </div>
        </div>
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-laptop-code fa-2x mb-3 text-primary"></i>
                        <h6 class="fw-bold mb-2">Développement</h6>
                        <p class="text-secondary small">Web, mobile, backend, frameworks modernes.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-chart-line fa-2x mb-3 text-warning"></i>
                        <h6 class="fw-bold mb-2">Business</h6>
                        <p class="text-secondary small">Marketing, management, entrepreneuriat.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-palette fa-2x mb-3 text-success"></i>
                        <h6 class="fw-bold mb-2">Design</h6>
                        <p class="text-secondary small">UI/UX, graphisme, créativité digitale.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 text-center">
                    <div class="card-body">
                        <i class="fas fa-database fa-2x mb-3 text-info"></i>
                        <h6 class="fw-bold mb-2">Data Science</h6>
                        <p class="text-secondary small">Analytics, IA, machine learning.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-3" style="color: #7C3AED;">Sessions à venir</h2>
                <p class="lead text-secondary">Ne ratez pas nos prochaines sessions de formation en direct&nbsp;!</p>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="fw-bold mb-2">Session React & Laravel</div>
                        <div class="text-muted small mb-2">Débute le 15 juillet 2025</div>
                        <p class="mb-0">Un bootcamp intensif pour maîtriser le développement web moderne avec React et Laravel.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="fw-bold mb-2">Atelier Data Science</div>
                        <div class="text-muted small mb-2">Débute le 22 juillet 2025</div>
                        <p class="mb-0">Découvrez les bases de l’analyse de données et de l’intelligence artificielle en pratique.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Ajout d'une section infos apprentissage en ligne -->
<section class="py-5 fade-in" style="background: #F8F9FB; color: #23272F;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-3" style="color: #7C3AED;">L'apprentissage en ligne, accessible à tous</h2>
                <p class="lead text-secondary">MetaSchool vous permet d'apprendre où que vous soyez, à votre rythme, sur tous vos appareils.</p>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-globe fa-2x mb-3 text-primary"></i>
                        <h6 class="fw-bold mb-2">100% en ligne</h6>
                        <p class="text-secondary small">Suivez vos cours et vos sessions depuis n'importe où dans le monde.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-clock fa-2x mb-3 text-warning"></i>
                        <h6 class="fw-bold mb-2">À votre rythme</h6>
                        <p class="text-secondary small">Progressez selon votre emploi du temps, sans contrainte d'horaire.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 text-center">
                    <div class="card-body">
                        <i class="fas fa-mobile-alt fa-2x mb-3 text-success"></i>
                        <h6 class="fw-bold mb-2">Multi-supports</h6>
                        <p class="text-secondary small">Compatible ordinateur, tablette et mobile pour une expérience optimale.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="py-5 fade-in" style="background: #F8F9FB; color: #23272F;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-3" style="color: #7C3AED;">Ils ont choisi MetaSchool</h2>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="avatar" class="rounded-circle me-3" width="48" height="48">
                            <div>
                                <div class="fw-bold">Yann, étudiant</div>
                                <div class="text-muted small">Développeur junior</div>
                            </div>
                        </div>
                        <p class="mb-0">“MetaSchool m’a permis de rester concentré sur un seul objectif à la fois. L’interface est claire, la progression motivante !”</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="avatar" class="rounded-circle me-3" width="48" height="48">
                            <div>
                                <div class="fw-bold">Sophie, enseignante</div>
                                <div class="text-muted small">Formatrice web</div>
                            </div>
                        </div>
                        <p class="mb-0">“J’adore la gestion des ressources et la simplicité pour suivre la progression de mes étudiants.”</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistiques animées -->
<section class="py-5 fade-in" style="background: linear-gradient(90deg,#7C3AED 0%,#4F46E5 100%); color: #fff;">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-3" style="color: #FFD600;">MetaSchool en chiffres</h2>
                <p class="lead">Notre impact grandit chaque jour grâce à vous&nbsp;!</p>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-3">
                <div class="card border-0 shadow-lg rounded-4 h-100 text-center bg-white text-dark">
                    <div class="card-body py-4">
                        <i class="fas fa-users fa-2x mb-2 text-primary"></i>
                        <div class="stat-number display-5 fw-bold" data-value="12000">12&nbsp;000</div>
                        <div class="fw-semibold">Étudiants inscrits</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-lg rounded-4 h-100 text-center bg-white text-dark">
                    <div class="card-body py-4">
                        <i class="fas fa-book-open fa-2x mb-2 text-warning"></i>
                        <div class="stat-number display-5 fw-bold" data-value="85">85</div>
                        <div class="fw-semibold">Cours premium</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-lg rounded-4 h-100 text-center bg-white text-dark">
                    <div class="card-body py-4">
                        <i class="fas fa-chalkboard-teacher fa-2x mb-2 text-success"></i>
                        <div class="stat-number display-5 fw-bold" data-value="35">35</div>
                        <div class="fw-semibold">Instructeurs experts</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-lg rounded-4 h-100 text-center bg-white text-dark">
                    <div class="card-body py-4">
                        <i class="fas fa-award fa-2x mb-2 text-info"></i>
                        <div class="stat-number display-5 fw-bold" data-value="98">98%</div>
                        <div class="fw-semibold">Taux de satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4 justify-content-center">
            <div class="col-auto">
                <a href="/storage/metaschool-brochure.pdf" class="btn btn-outline-light btn-lg fw-bold" download>
                    <i class="fas fa-file-pdf me-2"></i>Télécharger la brochure PDF
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate stats on scroll
    const stats = document.querySelectorAll('.stat-number');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const target = entry.target;
                const finalValue = target.textContent;
                const numericValue = parseInt(finalValue.replace(/\D/g, ''));
                if (!isNaN(numericValue)) {
                    animateValue(target, 0, numericValue, 2000, finalValue.includes('%') ? '%' : (finalValue.includes('+') ? '+' : ''));
                }
            }
        });
    });
    stats.forEach(stat => observer.observe(stat));
    function animateValue(element, start, end, duration, suffix = '') {
        const range = end - start;
        const increment = range / (duration / 16);
        let current = start;
        const timer = setInterval(() => {
            current += increment;
            if (current >= end) {
                current = end;
                clearInterval(timer);
            }
            element.textContent = Math.floor(current) + suffix;
        }, 16);
    }
});
</script>
@endpush
