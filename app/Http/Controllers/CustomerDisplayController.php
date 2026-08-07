<?php

namespace App\Http\Controllers;

use App\Models\Food;

class CustomerDisplayController extends Controller
{

    public function index()
    {

        $foods = Food::with('category')
            ->where('available_quantity','>',0)
            ->get();


        $categories = $foods->groupBy(function($food){

            return $food->category->category_name ?? 'Other';

        });


        return view('customer.display',compact(
            'categories'
        ));

    }

}