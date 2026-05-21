<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\CartController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
 public function store(LoginRequest $request): RedirectResponse
    {
        $guestCartId = Cart::where('session_id', $request->session()->getId())
        ->whereNull('user_id')
        ->value('id');

    $user = User::where('email', $request->input('email'))->first();

    if (! $user || ! Hash::check($request->input('password'), $user->password)) {
        $request->authenticate();
    }

    if ($guestCartId) {
        CartController::mergeGuestCartBeforeLogin($guestCartId, $user->id);
    }

    $request->authenticate();

    $request->session()->regenerate();

    return redirect()->intended(route('profile.index'));
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
