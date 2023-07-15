<?php

namespace App\Http\Controllers;

use App\Models\CategoryChef;
use Illuminate\Http\Request;

class CategoryChefController extends Controller
{
    public function get_all()
    {
        $categoryChef = CategoryChef::all();

        $order = 0;

        foreach ($categoryChef as $category) {
            $category['order'] = $order;

            $order = $order + 1;
        }

        return response()->json([
            "message" => "Category Chef was found successfully",
            "data" => $categoryChef
        ]);
    }
}
