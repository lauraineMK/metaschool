@extends('layouts.app')

@section('title', 'Create Lesson - MetaSchool')

@section('content')

<div class="container py-5" style="background:linear-gradient(120deg,#f7f7fa 60%,#e9e6fc 100%);min-height:100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="fw-bold" style="color:#7C3AED; font-size:2.2rem;letter-spacing:1px;">{{ __('messages.create_a_new_lesson') }}</h1>
                <a href="{{ route('teacher.lessons.index') }}" class="btn btn-outline-secondary rounded-pill px-4 fw-bold shadow-sm">{{ __('messages.cancel') }}</a>
            </div>
            <form action="{{ route('teacher.lessons.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-4 shadow-lg position-relative" style="min-height:600px;">
                @csrf
                <!-- Section selection -->
                <div class="form-group mb-4">
                    <label for="section_id" class="fw-semibold">Section du cours</label>
                    <select class="form-select" id="section_id" name="section_id" required>
                        <option value="" disabled selected>Sélectionnez une section</option>
                        @foreach($sections as $section)
                        <option value="{{ $section->id }}" data-course="{{ $section->course_id }}" {{ old('section_id') == $section->id ? 'selected' : '' }} style="display:none;">
                            {{ $section->title }} ({{ $courses->where('id', $section->course_id)->first()->name ?? '' }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Module selection -->
                <div class="form-group mb-4">
                    <label for="module_id" class="fw-semibold">Module <span class="text-muted">(choisissez le module associé à la leçon)</span></label>
                    <select class="form-select border-primary" id="module_id" name="module_id" required>
                        <option value="" disabled selected>Sélectionnez un module</option>
                        @foreach($modules as $module)
                        <option value="{{ $module->id }}" data-section="{{ $module->section_id }}" {{ old('module_id') == $module->id ? 'selected' : '' }} style="display:none;">
                            <span class="fw-bold">{{ $module->title }}</span> <span class="text-muted">(Section: {{ $sections->where('id', $module->section_id)->first()->title ?? '' }})</span>
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Title input -->
                <div class="form-group mb-4">
                    <label for="title" class="fw-semibold">Titre de la leçon <span class="text-muted">(Donnez un titre explicite à votre leçon)</span></label>
                    <input type="text" class="form-control rounded-3 border-primary shadow-sm" id="title" name="title" value="{{ old('title') }}" required placeholder="Ex : Les bases du HTML">
                </div>
                <!-- Content input -->
                <div class="form-group mb-4">
                    <label for="content" class="fw-semibold">Contenu de la leçon</label>
                    <textarea class="form-control rounded-3 border-2" id="content" name="content" rows="5" required>{{ old('content') }}</textarea>
                </div>
                <!-- Video input -->
                <div id="video-section" class="mb-4">
                    <h3 class="fw-bold">Vidéos</h3>
                    <div id="video-groups">
                        <!-- Initial video group -->
                        <div class="video-group mt-3">
                            <div class="form-group mb-3">
                                <label for="video_title_0" class="fw-semibold">Titre de la vidéo</label>
                                <input type="text" name="videos[0][title]" id="video_title_0" class="form-control rounded-3 border-2" placeholder="Saisissez le titre de la vidéo">
                            </div>
                            <div class="form-group mb-3">
                                <label for="video_url_0" class="mt-2 fw-semibold">URL de la vidéo</label>
                                <input type="text" name="videos[0][url]" id="video_url_0" class="form-control rounded-3 border-2" placeholder="Saisissez l'URL de la vidéo">
                            </div>
                            <div class="form-group mb-3">
                                <label for="video_description_0" class="mt-2 fw-semibold">Description de la vidéo</label>
                                <textarea name="videos[0][description]" id="video_description_0" class="form-control rounded-3 border-2" rows="3" placeholder="Saisissez la description de la vidéo"></textarea>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm mt-2 remove-video">Supprimer</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-video-button" class="btn btn-secondary mb-4">Ajouter une vidéo</button>
                <!-- Document input -->
                <div id="document-section" class="mb-4">
                    <h3 class="fw-bold">Documents</h3>
                    <div id="document-groups">
                        <!-- Initial document group -->
                        <div class="document-group mt-3">
                            <div class="form-group mb-3">
                                <label for="document_title_0" class="fw-semibold">Titre du document</label>
                                <input type="text" name="documents[0][title]" id="document_title_0" class="form-control rounded-3 border-2" placeholder="Saisissez le titre du document">
                            </div>
                            <div class="form-group mb-3">
                                <label for="document_file_0" class="mt-2 fw-semibold">Fichier du document <span class="text-muted">(formats acceptés : pdf, doc, xls, txt, image)</span></label>
                                <input type="file" name="documents[0][file]" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt,.png,.jpg,.jpeg,.gif" id="document_file_0" class="form-control rounded-3 border-primary">
                            </div>
                            <div class="form-group mb-3">
                                <label for="document_description_0" class="mt-2 fw-semibold">Description du document</label>
                                <textarea name="documents[0][description]" id="document_description_0" class="form-control rounded-3 border-2" rows="3" placeholder="Saisissez la description du document"></textarea>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm mt-2 remove-document">Supprimer</button>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-document-button" class="btn btn-secondary mb-4">Ajouter un document</button>
                <!-- Course selection -->
                <div class="form-group mb-4">
                    <label for="course_id" class="fw-semibold">Cours</label>
                    <select class="form-select" id="course_id" name="course_id" required>
                        <option value="" disabled selected>Sélectionnez un cours</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <!-- Level input -->
                <div class="form-group mb-4">
                    <label for="level" class="fw-semibold">Niveau de la leçon</label>
                    <input type="number" class="form-control rounded-3 border-2" id="level" name="level" value="{{ old('level') }}" required>
                </div>
            <!-- Status input -->
            <div class="form-group mb-4">
                <label for="status" class="fw-semibold">Statut de la leçon</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="" disabled selected>Sélectionnez un statut</option>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Publié</option>
                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archivé</option>
                </select>
            </div>
<div style="position:sticky;bottom:0;z-index:100;background:linear-gradient(90deg,#f7f7fa 60%,#e9e6fc 100%);padding:1rem 0 0.5rem 0;box-shadow:0 -2px 8px rgba(0,0,0,0.08);">
    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm w-100" style="font-size:1.2rem;">Créer la leçon</button>
</div>

<!-- Footer -->
<footer class="bg-white text-center py-4 mt-5 border-top shadow-sm">

<footer class="bg-dark text-light pt-4 pb-2 mt-5 border-0 shadow-lg" style="border-radius:1.5rem 1.5rem 0 0;">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-4 text-md-start text-center mb-2 mb-md-0">
        <span class="fw-bold" style="color:#7C3AED;font-size:1.2rem;letter-spacing:1px;">MetaSchool &copy; 2025</span>
      </div>
      <div class="col-md-4 text-center mb-2 mb-md-0">
        <a href="#" class="mx-2 text-light text-decoration-none footer-link"><i class="bi bi-info-circle-fill me-1" style="color:#0dcaf0;"></i>À propos</a>
        <a href="#" class="mx-2 text-light text-decoration-none footer-link"><i class="bi bi-book-fill me-1" style="color:#ffc107;"></i>Cours</a>
        <a href="#" class="mx-2 text-light text-decoration-none footer-link"><i class="bi bi-journal-text me-1" style="color:#198754;"></i>Leçons</a>
        <a href="#" class="mx-2 text-light text-decoration-none footer-link"><i class="bi bi-envelope-fill me-1" style="color:#dc3545;"></i>Contact</a>
      </div>
      <div class="col-md-4 text-md-end text-center">
        <a href="#" class="mx-1" title="Facebook"><i class="bi bi-facebook fs-5" style="color:#1877f3;"></i></a>
        <a href="#" class="mx-1" title="Twitter"><i class="bi bi-twitter fs-5" style="color:#1da1f2;"></i></a>
        <a href="#" class="mx-1" title="LinkedIn"><i class="bi bi-linkedin fs-5" style="color:#0a66c2;"></i></a>
        <a href="#" class="mx-1" title="Instagram"><i class="bi bi-instagram fs-5" style="color:#e4405f;"></i></a>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col text-center">
        <small class="text-muted">Conçu avec <i class="bi bi-heart-fill" style="color:#dc3545;"></i> par l'équipe MetaSchool</small>
      </div>
    </div>
  </div>
</footer>

<style>
  .footer-link:hover {
    color: #7C3AED !important;
    text-decoration: underline !important;
    transition: color 0.2s;
  }
</style>
            </form>
        </div>
    </div>
</div>

<!-- Data attributes for JavaScript -->
<div id="data-sections" data-sections='@json($sections)' style="display: none;"></div>
<div id="data-modules" data-modules='@json($modules)' style="display: none;"></div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtrage dynamique sections/modules
    const courseSelect = document.getElementById('course_id');
    const sectionSelect = document.getElementById('section_id');
    const moduleSelect = document.getElementById('module_id');
    // Initialisation : affiche les options sélectionnées à l'édition
    function showInitialOptions() {
        const selectedCourse = courseSelect.value;
        Array.from(sectionSelect.options).forEach(option => {
            if (!option.value) return;
            option.style.display = (option.getAttribute('data-course') === selectedCourse) ? '' : 'none';
        });
        const selectedSection = sectionSelect.value;
        Array.from(moduleSelect.options).forEach(option => {
            if (!option.value) return;
            option.style.display = (option.getAttribute('data-section') === selectedSection) ? '' : 'none';
        });
    }
    showInitialOptions();
    courseSelect.addEventListener('change', function() {
        const courseId = this.value;
        Array.from(sectionSelect.options).forEach(option => {
            if (!option.value) return;
            option.style.display = option.getAttribute('data-course') === courseId ? '' : 'none';
        });
        sectionSelect.value = '';
        Array.from(moduleSelect.options).forEach(option => {
            if (!option.value) return;
            option.style.display = 'none';
        });
        moduleSelect.value = '';
    });
    sectionSelect.addEventListener('change', function() {
        const sectionId = this.value;
        Array.from(moduleSelect.options).forEach(option => {
            if (!option.value) return;
            option.style.display = option.getAttribute('data-section') === sectionId ? '' : 'none';
        });
        moduleSelect.value = '';
    });

    // Labels par défaut si translations non défini
    const videoTitle = (typeof translations !== 'undefined' && translations.videoTitle) ? translations.videoTitle : 'Titre vidéo';
    const videoURL = (typeof translations !== 'undefined' && translations.videoURL) ? translations.videoURL : 'URL vidéo';
    const videoDescription = (typeof translations !== 'undefined' && translations.videoDescription) ? translations.videoDescription : 'Description vidéo';
    const documentTitle = (typeof translations !== 'undefined' && translations.documentTitle) ? translations.documentTitle : 'Titre document';
    const documentFile = (typeof translations !== 'undefined' && translations.documentFile) ? translations.documentFile : 'Fichier document';
    const documentDescription = (typeof translations !== 'undefined' && translations.documentDescription) ? translations.documentDescription : 'Description document';

    // Ajout dynamique de vidéos
    let videoIndex = 1;
    document.getElementById('add-video-button').addEventListener('click', function() {
        const videoGroups = document.getElementById('video-groups');
        const group = document.createElement('div');
        group.className = 'video-group mt-3';
        group.innerHTML = `
            <div class="form-group mt-3">
                <label for="video_title_${videoIndex}">${videoTitle}</label>
                <input type="text" name="videos[${videoIndex}][title]" id="video_title_${videoIndex}" class="form-control" placeholder="${videoTitle}">
            </div>
            <div class="form-group mt-3">
                <label for="video_url_${videoIndex}" class="mt-2">${videoURL}</label>
                <input type="text" name="videos[${videoIndex}][url]" id="video_url_${videoIndex}" class="form-control" placeholder="${videoURL}">
            </div>
            <div class="form-group mt-3">
                <label for="video_description_${videoIndex}" class="mt-2">${videoDescription}</label>
                <textarea name="videos[${videoIndex}][description]" id="video_description_${videoIndex}" class="form-control" rows="3" placeholder="${videoDescription}"></textarea>
            </div>
            <button type="button" class="btn btn-danger btn-sm mt-2 remove-video">Supprimer</button>
        `;
        videoGroups.appendChild(group);
        videoIndex++;
    });

    // Ajout dynamique de documents
    let documentIndex = 1;
    document.getElementById('add-document-button').addEventListener('click', function() {
        const documentGroups = document.getElementById('document-groups');
        const group = document.createElement('div');
        group.className = 'document-group mt-3';
        group.innerHTML = `
            <div class="form-group mt-3">
                <label for="document_title_${documentIndex}">${documentTitle}</label>
                <input type="text" name="documents[${documentIndex}][title]" id="document_title_${documentIndex}" class="form-control" placeholder="${documentTitle}">
            </div>
            <div class="form-group mt-3">
                <label for="document_file_${documentIndex}" class="mt-2">${documentFile}</label>
                <input type="file" name="documents[${documentIndex}][file]" accept=".pdf,.doc,.docx,.xls,.xlsx,.txt" id="document_file_${documentIndex}" class="form-control">
            </div>
            <div class="form-group mt-3">
                <label for="document_description_${documentIndex}" class="mt-2">${documentDescription}</label>
                <textarea name="documents[${documentIndex}][description]" id="document_description_${documentIndex}" class="form-control" rows="3" placeholder="${documentDescription}"></textarea>
            </div>
            <button type="button" class="btn btn-danger btn-sm mt-2 remove-document">Supprimer</button>
        `;
        documentGroups.appendChild(group);
        documentIndex++;
    });

    // Suppression dynamique des vidéos
    document.getElementById('video-groups').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-video')) {
            e.target.closest('.video-group').remove();
        }
    });

    // Suppression dynamique des documents
    document.getElementById('document-groups').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-document')) {
            e.target.closest('.document-group').remove();
        }
    });
});
</script>
@endpush
