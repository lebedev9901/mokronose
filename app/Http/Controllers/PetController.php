<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
{
    $pets = Pet::where('user_id', auth()->id())
        ->latest()
        ->get();

    return response()->json([
        'pets' => $pets,
    ]);
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

        $pet = Pet::create($data);

        return response()->json([
            'success' => true,
            'pet' => $pet,
        ]);
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

            $avatar = $request
                ->file('avatar')
                ->store('pets', 'public');

            $data['avatar'] = $avatar;
        }

        $pet->update($data);

        return response()->json([
            'success' => true,
            'pet' => $pet,
        ]);
    }

    public function destroy(Pet $pet)
    {
        abort_if($pet->user_id !== auth()->id(), 403);

        $pet->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
