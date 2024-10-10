<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    /**
     * Display the login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Simple User-Agent verification for mobile detection
        $isMobile = strpos(request()->header('User-Agent'), 'Mobile') !== false;

        return view('auth.login', ['isMobile' => $isMobile]);
    }

    /**
     * Handle login attempt
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Role-based redirection
            if ($user->role === 'teacher') {
                return redirect()->route('teacher.dashboard');
            }

            return redirect()->route('student.dashboard');
        }

        return redirect('login')->withErrors(['email' => __('messages.invalid_credentials')]);
    }

    /**
     * Handle user logout
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    /** Display the registration form
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        // Simple User-Agent verification for mobile detection
        $isMobile = strpos(request()->header('User-Agent'), 'Mobile') !== false;

        return view('auth.register', ['isMobile' => $isMobile]);
    }

    /**
     * Handle registration
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'middlename' => $request->middlename,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        // Role-based redirection
        if ($user->role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        }

        return redirect()->route('student.dashboard');
    }

    /**
     * Display the account page for screens smaller than 599px
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return view('auth.account');
    }

    /**
     * Update the authenticated user's account information.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Retrieve the currently authenticated user
        $user = auth()->user();

        // Validate the incoming request data
        $request->validate([
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . $user->id
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update the user's information
        $user->firstname = $request->firstname;
        $user->middlename = $request->middlename;
        $user->lastname = $request->lastname;
        $user->email = $request->email;

        // Update the password if a new password is provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success',  __('messages.account_successfully_updated'));
    }
}
