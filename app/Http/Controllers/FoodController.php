<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Category;
use App\Models\Outlet;
use Illuminate\Http\Request;


class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $foods = Food::with(['category', 'outlet'])->get();

    return view('foods.index', compact('foods'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $categories = Category::all();
    $outlets = Outlet::all();

    return view('foods.create', compact('categories', 'outlets'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'category_id' => 'required',
        'outlet_id' => 'required',
        'food_name' => 'required',
        'price' => 'required',
        'available_quantity' => 'required',
    ]);

    Food::create([
        'category_id' => $request->category_id,
        'outlet_id' => $request->outlet_id,
        'food_name' => $request->food_name,
        'description' => $request->description,
        'price' => $request->price,
        'available_quantity' => $request->available_quantity,
    ]);

    return redirect()->route('foods.index');
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
    $food = Food::findOrFail($id);

    $categories = Category::all();
    $outlets = Outlet::all();

    return view('foods.edit', compact('food', 'categories', 'outlets'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'category_id' => 'required',
        'outlet_id' => 'required',
        'food_name' => 'required',
        'price' => 'required',
        'available_quantity' => 'required',
    ]);

    $food = Food::findOrFail($id);

    $food->update([
        'category_id' => $request->category_id,
        'outlet_id' => $request->outlet_id,
        'food_name' => $request->food_name,
        'description' => $request->description,
        'price' => $request->price,
        'available_quantity' => $request->available_quantity,
    ]);

    return redirect()->route('foods.index');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    $food = Food::findOrFail($id);

    $food->delete();

    return redirect()->route('foods.index');
}
}
