<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    /**
     * Display all outlets.
     */
    public function index()
    {
        $outlets = Outlet::withCount([
            'counters',
            'foods',
            'users'
        ])
        ->latest()
        ->get();

        return view(
            'outlets.index',
            compact('outlets')
        );
    }


    /**
     * Show create outlet form.
     */
    public function create()
    {
        return view('outlets.create');
    }


    /**
     * Store a new outlet.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'outlet_name' => 'required|string|max:255',

            'location' => 'required|string|max:500',

            'contact_number' => 'nullable|string|max:50',

            'google_maps_url' => 'nullable|string|max:2000',

            'status' => 'required|in:active,inactive',
        ]);

        Outlet::create($data);

        return redirect()
            ->route('outlets.index')
            ->with(
                'success',
                'Outlet created successfully.'
            );
    }


    /**
     * Show outlet details.
     */
    public function show(Outlet $outlet)
    {
        $outlet->load([
            'counters',
            'users',
            'foods'
        ]);

        return view(
            'outlets.show',
            compact('outlet')
        );
    }


    /**
     * Show edit outlet form.
     */
    public function edit(Outlet $outlet)
    {
        return view(
            'outlets.edit',
            compact('outlet')
        );
    }


    /**
     * Update outlet.
     */
    public function update(
        Request $request,
        Outlet $outlet
    ) {
        $data = $request->validate([
            'outlet_name' => 'required|string|max:255',

            'location' => 'required|string|max:500',

            'contact_number' => 'nullable|string|max:50',

            'google_maps_url' => 'nullable|string|max:2000',

            'status' => 'required|in:active,inactive',
        ]);

        $outlet->update($data);

        return redirect()
            ->route('outlets.index')
            ->with(
                'success',
                'Outlet updated successfully.'
            );
    }


    /**
     * Delete outlet.
     *
     * An outlet that already has staff or orders
     * should not be physically deleted.
     * Deactivate it instead.
     */
    public function destroy(Outlet $outlet)
    {
        if (
            $outlet->orders()->exists() ||
            $outlet->users()->exists()
        ) {
            return back()->with(
                'error',
                'This outlet has staff or orders and cannot be deleted. Deactivate it instead.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Remove counter-food assignments before deleting
        |--------------------------------------------------------------------------
        */

        foreach ($outlet->counters as $counter) {
            $counter->foods()->detach();
        }

        $outlet->delete();

        return redirect()
            ->route('outlets.index')
            ->with(
                'success',
                'Outlet deleted successfully.'
            );
    }
}