<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function get_per_id(Request $req)
    {
        $categoria = Categoria::find($req->id);

        if (!$categoria) {
            return response()->json([
                "message" => "Categoria does not found"
            ]);
        }

        return response()->json([
            "message" => "Categoria was found sucessfully",
            "data" => $categoria
        ]);
    }

    public function get_all()
    {
        $categorias = Categoria::all();

        return response()->json([
            "message" => "Categoria was found sucessfully",
            "data" => $categorias
        ]);
    }
}
