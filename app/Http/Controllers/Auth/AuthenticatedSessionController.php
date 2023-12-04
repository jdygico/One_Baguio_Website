<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors(['email' => 'Invalid email or password'])
                ->withInput($request->only('email', 'remember'));
        }
    
        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            // Authentication passed...
            $user = Auth::user();
            $user_id = Auth::id();
    
            if ($user->hasRole('user')) {
                return redirect()->route('patients.display',  $user_id);
            } else {
                return redirect()->route('dashboard');
            }
        } else {
            return redirect()->back()
                ->withErrors(['email' => 'Invalid email or password'])
                ->withInput($request->only('email', 'remember'));
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
