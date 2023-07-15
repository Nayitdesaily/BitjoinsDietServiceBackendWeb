<?php

namespace App\Http\Controllers;

use App\Models\CanalTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CanalTagController extends Controller
{
    public function create(Request $req)
    {

        $canal_tag = new CanalTag();

        $canal_tag->titulo = $req->titulo;
        $canal_tag->descripcion = $req->descripcion;
        $canal_tag->fechareg = $req->fechareg;

        $file = $req->file('foto');
        if (!$file) {
            return response()->json([
                "message" => "File does not download"
            ]);
        }

        $name = 'canal_tag_' . $file->hashName();
        $file->storeAs('public/canal_tag', $name);
        $canal_tag->foto = $name;

        //Validation requests
        $errors = Validator::make($req->all(), [
            'titulo' => 'required',
            'descripcion' => 'required',
            'fechareg' => 'required',
        ])->errors();

        if ($errors->all() != []) {
            return response()->json([
                "error" => $errors->all()
            ]);
        }

        //Save canal tag object in database

        $canal_tag->save();

        return response()->json([
            "message" => "Canal tag was created successfully",
            "data" => $canal_tag
        ]);
    }

    public function get_all()
    {
        $canal_tags = CanalTag::all();

        $i = 0;

        foreach ($canal_tags as $canal) {
            $canal['id_order'] = $i;
            $i++;
        }

        return response()->json([
            "message" => "Canal tags were found successfully",
            "data" => $canal_tags
        ]);
    }

    public function get_per_id(Request $req)
    {
        $canal_tag = CanalTag::find($req->id);

        if (!$canal_tag) {
            return response()->json([
                "message" => "Canal tag does not found"
            ]);
        }

        return response()->json([
            "message" => "Canal tag was found successfully",
            "data" => $canal_tag
        ]);
    }
}
