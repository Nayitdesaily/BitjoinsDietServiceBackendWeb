<?php

namespace App\Http\Controllers;

use App\Models\Evolucion;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use stdClass;

class EvolucionController extends Controller
{
    public function get_all()
    {
        $evoluciones = Evolucion::all();

        foreach ($evoluciones as $evolucion) {
            $user = Usuario::find($evolucion->usuario_id);

            if (!$user) {
                $evolucion['usuario_id'] = $evolucion->usuario_id;
            } else {
                $evolucion['usuario_id'] = $user;
            }
        }

        return response()->json([
            "message" => "Evoluciones were found successfully",
            "data" => $evoluciones
        ]);
    }

    public function get_per_id(Request $req)
    {
        $evoluciones = Evolucion::where('usuario_id', $req->id)->orderBy('id', 'DESC')->get();
        $user = Usuario::find($req->id);

        $newEvolucion = (object) [
            'fecha' => '',
            'peso' => '',
            'imc' => '',
            'p_grasa' => '',
            'p_masa' => '',
            'cintura' => '',
            'otramedida' => '',
            'label_otra' => '',
            'observacion' => '',
            'actividades' => '',
            'usuario_id' => $user,
        ];


        if (!$evoluciones) {
            return response()->json([
                "message" => "User's evolucion does not found"
            ]);
        }

        if (count($evoluciones) == 1) {
            foreach ($evoluciones as $evolucion) {
                $evolucion['usuario_id'] = $user;
            }
            $evoluciones[] = $newEvolucion;
        } else if (count($evoluciones) == 2) {
            foreach ($evoluciones as $evolucion) {
                $evolucion['usuario_id'] = $user;
            }
            $evoluciones[] = $newEvolucion;
            $evoluciones[] = $newEvolucion;
        } else if (count($evoluciones) > 2) {
            foreach ($evoluciones as $evolucion) {
                $evolucion['usuario_id'] = $user;
            }
        }

        return response()->json([
            "message" => "Evolucion was found successfully",
            "data" => $evoluciones
        ]);
    }

    public function create(Request $req)
    {
        $evolucion = new Evolucion();
        $evolucion->fecha = $req->fecha;
        $evolucion->peso = $req->peso;
        $evolucion->imc = $req->imc;
        $evolucion->p_grasa = $req->p_grasa;
        $evolucion->p_masa = $req->p_masa;
        $evolucion->cintura = $req->cintura;
        $evolucion->otramedida = $req->otramedida;
        $evolucion->label_otra = $req->label_otra;
        $evolucion->observacion = $req->observacion;
        $evolucion->actividades = $req->actividades;
        $evolucion->usuario_id = $req->usuario_id;

        //Save Evolucion object in database
        $evolucion->save();

        return response()->json([
            "message" => "Evolucion was created successfully",
            "data" => $evolucion
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }
}
