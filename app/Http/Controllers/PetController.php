<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('profile.sections.pet', compact('pets'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'age_group' => 'nullable|string|max:255',
            'breed_size' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0|max:200',
            'notes' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request
                ->file('avatar')
                ->store('pets', 'public');
        }

        $data['user_id'] = auth()->id();

        Pet::create($data);

        return redirect()
            ->route('profile.page', ['page' => 'pet'])
            ->with('success', 'Питомец добавлен');
    }

    public function update(Request $request, Pet $pet)
    {
        abort_if($pet->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'age_group' => 'nullable|string|max:255',
            'breed_size' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0|max:200',
            'notes' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($pet->avatar && Storage::disk('public')->exists($pet->avatar)) {
                Storage::disk('public')->delete($pet->avatar);
            }

            $data['avatar'] = $request
                ->file('avatar')
                ->store('pets', 'public');
        }

        $pet->update($data);

        return redirect()
            ->route('profile.page', ['page' => 'pet'])
            ->with('success', 'Питомец обновлён');
    }

    public function destroy(Pet $pet)
    {
        abort_if($pet->user_id !== auth()->id(), 403);

        if ($pet->avatar && Storage::disk('public')->exists($pet->avatar)) {
            Storage::disk('public')->delete($pet->avatar);
        }

        $pet->delete();

        return redirect()
            ->route('profile.page', ['page' => 'pet'])
            ->with('success', 'Питомец удалён');
    }
}