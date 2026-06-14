<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'city' => 'nullable|string|max:255',
            'street' => 'required|string|max:255',
            'house' => 'required|string|max:50',
            'apartment' => 'nullable|string|max:50',
        ]);

        $data['user_id'] = auth()->id();

        $address = Address::create($data);

        return response()->json([
        'success' => true,
        'address' => $address
        ]);
    }

    public function create()
    {
        return view('profile.sections.create-addr');
    }

    public function destroy($id)
    {
        $address = Address::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $address->delete();

        return response()->json([
            'success' => true
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'city' => 'nullable|string',
            'street' => 'required|string',
            'house' => 'required|string',
            'apartment' => 'nullable|string',
        ]);

        $address = Address::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $address->update($data);

        return response()->json([
            'success' => true,
            'address' => $address
        ]);
    }

   public function setMain($id)
    {
        $user = auth()->user();

        $user->addresses()->update([
            'is_default' => 0
        ]);

        $address = $user->addresses()->where('id', $id)->firstOrFail();

        $address->update([
            'is_default' => 1
        ]);

        return response()->json([
            'success' => true,
            'address_id' => $id
        ]);
    }

    public function storeAjax(Request $request)
    {
        $data = $request->validate([
            'city' => ['nullable', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'house' => ['required', 'string', 'max:50'],
            'apartment' => ['nullable', 'string', 'max:50'],
        ]);

        $data['user_id'] = auth()->id();

        $address = Address::create($data);

        return response()->json([
            'success' => true,
            'address' => [
                'id' => $address->id,
                'city' => $address->city,
                'street' => $address->street,
                'house' => $address->house,
                'apartment' => $address->apartment,
                'is_default' => $address->is_default ?? false,
            ],
        ]);
    }
}


