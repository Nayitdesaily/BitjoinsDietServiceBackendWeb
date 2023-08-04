<?php

namespace App\Http\Controllers;

use App\Models\PlanAlimentacion;
use App\Models\PlanAlimentacion_Intercambio;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PlanAlimentacion_IntercambioController extends Controller
{
    public function create(Request $req)
    {
        $plan_alimentacion_intercambio = new PlanAlimentacion_Intercambio();

        $plan_alimentacion_intercambio->planalimentacion_id = $req->planalimentacion_id;
        $plan_alimentacion_intercambio->listaalimentos_id = $req->listaalimentos_id;
        $plan_alimentacion_intercambio->p_de = $req->p_de;
        $plan_alimentacion_intercambio->p_m1 = $req->p_m1;
        $plan_alimentacion_intercambio->p_al = $req->p_al;
        $plan_alimentacion_intercambio->p_m2 = $req->p_m2;
        $plan_alimentacion_intercambio->p_ce = $req->p_ce;

        //Validation requests
        $errors = Validator::make($req->all(), [
            'planalimentacion_id' => 'required',
            'listaalimentos_id' => 'required',
            'p_de' => 'required',
            'p_m1' => 'required',
            'p_al' => 'required',
            'p_m2' => 'required',
            'p_ce' => 'required',
        ])->errors();

        if ($errors->all() != []) {
            return response()->json([
                "error" => $errors->all()
            ]);
        }

        $plan_alimentacion_intercambio->save();

        return response()->json([
            "message" => 'Plan alimentacion intercambio was created successfully',
            "data" => $plan_alimentacion_intercambio
        ]);
    }

    public function get_per_id(Request $req)
    {
        $plan_alimentacion_intercambio = PlanAlimentacion_Intercambio::find($req->id);

        if (!$plan_alimentacion_intercambio) {
            return response()->json([
                "message" => "Plan de alimentacion intercambio does not found"
            ]);
        }

        //Add user object inside plan alimentacion object
        $plan_alimentacion = PlanAlimentacion::find($plan_alimentacion_intercambio->planalimentacion_id);
        $usuario = Usuario::find($plan_alimentacion->usuario_id);
        $plan_alimentacion['usuario_id'] = $usuario;

        //Add plan alimentacion object inside plan alimentacion intercambio object

        $plan_alimentacion_intercambio['planalimentacion_id'] = $plan_alimentacion;

        return response()->json([
            "message" => "Plan de alimentacion intercambio was found successfully",
            "data" => $plan_alimentacion_intercambio
        ]);
    }

    public function get_all(Request $req)
    {
        $planes_alimentacion_intercambio = PlanAlimentacion_Intercambio::all();

        return response()->json([
            "message" => "Planes de alimentacion intercambio were found successfully",
            "data" => $planes_alimentacion_intercambio
        ]);
    }

    public function get_intercambio(){
        $intercambios = DB::table('intercambio')->get();

        return $intercambios;
    }
}
