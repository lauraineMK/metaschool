@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h1 class="mb-4 fw-bold" style="color: #7C3AED;">Foire Aux Questions (FAQ)</h1>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="faq1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                    Comment puis-je m'inscrire à MetaSchool ?
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Cliquez sur "Inscription" dans le menu, remplissez le formulaire et validez. Vous recevrez un email de confirmation.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="faq2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                    Puis-je suivre plusieurs cours à la fois ?
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Non, chaque étudiant ne peut suivre qu'un seul cours à la fois pour garantir un apprentissage optimal.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="faq3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                    Comment accéder à mes cours ?
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Rendez-vous dans "Mes cours" depuis le menu ou le dashboard pour accéder à votre cours en cours.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="faq4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                    Comment contacter un enseignant ou l'équipe support ?
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Utilisez la page "Contact" pour envoyer un message à l'équipe MetaSchool. Pour contacter un enseignant, utilisez la messagerie interne si disponible.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="faq5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                    Comment télécharger les ressources d'une leçon ?
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="faq5" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Sur la page de chaque leçon, les documents téléchargeables sont accessibles via un bouton "Télécharger".
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
