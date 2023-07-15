<?php

namespace App\Http\Controllers;

use App\Models\Plate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlateController extends Controller
{
    public function create(Request $req)
    {

        $error = Validator::make($req->all(), [
            'plate_title' => 'required',
            'plate_image' => 'required',
            'restaurant_id' => 'required',
            'plate_description' => 'required',
            'plate_type_food' => 'required',
            'plate_portion' => 'required',
            'plate_counter_like' => 'required',
            'plate_status' => 'required',
        ])->errors();

        $plate = new Plate();
        $plate->plate_title = $req->plate_title;
        $plate->restaurant_id = $req->restaurant_id;
        $plate->plate_description = $req->plate_description;
        $plate->plate_type_food = $req->plate_type_food;
        $plate->plate_portion = $req->plate_portion;
        $plate->plate_counter_like = $req->plate_counter_like;
        $plate->plate_status = $req->plate_status;

        $file = $req->file('plate_image');
        $name = 'plate_' . $file->hashName();
        $file->storeAs('public/plates', $name);
        $plate->plate_image = $name;

        if ($error->all() != []) {
            return response()->json([
                "errors" => $error->all()
            ]);
        }

        //Save object in database
        $plate->save();

        return response()->json([
            "message" => "Plato was created successfully",
            "data" => $plate
        ]);
    }

    public function get_all()
    {
        $platos = Plate::all();

        return response()->json([
            "message" => "Platos were found successfully",
            "data" => $platos
        ]);
    }

    public function get_per_id(Request $req)
    {
        $plate = Plate::find($req->id);

        if (!$plate) {
            return response()->json([
                "message" => "Plate does not found"
            ]);
        }

        return response()->json([
            "message" => "Plato was found successfully",
            "data" => $plate
        ]);
    }
}
