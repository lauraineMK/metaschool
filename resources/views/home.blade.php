@extends('layouts.app')

@section('title', 'Home - MetaSchool')

@section('content')
<div class="container text-center pt-5">

    <h1 class="pt-5">{{ __('messages.welcome_to_metaschool') }}</h1>

    <p class="lead highlight-paragraph text-justify mt-4">
    {{ __('messages.first_part') }}<br>
    {{ __('messages.second_part') }}<br>
        <span class="container text-center">{{ __('messages.have_fun_learning') }} &#128521;</span>
    </p>
</div>
@endsection
