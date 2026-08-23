<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class CustomerDisplayController extends Controller
{
    /**
     * Display foods that are available at least
     * from one assigned counter.
     */
    public function index(Request $request)
    {
        $query = Food::with([
            'category',
            'counters',
        ])
            ->whereHas('counters', function ($query) {
                $query->where('food_counter.quantity', '>', 0);
            });

        if ($request->filled('outlet_id')) {
            $query->where(
                'outlet_id',
                $request->integer('outlet_id')
            );
        }

        $foods = $query
            ->orderBy('food_name')
            ->get();

        $categories = $foods->groupBy(
            function ($food) {
                return $food->category->category_name ?? 'Other';
            }
        );

        return view(
            'customer.display',
            compact('categories')
        );
    }

    /**
     * Return available foods as JSON.
     */
    public function data(Request $request)
    {
        $query = Food::with([
            'category',
            'counters',
        ])
            ->whereHas('counters', function ($query) {
                $query->where('food_counter.quantity', '>', 0);
            });

        if ($request->filled('outlet_id')) {
            $query->where(
                'outlet_id',
                $request->integer('outlet_id')
            );
        }

        $foods = $query
            ->orderBy('food_name')
            ->get();

        return response()->json([
            'foods' => $foods
                ->map(function ($food) {
                    return [
                        'id' => $food->id,
                        'name' => $food->food_name,
                        'price' => (float) $food->price,
                        'image' => $food->image
                            ? asset('storage/' . $food->image)
                            : null,
                        'category' =>
                            $food->category->category_name
                            ?? 'Other',
                    ];
                })
                ->values(),
        ]);
    }
}