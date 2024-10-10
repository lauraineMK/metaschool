@extends('layouts.app')

@section('title', 'Home - MetaSchool')

@section('content')
<div class="container text-center pt-5">
    <h1 class="pt-5">Welcome to MetaSchool</h1>
    <!-- <h1 class="pt-5">{{ __('welcome_to_metaschool') }}</h1> -->

    <p class="lead highlight-paragraph text-justify mt-4">
        MetaSchool is part of Metaboussolle, offering courses designed by teachers.
        Students need to create an account and log in, not so much to gain access,
        but rather to find out what courses which they've taken and how they're progressing.<br>
        This part of the site is currently in American English, but will no doubt soon be available in other languages.<br>
        <span class="container text-center">Have fun learning! &#128521;</span>
    </p>
</div>
@endsection
