<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Outlet;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $outlets = Outlet::all();
        return view('outlets.index', compact('outlets'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('outlets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'outlet_name' => 'required',
        'location' => 'required',
        'contact_number' => 'nullable'
    ]);


    Outlet::create([
        'outlet_name' => $request->outlet_name,
        'location' => $request->location,
        'contact_number' => $request->contact_number
    ]);


    return redirect()->route('outlets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $outlet = Outlet::findOrFail($id);

    return view('outlets.edit', compact('outlet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    $request->validate([
        'outlet_name' => 'required',
        'location' => 'required',
        'contact_number' => 'nullable'
    ]);


    $outlet = Outlet::findOrFail($id);


    $outlet->update([
        'outlet_name' => $request->outlet_name,
        'location' => $request->location,
        'contact_number' => $request->contact_number
    ]);


    return redirect()->route('outlets.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    $outlet = Outlet::findOrFail($id);

    $outlet->delete();

    return redirect()->route('outlets.index');
    }
}
