<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promocode;
use Illuminate\Http\Request;

class PromocodeController extends Controller
{
    public function index()
    {
        $promocodes = Promocode::latest()->paginate(20);

        return view('admin.promocodes.index', compact('promocodes'));
    }

    public function create()
    {
        return view('admin.promocodes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:promocodes,code'],
            'title' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:percent,fixed'],
            'value' => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date'],
        ]);

        $data['code'] = strtoupper(trim($data['code']));
        $data['is_active'] = $request->boolean('is_active');

        Promocode::create($data);

        return redirect()
            ->route('admin.promocodes.index')
            ->with('success', 'Промокод создан');
    }

    public function edit(Promocode $promocode)
    {
        return view('admin.promocodes.edit', compact('promocode'));
    }

    public function update(Request $request, Promocode $promocode)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:promocodes,code,' . $promocode->id],
            'title' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:percent,fixed'],
            'value' => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
            'starts_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date'],
        ]);

        $data['code'] = strtoupper(trim($data['code']));
        $data['is_active'] = $request->boolean('is_active');

        $promocode->update($data);

        return redirect()
            ->route('admin.promocodes.index')
            ->with('success', 'Промокод обновлён');
    }

    public function destroy(Promocode $promocode)
    {
        $promocode->delete();

        return back()->with('success', 'Промокод удалён');
    }
}