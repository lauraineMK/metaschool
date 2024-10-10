<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/**
 * Class LanguageController
 *
 * This controller handles the language change functionality of the application.
 * It allows users to switch between supported languages and stores the selected
 * language in the session for future requests.
 *
 * Supported languages: English (en), French (fr), German (de), Dutch (nl).
 */
class LanguageController extends Controller
{
    /**
     * Change the application language.
     *
     * @param string $locale The locale to switch to.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the previous page.
     */
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
