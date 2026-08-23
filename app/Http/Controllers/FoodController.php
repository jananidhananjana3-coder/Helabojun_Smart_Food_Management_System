<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Category;
use App\Models\Outlet;
use App\Models\Counter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    /**
     * Display all foods.
     */
    public function index()
    {
        $foods = Food::with([
            'category',
            'outlet',
            'counters',
        ])
            ->latest()
            ->get();

        return view(
            'foods.index',
            compact('foods')
        );
    }

    /**
     * Show create food form.
     */
    public function create()
    {
        $categories = Category::orderBy(
            'category_name'
        )->get();

        $outlets = Outlet::where(
            'status',
            'active'
        )
            ->orderBy('outlet_name')
            ->get();

        $counters = Counter::where(
            'status',
            'active'
        )
            ->orderBy('outlet_id')
            ->orderBy('counter_number')
            ->get();

        return view(
            'foods.create',
            compact(
                'categories',
                'outlets',
                'counters'
            )
        )->with(
            'editing',
            false
        );
    }

    /**
     * Store a new food.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' =>
                'required|exists:categories,id',

            'outlet_id' =>
                'required|exists:outlets,id',

            'food_name' =>
                'required|string|max:255',

            'description' =>
                'nullable|string',

            'price' =>
                'required|numeric|min:0',

            'image' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'counter_quantities' =>
                'required|array|min:1',

            'counter_quantities.*' =>
                'nullable|integer|min:0',
        ]);

        $counterIds = array_keys(
            $data['counter_quantities']
        );

        $validCounters = Counter::where(
                'outlet_id',
                $data['outlet_id']
            )
            ->where('status', 'active')
            ->whereIn('id', $counterIds)
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();

        $requestedCounters = array_map(
            'strval',
            $counterIds
        );

        sort($validCounters);
        sort($requestedCounters);

        if ($validCounters !== $requestedCounters) {
            return back()
                ->withErrors([
                    'counter_quantities' =>
                        'Select only active counters belonging to the selected outlet.',
                ])
                ->withInput();
        }

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request
                ->file('image')
                ->store('foods', 'public');
        }

        DB::transaction(function () use (
            $data,
            $image
        ) {
            $food = Food::create([
                'category_id' =>
                    $data['category_id'],

                'outlet_id' =>
                    $data['outlet_id'],

                'food_name' =>
                    $data['food_name'],

                'description' =>
                    $data['description'] ?? null,

                'price' =>
                    $data['price'],

                /*
                 * Admin does not control operational stock.
                 */
                'available_quantity' => 0,

                'image' =>
                    $image,
            ]);

            /*
             * Every newly assigned counter starts at 0.
             * Chef controls the operational quantity.
             */
            $sync = [];

            foreach (
                $data['counter_quantities']
                as $counterId => $quantity
            ) {
                $sync[$counterId] = [
                    'quantity' => 0,
                ];
            }

            $food->counters()->sync($sync);
        });

        return redirect()
            ->route('foods.index')
            ->with(
                'success',
                'Food created successfully. The chef controls operational quantity per counter.'
            );
    }

    /**
     * Show a single food.
     */
    public function show(Food $food)
    {
        $food->load([
            'category',
            'outlet',
            'counters',
        ]);

        return view(
            'foods.show',
            compact('food')
        );
    }

    /**
     * Show edit food form.
     */
    public function edit(Food $food)
    {
        $food->load('counters');

        $categories = Category::orderBy(
            'category_name'
        )->get();

        $outlets = Outlet::where(
                'status',
                'active'
            )
            ->orderBy('outlet_name')
            ->get();

        $counters = Counter::where(
                'outlet_id',
                $food->outlet_id
            )
            ->where(
                'status',
                'active'
            )
            ->orderBy('counter_number')
            ->get();

        return view(
            'foods.create',
            compact(
                'food',
                'categories',
                'outlets',
                'counters'
            )
        )->with(
            'editing',
            true
        );
    }

    /**
     * Update an existing food.
     */
    public function update(
        Request $request,
        Food $food
    ) {
        $data = $request->validate([
            'category_id' =>
                'required|exists:categories,id',

            'outlet_id' =>
                'required|exists:outlets,id',

            'food_name' =>
                'required|string|max:255',

            'description' =>
                'nullable|string',

            'price' =>
                'required|numeric|min:0',

            'image' =>
                'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

            'counter_quantities' =>
                'required|array|min:1',

            'counter_quantities.*' =>
                'nullable|integer|min:0',
        ]);

        $counterIds = array_keys(
            $data['counter_quantities']
        );

        $validCounters = Counter::where(
                'outlet_id',
                $data['outlet_id']
            )
            ->where(
                'status',
                'active'
            )
            ->whereIn(
                'id',
                $counterIds
            )
            ->pluck('id')
            ->map(fn ($id) => (string) $id)
            ->all();

        $requestedCounters = array_map(
            'strval',
            $counterIds
        );

        sort($validCounters);
        sort($requestedCounters);

        if ($validCounters !== $requestedCounters) {
            return back()
                ->withErrors([
                    'counter_quantities' =>
                        'Select only active counters belonging to the selected outlet.',
                ])
                ->withInput();
        }

        $oldImage = $food->image;
        $newImage = null;

        if ($request->hasFile('image')) {
            $newImage = $request
                ->file('image')
                ->store('foods', 'public');
        }

        DB::transaction(function () use (
            $food,
            $data,
            $newImage
        ) {
            $food->update([
                'category_id' =>
                    $data['category_id'],

                'outlet_id' =>
                    $data['outlet_id'],

                'food_name' =>
                    $data['food_name'],

                'description' =>
                    $data['description'] ?? null,

                'price' =>
                    $data['price'],

                'image' =>
                    $newImage ?? $food->image,
            ]);

            /*
             * Preserve existing Chef quantities.
             *
             * Existing counter:
             *     keep current quantity.
             *
             * New counter:
             *     start at 0.
             *
             * Removed counter:
             *     detach.
             */
            $currentPivot = DB::table('food_counter')
                ->where(
                    'food_id',
                    $food->id
                )
                ->pluck(
                    'quantity',
                    'counter_id'
                )
                ->toArray();

            $sync = [];

            foreach (
                array_keys(
                    $data['counter_quantities']
                ) as $counterId
            ) {
                $sync[$counterId] = [
                    'quantity' =>
                        isset(
                            $currentPivot[$counterId]
                        )
                            ? (int) $currentPivot[$counterId]
                            : 0,
                ];
            }

            $food->counters()->sync($sync);
        });

        if (
            $newImage &&
            $oldImage &&
            $oldImage !== $newImage
        ) {
            Storage::disk('public')
                ->delete($oldImage);
        }

        return redirect()
            ->route('foods.index')
            ->with(
                'success',
                'Food updated successfully.'
            );
    }

    /**
     * Delete a food.
     */
    public function destroy(Food $food)
    {
        if ($food->image) {
            Storage::disk('public')
                ->delete($food->image);
        }

        $food->counters()->detach();

        $food->delete();

        return back()
            ->with(
                'success',
                'Food deleted successfully.'
            );
    }
}