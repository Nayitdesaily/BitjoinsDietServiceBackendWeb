<?php

namespace App\Http\Controllers;

use App\Models\Recomendacion;
use Illuminate\Http\Request;

class RecomendacionesController extends Controller
{
    public function create(Request $req)
    {
        $recomendacion = Recomendacion::create([
            'planalimentacion_id' => $req->planalimentacion_id,
            'recomendacion' => $req->recomendacion,
        ]);

        return response()->json([
            "message" => "Recomendacion was created sucessfully",
            "data" => $recomendacion
        ]);
    }

    public function get_per_id(Request $req)
    {
        $recomendacion = Recomendacion::find($req->id);

        if (!$recomendacion) {
            return response()->json([
                "message" => "Recomendacion does not found"
            ]);
        }

        return response()->json([
            "message" => "Recomendacion was found sucessfully",
            "data" => $recomendacion
        ]);
    }

    public function get_all()
    {
        $recomendaciones = Recomendacion::all();

        return response()->json([
            "message" => "Recomendaciones were found sucessfully",
            "data" => $recomendaciones
        ]);
    }
}
