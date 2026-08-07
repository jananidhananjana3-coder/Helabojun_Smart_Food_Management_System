<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Category;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{

    public function index()
    {
        $foods = Food::with(['category','outlet'])->latest()->get();

        return view('foods.index', compact('foods'));
    }


    public function create()
    {
        $categories = Category::all();
        $outlets = Outlet::all();

        return view('foods.create', compact('categories','outlets'));
    }


    public function store(Request $request)
    {

        $request->validate([

            'category_id' => 'required',
            'outlet_id' => 'required',
            'food_name' => 'required|string|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'available_quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);


        $image = null;

        if($request->hasFile('image')){

            $image = $request->file('image')->store('foods','public');

        }


        Food::create([

            'category_id' => $request->category_id,
            'outlet_id' => $request->outlet_id,
            'food_name' => $request->food_name,
            'description' => $request->description,
            'price' => $request->price,
            'available_quantity' => $request->available_quantity,
            'image' => $image,

        ]);


        return redirect()
                ->route('foods.index')
                ->with('success','Food Added Successfully.');

    }



    public function edit(string $id)
    {

        $food = Food::findOrFail($id);

        $categories = Category::all();

        $outlets = Outlet::all();

        return view('foods.edit', compact(
            'food',
            'categories',
            'outlets'
        ));

    }



    public function update(Request $request, string $id)
    {

        $request->validate([

            'category_id' => 'required',
            'outlet_id' => 'required',
            'food_name' => 'required|string|max:255',
            'description' => 'nullable',
            'price' => 'required|numeric',
            'available_quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);


        $food = Food::findOrFail($id);


        $image = $food->image;


        if($request->hasFile('image')){

            if($food->image){

                Storage::disk('public')->delete($food->image);

            }

            $image = $request->file('image')->store('foods','public');

        }


        $food->update([

            'category_id' => $request->category_id,
            'outlet_id' => $request->outlet_id,
            'food_name' => $request->food_name,
            'description' => $request->description,
            'price' => $request->price,
            'available_quantity' => $request->available_quantity,
            'image' => $image,

        ]);


        return redirect()
                ->route('foods.index')
                ->with('success','Food Updated Successfully.');

    }



    public function destroy(string $id)
    {

        $food = Food::findOrFail($id);


        if($food->image){

            Storage::disk('public')->delete($food->image);

        }


        $food->delete();


        return redirect()
                ->route('foods.index')
                ->with('success','Food Deleted Successfully.');

    }

}