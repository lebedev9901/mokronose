<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */

        public function index($page = 'profile')
        {
            $user = auth()->user();

            $orders = collect();
            $chats = collect();

            // Заказы
            if ($page === 'orders') {

                $orders = auth()->user()
                    ->orders()
                    ->latest()
                    ->paginate(10);
            }

            // Поддержка
            if ($page === 'support') {

                $chats = \App\Models\SupportChat::with('message')
                    ->where('user_id', auth()->id())
                    ->latest()
                    ->get();
            }

            $page = $page ?? 'profile';

            return view(
                'profile.index',
                compact(
                    'user',
                    'page',
                    'orders',
                    'chats'
                )
            );
        }

    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */


public function update(Request $request)
{
    $user = auth()->user();

    $request->validate([
        'first_name' => 'nullable|string',
        'last_name' => 'nullable|string',
        'middle_name' => 'nullable|string',
        'email' => 'required|email',
        'phone' => 'nullable|string',
        'avatar' => 'nullable|image|max:2048',
    ]);

    // UPDATE TEXT FIELDS
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->middle_name = $request->middle_name;
    $user->email = $request->email;
    $user->phone = $request->phone;

    // ✔ AVATAR FIX
    if ($request->hasFile('avatar')) {

        $file = $request->file('avatar');

        $path = $file->store('avatars', 'public');

        $user->avatar = '/storage/' . $path;
    }

    $user->save();

    return response()->json([
        'success' => true,
        'user' => $user
    ]);
}
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    
}
