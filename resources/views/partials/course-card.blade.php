<div class="card course-card h-100">
    <img src="{{ $course->cover_url ?? asset('images/course-placeholder.jpg') }}" class="card-img-top" alt="{{ $course->title }}">
    <div class="card-body">
        <h5 class="card-title mb-2">{{ $course->title }}</h5>
        <div class="course-instructor mb-2">
            <i class="fas fa-user me-1"></i>
            {{ $course->instructor->name ?? 'Instructeur inconnu' }}
        </div>
        <div class="course-rating mb-2">
            <span class="stars">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star{{ $i <= round($course->rating ?? 0) ? '' : '-o' }}"></i>
                @endfor
            </span>
            <span class="rating-count">({{ $course->reviews_count ?? 0 }})</span>
        </div>
        <div class="course-price mb-2">
            @if(isset($course->price) && $course->price > 0)
                {{ number_format($course->price, 2, ',', ' ') }} €
            @else
                <span class="badge bg-success">Gratuit</span>
            @endif
        </div>
    </div>
    <div class="card-footer bg-transparent border-0 text-end">
        <a href="{{ route('student.courses.show', $course->id) }}" class="btn btn-primary btn-sm">Voir le cours</a>
    </div>
</div>
