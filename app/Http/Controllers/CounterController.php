<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Outlet;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function index()
    {
        $counters = Counter::with('outlet')
            ->orderBy('outlet_id')
            ->orderByRaw('CAST(counter_number AS UNSIGNED)')
            ->get();

        return view(
            'counters.index',
            compact('counters')
        );
    }

    public function create()
    {
        $outlets = Outlet::where('status', 'active')
            ->orderBy('outlet_name')
            ->get();

        return view(
            'counters.create',
            compact('outlets')
        )->with('editing', false);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'counter_number' => 'required|integer|min:1',
            'counter_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $exists = Counter::where(
                'outlet_id',
                $data['outlet_id']
            )
            ->where(
                'counter_number',
                $data['counter_number']
            )
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'counter_number' =>
                        'That counter number already exists in this outlet.'
                ])
                ->withInput();
        }

        Counter::create($data);

        return redirect()
            ->route('counters.index')
            ->with(
                'success',
                'Counter created successfully.'
            );
    }

    public function edit(Counter $counter)
    {
        $outlets = Outlet::where('status', 'active')
            ->orderBy('outlet_name')
            ->get();

        return view(
            'counters.edit',
            compact(
                'counter',
                'outlets'
            )
        )->with('editing', true);
    }

    public function update(
        Request $request,
        Counter $counter
    ) {
        $data = $request->validate([
            'outlet_id' => 'required|exists:outlets,id',
            'counter_number' => 'required|integer|min:1',
            'counter_name' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $exists = Counter::where(
                'outlet_id',
                $data['outlet_id']
            )
            ->where(
                'counter_number',
                $data['counter_number']
            )
            ->where(
                'id',
                '!=',
                $counter->id
            )
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'counter_number' =>
                        'That counter number already exists in this outlet.'
                ])
                ->withInput();
        }

        $counter->update($data);

        return redirect()
            ->route('counters.index')
            ->with(
                'success',
                'Counter updated successfully.'
            );
    }

    public function destroy(Counter $counter)
    {
        if (
            $counter->orders()->exists() ||
            $counter->users()->exists()
        ) {
            return back()->with(
                'error',
                'This counter is already used by staff or orders. Set it inactive instead.'
            );
        }

        $counter->foods()->detach();

        $counter->delete();

        return back()->with(
            'success',
            'Counter deleted successfully.'
        );
    }
}