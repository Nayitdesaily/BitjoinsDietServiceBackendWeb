<?php

namespace App\Http\Controllers;

use App\Models\PlanAlimentacion;
use App\Models\PlanAlimentacion_Recetas;
use App\Models\Receta;
use Illuminate\Http\Request;

class PlanAlimentacion_RecetasController extends Controller
{
    public function create(Request $req)
    {
        $plan_alimentacion_recetas = new PlanAlimentacion_Recetas();

        $plan_alimentacion_recetas->planalimentacion_id = $req->planalimentacion_id;
        $plan_alimentacion_recetas->recetas_id = $req->recetas_id;
        $plan_alimentacion_recetas->opgrupo = $req->opgrupo;
        $plan_alimentacion_recetas->opcion = $req->opcion;
        $plan_alimentacion_recetas->label = $req->label;
        $plan_alimentacion_recetas->descripcion = $req->descripcion;
        $plan_alimentacion_recetas->oplabel = $req->oplabel;
        $plan_alimentacion_recetas->html = $req->html;
        $plan_alimentacion_recetas->receta = $req->receta;
        $plan_alimentacion_recetas->swmenu = $req->swmenu;

        $plan_alimentacion_recetas->save();

        return response()->json([
            "message" => "Plan alimentacion recetas was created successfully",
            "data" => $plan_alimentacion_recetas
        ]);
    }

    public function get_per_id(Request $req)
    {

        $plan_alimentacion_receta = PlanAlimentacion_Recetas::find($req->id);

        if (!$plan_alimentacion_receta) {
            return response()->json([
                "message" => "Planalimentacion_recetas does not found"
            ]);
        }

        $plan_alimentacion = PlanAlimentacion::find($plan_alimentacion_receta->planalimentacion_id);
        $receta = Receta::find($plan_alimentacion_receta->recetas_id);
        $plan_alimentacion_receta['planalimentacion_id'] = $plan_alimentacion;
        $plan_alimentacion_receta['recetas_id'] = $receta;

        return response()->json([
            "message" => "Planalimentacion_recetas was found successfully",
            "data" => $plan_alimentacion_receta
        ]);
    }

    public function get_all()
    {
        $plan_alimentacion_recetas = PlanAlimentacion_Recetas::all();

        return response()->json([
            "message" => "Plan alimentacion recetas were found successfully",
            "data" => $plan_alimentacion_recetas
        ]);
    }
}
