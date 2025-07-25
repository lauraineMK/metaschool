@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <h1 class="mb-4 fw-bold" style="color: #7C3AED;">Contactez-nous</h1>
                    <p class="lead mb-4">Une question, une suggestion ou besoin d'aide ? Remplissez le formulaire ci-dessous, notre équipe vous répondra rapidement.</p>
                    <form method="POST" action="#">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nom</label>
                            <input type="text" class="form-control rounded-pill" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control rounded-pill" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control rounded-4" id="message" name="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
