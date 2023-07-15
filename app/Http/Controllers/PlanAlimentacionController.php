<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\PlanAlimentacion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PlanAlimentacionController extends Controller
{

    public function create(Request $request)
    {
        $plan_alimentacion = new PlanAlimentacion();

        $plan_alimentacion->nombre = $request->nombre;
        $plan_alimentacion->fecultimaact = $request->fecultimaact;
        $plan_alimentacion->tips = $request->tips;
        $plan_alimentacion->notas = $request->notas;
        $plan_alimentacion->usuario_id = $request->usuario_id;
        $plan_alimentacion->nutricionista_id = $request->nutricionista_id;
        $plan_alimentacion->kcal_total = $request->kcal_total;
        $plan_alimentacion->peso = $request->peso;
        $plan_alimentacion->p_cho = $request->p_cho;
        $plan_alimentacion->p_prot = $request->p_prot;
        $plan_alimentacion->p_grasas = $request->p_grasas;
        $plan_alimentacion->tipo = $request->tipo;
        $plan_alimentacion->estado = $request->estado;

        $plan_alimentacion->save();

        return response()->json([
            "message" => "Food Plan was created successfully",
            "data" => $plan_alimentacion
        ]);
    }

    public function get_per_id(Request $req)
    {
        $planes_alimentacion = PlanAlimentacion::where('usuario_id', $req->id)->orderBy('id', 'ASC')->get();

        if (count($planes_alimentacion) == 0) {
            return response()->json([
                "message" => "User's planes de alimentacion do not found"
            ]);
        }
        foreach ($planes_alimentacion as $plan) {
            $user = Usuario::find($plan->usuario_id);
            $persona = Persona::find($user->persona_id);
            $user['persona_id'] = $persona;
            $plan['usuario_id'] = $user;
        }

        return response()->json([
            "message" => "Plan de alimentacion was found successfully",
            "data" => $planes_alimentacion
        ]);
    }

    public function get_actual(Request $req)
    {
        $planes_alimentacion = PlanAlimentacion::where('usuario_id', $req->id)->get();

        if (count($planes_alimentacion) == 0) {
            return response()->json([
                "message" => "User's planes de alimentacion do not found"
            ]);
        }

        $plan_fecha_values = array();
        foreach ($planes_alimentacion as $plan) {
            array_push($plan_fecha_values, $plan->fecultimaact);
        }

        $fec_actual = array_reduce($plan_fecha_values, function ($acc, $item) {
            if ($acc > $item) {
                return $acc;
            } else {
                return $item;
            }
        });

        $plan_alimentacion_actual = PlanAlimentacion::where('fecultimaact', $fec_actual)
            ->where('usuario_id', $req->id)->orderBy('id', 'desc')->first();

        return response()->json([
            "message" => "The latest Plan de Alimentacion was found",
            "data" => $plan_alimentacion_actual
        ]);
    }

    public function get_all()
    {

        $planes = DB::table('planalimentacion')
            ->join('usuario', 'planalimentacion.usuario_id', '=', 'usuario.id')
            ->join('persona', 'usuario.persona_id', '=', 'persona.id')
            ->join('nutricionista', 'planalimentacion.nutricionista_id', '=', 'nutricionista.id')
            ->select(
                'planalimentacion.nombre as plan',
                'planalimentacion.estado',
                'planalimentacion.fecultimaact',
                'usuario.email',
                'persona.nombre',
                'persona.apellido',
                'persona.telefono as contacto',
                'nutricionista.nombres'
            )->get();

        return $planes;
    }

    public function get_per_id_web(Request $req)
    {

        $planes = DB::table('planalimentacion')
            ->join('usuario', 'planalimentacion.usuario_id', '=', 'usuario.id')
            ->join('persona', 'usuario.persona_id', '=', 'persona.id')
            ->join('nutricionista', 'planalimentacion.nutricionista_id', '=', 'nutricionista.id')
            ->join('consultorio', 'persona.consultorio_id', '=', 'consultorio.id')
            ->join('empresa', 'persona.empresa_id', '=', 'empresa.id')
            ->select(
                'planalimentacion.nombre as plan',
                'planalimentacion.estado',
                'planalimentacion.fecultimaact',
                'planalimentacion.usuario_id',
                'planalimentacion.tips',
                'planalimentacion.notas',
                'usuario.email',
                'persona.nombre',
                'persona.apellido',
                'persona.telefono',
                'persona.ocupacion',
                'persona.talla',
                'persona.peso_ideal',
                'persona.p_grasa_ideal',
                'persona.p_masa_muscular',
                'nutricionista.nombres as nutricionista',
                'consultorio.nombre as consultorio',
                'empresa.nombre as empresa',

            )
            ->where('planalimentacion.id', $req->id)->get();

        return $planes;
    }
}
