<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
{
    $users = User::latest()->get();

    return view('admin.users.index', compact('users'));
}

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back();
    }

    public function show(User $user)
    {
        $user->load([
            'pets',
            'orders',
            'reviews.product',
            'favorites.product',
            'addresses',
        ]);

        $stats = [
            'orders' => $user->orders->count(),
            'spent' => $user->orders
                ->where('status', 'completed')
                ->sum('total_after_discount'),

            'pets' => $user->pets->count(),

            'reviews' => $user->reviews->count(),

            'favorites' => $user->favorites->count(),

            'last_order' => $user->orders
                ->sortByDesc('created_at')
                ->first(),
        ];

        return view('admin.users.show', compact(
            'user',
            'stats'
        ));
    }
}
