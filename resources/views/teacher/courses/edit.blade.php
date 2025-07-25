@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')

<div class="container-fluid px-0 py-4">
    @if(session('success'))
        <div class="alert alert-success mt-3 mb-4">{{ session('success') }}</div>
    @endif
    <div class="row g-0">
        <div class="col-12 bg-white border-bottom shadow-sm mb-3 px-4 py-3 d-flex align-items-center justify-content-between">
            <h1 class="fw-bold mb-0" style="color:#7C3AED;font-size:2.2rem;"><i class="fas fa-edit me-2"></i>{{ __('messages.edit_course') }}</h1>
            <a href="{{ route('teacher.courses.index') }}" class="btn btn-outline-secondary rounded-pill px-4"><i class="fas fa-arrow-left me-2"></i>{{ __('messages.cancel') }}</a>
        </div>
    </div>
    <form action="{{ route('teacher.courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row justify-content-center">
            <div class="col-xl-8 col-lg-10 col-md-12">
                <div class="card shadow-sm rounded-4 mb-4 p-4 border-0">
                    <h2 class="fw-bold mb-3" style="color:#4F46E5;"><i class="fas fa-book me-2"></i>{{ __('messages.course_details') }}</h2>
                    <div class="form-group mb-3">
                        <label for="course_name">{{ __('messages.course_name') }}</label>
                        <input type="text" id="course_name" name="name" class="form-control" value="{{ old('name', $course->name) }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="course_description">{{ __('messages.course_description') }}</label>
                        <textarea id="course_description" name="description" class="form-control">{{ old('description', $course->description) }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="course_creation_date">{{ __('messages.creation_date') }}</label>
                        <input type="date" id="course_creation_date" name="creation_date" class="form-control" value="{{ old('creation_date', $course->creation_date instanceof \DateTime ? $course->creation_date->format('Y-m-d') : $course->creation_date) }}">
                    </div>
                    <input type="hidden" name="author_id" value="{{ $course->author_id }}">
                </div>
                <div class="mb-4">
                    <h3 class="fw-bold mb-3" style="color:#7C3AED;"><i class="fas fa-layer-group me-2"></i>Sections</h3>
                    @forelse ($course->sections as $index => $section)
                        <div class="card shadow-sm rounded-4 mb-3 p-3 border-0 position-relative section-group">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-semibold">{{ __('messages.section_name') }} :</span>
                                <button type="button" data-section-id="{{$section->id}}" class="btn btn-link text-danger remove-section-btn" title="Supprimer la section"><i class="fas fa-trash"></i></button>
                            </div>
                            <input type="hidden" name="sections[{{ $index }}][id]" value="{{ old('sections.' . $index . '.id', $section->id) }}">
                            <input type="hidden" name="sections[{{ $index }}][delete]" value="0">
                            <input type="text" name="sections[{{ $index }}][name]" class="form-control mb-2" value="{{ old('sections.' . $index . '.name', $section->name) }}" placeholder="Nom de la section">
                            <textarea name="sections[{{ $index }}][description]" class="form-control mb-2" placeholder="Description">{{ old('sections.' . $index . '.description', $section->description) }}</textarea>
                            <input type="number" name="sections[{{ $index }}][level]" class="form-control mb-2" value="{{ old('sections.' . $index . '.level', $section->level) }}" placeholder="Niveau">
                            <div class="mt-2">
                                <h5 class="fw-bold mb-2" style="color:#4F46E5;"><i class="fas fa-cube me-2"></i>Modules</h5>
                                @forelse ($section->modules as $moduleIndex => $module)
                                    <div class="card shadow-sm rounded-4 mb-2 p-2 border-0 position-relative module-group">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-semibold">{{ __('messages.module_name') }} :</span>
                                            <button type="button" data-module-id="{{$module->id}}" class="btn btn-link text-danger remove-module-btn" title="Supprimer le module"><i class="fas fa-trash"></i></button>
                                        </div>
                                        <input type="hidden" name="sections[{{ $index }}][modules][{{ $moduleIndex }}][id]" value="{{ old('sections.' . $index . '.modules.' . $moduleIndex . '.id', $module->id) }}">
                                        <input type="hidden" name="sections[{{ $index }}][modules][{{ $moduleIndex }}][delete]" value="0">
                                        <input type="text" name="sections[{{ $index }}][modules][{{ $moduleIndex }}][name]" class="form-control mb-1" value="{{ old('sections.' . $index . '.modules.' . $moduleIndex . '.name', $module->name) }}" placeholder="Nom du module">
                                        <textarea name="sections[{{ $index }}][modules][{{ $moduleIndex }}][description]" class="form-control mb-1" placeholder="Description">{{ old('sections.' . $index . '.modules.' . $moduleIndex . '.description', $module->description) }}</textarea>
                                        <input type="number" name="sections[{{ $index }}][modules][{{ $moduleIndex }}][level]" class="form-control mb-1" value="{{ old('sections.' . $index . '.modules.' . $moduleIndex . '.level', $module->level) }}" placeholder="Niveau">
                                    </div>
                                @empty
                                    <div class="text-muted">Aucun module dans cette section.</div>
                                @endforelse
                                <button type="button" class="btn btn-outline-primary add-module-btn mt-2"><i class="fas fa-plus me-2"></i>Ajouter un module</button>
                            </div>
                        </div>
                    @empty
                        <div class="text-muted">Aucune section pour ce cours.</div>
                    @endforelse
                    <button type="button" class="btn btn-outline-primary add-section-btn mt-3"><i class="fas fa-plus me-2"></i>Ajouter une section</button>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success fw-bold px-4"><i class="fas fa-save me-2"></i>{{ __('messages.update_course') }}</button>
                </div>
            </div>
        </div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Suppression section
    document.querySelectorAll('.remove-section-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if(confirm('Voulez-vous vraiment supprimer cette section ?')) {
                var sectionGroup = btn.closest('.section-group');
                var deleteInput = sectionGroup.querySelector('input[name$="[delete]"]') || sectionGroup.querySelector('input[name$="[_delete]"]');
                if(deleteInput) deleteInput.value = '1';
                sectionGroup.style.display = 'none';
                showDeleteMessage('Section supprimée.');
                setTimeout(function() {
                    document.querySelector('form').submit();
                }, 700);
            }
        });
    });
    // Suppression module
    document.querySelectorAll('.remove-module-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if(confirm('Voulez-vous vraiment supprimer ce module ?')) {
                var moduleGroup = btn.closest('.module-group');
                var deleteInput = moduleGroup.querySelector('input[name$="[delete]"]') || moduleGroup.querySelector('input[name$="[_delete]"]');
                if(deleteInput) deleteInput.value = '1';
                moduleGroup.style.display = 'none';
                showDeleteMessage('Module supprimé.');
                setTimeout(function() {
                    document.querySelector('form').submit();
                }, 700);
            }
        });
    });

    // Ajout dynamique de section
    document.querySelectorAll('.add-section-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var container = btn.closest('.mb-4');
            var sections = container.querySelectorAll('.section-group');
            var index = sections.length;
            var sectionHtml = `
                <div class="card shadow-sm rounded-4 mb-3 p-3 border-0 position-relative section-group">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold">Section :</span>
                        <button type="button" class="btn btn-link text-danger remove-section-btn" title="Supprimer la section"><i class="fas fa-trash"></i></button>
                    </div>
                    <input type="hidden" name="sections[${index}][id]" value="">
                    <input type="hidden" name="sections[${index}][delete]" value="0">
                    <input type="text" name="sections[${index}][name]" class="form-control mb-2" value="" placeholder="Nom de la section">
                    <textarea name="sections[${index}][description]" class="form-control mb-2" placeholder="Description"></textarea>
                    <input type="number" name="sections[${index}][level]" class="form-control mb-2" value="" placeholder="Niveau">
                    <div class="mt-2">
                        <h5 class="fw-bold mb-2" style="color:#4F46E5;"><i class="fas fa-cube me-2"></i>Modules</h5>
                        <div class="text-muted">Aucun module dans cette section.</div>
                        <button type="button" class="btn btn-outline-primary add-module-btn mt-2"><i class="fas fa-plus me-2"></i>Ajouter un module</button>
                    </div>
                </div>
            `;
            btn.insertAdjacentHTML('beforebegin', sectionHtml);
            // Ré-attache les listeners suppression et ajout module
            attachListeners();
        });
    });

    // Ajout dynamique de module
    function attachListeners() {
        document.querySelectorAll('.remove-section-btn').forEach(function(btn) {
            btn.onclick = function() {
                if(confirm('Voulez-vous vraiment supprimer cette section ?')) {
                    var sectionGroup = btn.closest('.section-group');
                    var deleteInput = sectionGroup.querySelector('input[name$="[delete]"]') || sectionGroup.querySelector('input[name$="[_delete]"]');
                    if(deleteInput) deleteInput.value = '1';
                    sectionGroup.style.display = 'none';
                    showDeleteMessage('Section supprimée.');
                    setTimeout(function() {
                        document.querySelector('form').submit();
                    }, 700);
                }
            };
        });
        document.querySelectorAll('.add-module-btn').forEach(function(btn) {
            btn.onclick = function() {
                var sectionGroup = btn.closest('.section-group');
                var modules = sectionGroup.querySelectorAll('.module-group');
                var sectionIndex = Array.from(sectionGroup.parentNode.children).indexOf(sectionGroup);
                var moduleIndex = modules.length;
                var moduleHtml = `
                    <div class="card shadow-sm rounded-4 mb-2 p-2 border-0 position-relative module-group">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold">Module :</span>
                            <button type="button" class="btn btn-link text-danger remove-module-btn" title="Supprimer le module"><i class="fas fa-trash"></i></button>
                        </div>
                        <input type="hidden" name="sections[${sectionIndex}][modules][${moduleIndex}][id]" value="">
                        <input type="hidden" name="sections[${sectionIndex}][modules][${moduleIndex}][delete]" value="0">
                        <input type="text" name="sections[${sectionIndex}][modules][${moduleIndex}][name]" class="form-control mb-1" value="" placeholder="Nom du module">
                        <textarea name="sections[${sectionIndex}][modules][${moduleIndex}][description]" class="form-control mb-1" placeholder="Description"></textarea>
                        <input type="number" name="sections[${sectionIndex}][modules][${moduleIndex}][level]" class="form-control mb-1" value="" placeholder="Niveau">
                    </div>
                `;
                btn.insertAdjacentHTML('beforebegin', moduleHtml);
                // Ré-attache listeners suppression
                document.querySelectorAll('.remove-module-btn').forEach(function(btn) {
                    btn.onclick = function() {
                        if(confirm('Voulez-vous vraiment supprimer ce module ?')) {
                            var moduleGroup = btn.closest('.module-group');
                            var deleteInput = moduleGroup.querySelector('input[name$="[delete]"]') || moduleGroup.querySelector('input[name$="[_delete]"]');
                            if(deleteInput) deleteInput.value = '1';
                            moduleGroup.style.display = 'none';
                            showDeleteMessage('Module supprimé.');
                            setTimeout(function() {
                                document.querySelector('form').submit();
                            }, 700);
                        }
                    };
                });
            };
        });
    }

    // Fonction pour afficher le message de suppression
    function showDeleteMessage(msg) {
        let alert = document.getElementById('delete-alert');
        if (!alert) {
            alert = document.createElement('div');
            alert.id = 'delete-alert';
            alert.className = 'alert alert-success mt-3';
            alert.style.position = 'fixed';
            alert.style.top = '80px';
            alert.style.right = '30px';
            alert.style.zIndex = '9999';
            document.body.appendChild(alert);
        }
        alert.textContent = msg;
        alert.style.display = 'block';
        setTimeout(function() {
            alert.style.display = 'none';
        }, 2500);
    }
    attachListeners();
});
</script>
@endpush
