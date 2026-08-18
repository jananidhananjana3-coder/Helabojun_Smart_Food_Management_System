<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class CustomerDisplayController extends Controller
{
    /**
     * Display available foods for customers.
     */
    public function index(Request $request)
    {
        $query = Food::with([
                'category',
                'counters'
            ])
            ->whereHas(
                'counters',
                fn ($q) => $q->where('quantity', '>', 0)
            );

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
            fn ($food) =>
                $food->category->category_name ?? 'Other'
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
                'counters'
            ])
            ->whereHas(
                'counters',
                fn ($q) => $q->where('quantity', '>', 0)
            );

        if ($request->filled('outlet_id')) {
            $query->where(
                'outlet_id',
                $request->integer('outlet_id')
            );
        }

        $foods = $query->get();

        return response()->json([
            'foods' => $foods
                ->map(
                    fn ($f) => [
                        'id' => $f->id,

                        'name' => $f->food_name,

                        'price' => (float) $f->price,

                        'image' => $f->image
                            ? asset('storage/' . $f->image)
                            : null,

                        'category' =>
                            $f->category->category_name
                            ?? 'Other',
                    ]
                )
                ->values()
        ]);
    }
}