<?php

namespace App\Http\Controllers;

use App\Models\CategoryChef;
use App\Models\Chef;
use App\Models\Plate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChefController extends Controller
{

    public function get_all()
    {
        $chefs = Chef::all();
        $order = 0;
        foreach ($chefs as $chef) {
            $category_chef = CategoryChef::find($chef->chef_category);

            // $plates = Plate::where('plate_restaurant', $chef->chef_id)->get();
            $chef['chef_category'] = $category_chef->category_id;
            $chef['category_title'] = $category_chef->category_title;

            $chef['order'] = $order;
            // $chef['plates'] = $plates;
            $order = $order + 1;
        }

        return response()->json([
            "message" => "Restaurants were found successfully",
            "data" => $chefs
        ]);
    }


    public function get_per_id(Request $req)
    {

        $chef = Chef::find($req->id);
        // $category_chef = CategoryChef::where('restaurante', $chef->chef_title);

        if (!$chef) {
            return response()->json([
                "message" => "Restaurant does not found"
            ]);
        }

        $category_chef = CategoryChef::where('category_id', $chef->chef_category)->get();
        $plates = Plate::where('plate_restaurant', $chef->chef_id)->get();

        $chef['plates'] = $plates;
        $chef['chef_category'] = $category_chef;

        return response()->json([
            "message" => "Restaurant was found successfully",
            "data" => $chef
        ]);
    }

    public function create(Request $req)
    {

        $error = Validator::make($req->all(), [
            'chef_title' => 'required',
            'chef_image' => 'required',
        ])->errors();

        $restaurant = new Chef();
        $restaurant->chef_title = $req->chef_title;

        $file = $req->file('chef_image');

        if (!$file) {
            return response()->json([
                "message" => "Image does not download"
            ]);
        }
        $name = "restaurant_" . $file->hashName();
        $file->storeAs('public/restaurantes', $name);
        $restaurant->chef_image = $name;

        //Validate requests
        if ($error->all() != []) {
            return response()->json([
                "errors" => $error->all()
            ]);
        }

        //Save object in database
        $restaurant->save();

        return response()->json([
            "message" => "Restaurant was created successfully",
            "data" => $restaurant
        ]);
    }
}
