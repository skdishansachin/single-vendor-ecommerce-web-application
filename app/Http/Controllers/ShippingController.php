<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ShippingController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Shipping::class);

        $shippings = Shipping::paginate(10);

        return view('dashboard.shippings.index', [
            'shippings' => $shippings,
        ]);
    }

    public function create()
    {
        Gate::authorize('create', Shipping::class);

        return view('dashboard.shippings.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        Gate::authorize('create', Shipping::class);

        $request->validate([
            'name' => ['required', 'string', 'unique:shippings,name'],
            'description' => ['nullable', 'string'],
            'is_free' => ['boolean', Rule::requiredIf($request->input('cost') == null)],
            'cost' => ['required_if:is_free,false', 'nullable', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'max_delivery_estimate' => ['required', 'integer', 'min:1'],
            'min_delivery_estimate' => ['required', 'integer', 'min:1', 'lte:max_delivery_estimate'],
            'conditions' => ['nullable', 'array'],
            'conditions.*.type' => ['required_with:conditions', Rule::in(['min_total', 'max_total', 'min_items', 'max_items'])],
            'conditions.*.value' => ['required_with:conditions', 'numeric', 'min:0'],
        ]);

        $shipping = Shipping::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_free' => $request->has('is_free'),
            'cost' => $request->input('cost', 0),
            'is_active' => $request->has('is_active'),
            'max_delivery_estimate' => $request->max_delivery_estimate,
            'min_delivery_estimate' => $request->min_delivery_estimate,
            'conditions' => $request->input('conditions', []),
        ]);

        return redirect()->route('dashboard.shippings.edit', $shipping)->with('message', 'Shipping created successfully.');
    }

    public function edit(Shipping $shipping)
    {
        Gate::authorize('update', $shipping);

        return view('dashboard.shippings.edit', [
            'shipping' => $shipping,
        ]);
    }

    public function update(Request $request, Shipping $shipping)
    {
        Gate::authorize('update', $shipping);

        $request->validate([
            'name' => ['required', 'string', Rule::unique('shippings')->ignore($shipping->id)],
            'description' => ['nullable', 'string'],
            'is_free' => ['boolean', Rule::requiredIf($request->input('cost') == null)],
            'cost' => ['required_if:is_free,false', 'nullable', 'numeric', 'min:0'],
            'is_active' => ['boolean'],
            'max_delivery_estimate' => ['required', 'integer', 'min:1'],
            'min_delivery_estimate' => ['required', 'integer', 'min:1', 'lte:max_delivery_estimate'],
            'conditions' => ['nullable', 'array'],
            'conditions.*.type' => ['required_with:conditions', 'string', Rule::in(['min_total', 'max_total', 'min_items', 'max_items'])],
            'conditions.*.value' => ['required_with:conditions', 'numeric', 'min:0'],
        ]);

        // Update the shipping profile
        $shipping->update([
            'name' => $request->name,
            'description' => $request->description,
            'is_free' => $request->has('is_free'),
            'cost' => $request->input('cost', 0),
            'is_active' => $request->has('is_active'),
            'max_delivery_estimate' => $request->max_delivery_estimate,
            'min_delivery_estimate' => $request->min_delivery_estimate,
            'conditions' => $request->input('conditions', []),
        ]);

        return redirect()->route('dashboard.shippings.edit', $shipping)
            ->with('message', 'Shipping profile updated successfully.');
    }
}
