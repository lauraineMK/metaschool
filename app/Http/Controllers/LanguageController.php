<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change($locale)
    {
        // Check if the language is supported
        if (in_array($locale, ['en', 'fr', 'de', 'nl'])) {
            // Set application locale
            App::setLocale($locale);

            // Save the language in the session for use in future requests
            Session::put('locale', $locale);
        }
        // else {
        //     abort(400); // Error 400 if language not supported
        // }

        // Redirect to the previous page or home page
        return redirect()->back();
    }
}
