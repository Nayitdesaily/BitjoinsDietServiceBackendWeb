<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Usuario;
use Exception;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{

    public function get_all()
    {
        $personas = Persona::all();

        return response()->json([
            'message' => 'Personas was found successfully',
            'data' => $personas
        ]);
    }

    public function get_all_web()
    {
        $personas = DB::table('persona')
            ->join('usuario', 'persona.id', '=', 'usuario.persona_id')
            ->select('persona.*', 'usuario.email')->get();


        return response()->json([
            'message' => 'Personas was found successfully',
            'data' => $personas
        ]);
    }

    public function get_per_id(Request $request)
    {
        $persona = Persona::withTrashed()->where('id', $request->id)->get();

        if (!$persona) {
            return response()->json([
                'message' => 'Persona not found'
            ]);
        };

        return response()->json([
            'message' => 'Persona was found successfully',
            'data' => $persona
        ]);
    }

    public function get_per_id_web(Request $request)
    {

        try {
            $persona = DB::table('persona')->join('usuario', 'persona.id', '=', 'usuario.persona_id')
                ->join('tipousuario', 'usuario.tipousuario_id', '=', 'tipousuario.id')
                ->where('persona.id', '=', $request->id)
                ->select('persona.*', 'usuario.email', 'tipousuario.nombre as tipo_usuario', 'tipousuario.id as tipousuario_id')->first();

            if ($persona == null) {
                return response()->json([
                    'message' => 'Persona not found'
                ], 404);
            };

            return response()->json([
                'message' => 'Persona was found successfully',
                'data' => $persona
            ], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function create(Request $request)
    {
        $persona = new Persona();
        $persona->nombre = $request->name;
        $persona->apellido = $request->apellido;
        $persona->telefono = $request->telefono;
        $persona->empresa_id = $request->empresa_id;
        $persona->ocupacion = $request->ocupacion;
        $persona->talla = $request->talla;
        $persona->peso_ideal = $request->peso_ideal;
        $persona->distrito = $request->distrito;
        $persona->p_grasa_ideal = $request->p_grasa_ideal;
        $persona->p_masa_muscular = $request->p_masa_muscular;
        $persona->consultorio_id = $request->consultorio_id;
        $persona->gustos = $request->gustos;
        $persona->no_gustos = $request->no_gustos;

        $persona->save();

        return response()->json([
            'message' => 'Persona was created successfully',
            'data' => $persona
        ]);
    }

    public function update(Request $request, $id)
    {
        $persona = Persona::findOrFail($request->id);

        $persona->name = $request->name;
        $persona->apellido = $request->apellido;
        $persona->telefono = $request->telefono;
        $persona->empresa_id = $request->empresa_id;
        $persona->ocupacion = $request->ocupacion;
        $persona->talla = $request->talla;
        $persona->peso_ideal = $request->peso_ideal;
        $persona->p_masa_muscular = $request->p_masa_muscular;
        $persona->consultorio_id = $request->consultorio_id;
        $persona->gustos = $request->gustos;
        $persona->no_gustos = $request->no_gustos;

        $persona->save();

        return response()->json([
            'message' => 'Persona was updated successfully',
            'data' => $persona
        ]);
    }

    public function update_web(Request $req)
    {

        $persona = DB::table('persona')->where('id', $req->id)->first();

        if ($persona == null) {

            return response()->json([
                "message" => "La persona no existe"
            ], 404);
        } else {
            DB::table('persona')->where('id', $req->id)
                ->update([
                    'nombre' => $req->nombre,
                    'apellido' => $req->apellido,
                    'telefono' => $req->telefono,
                    'ocupacion' => $req->ocupacion,
                    'empresa_id' => $req->empresa_id,
                    'talla' => $req->talla,
                    'peso_ideal' => $req->peso_ideal,
                    'p_masa_muscular' => $req->p_masa_muscular,
                    'consultorio_id' => $req->consultorio_id,
                    'gustos' => $req->gustos,
                    'no_gustos' => $req->no_gustos,
                ]);

            DB::table('usuario')->where('persona_id', $req->id)
                ->update([
                    'email' => $req->email,
                ]);

            return response()->json([
                'message' => 'los datos fueron actualizados',
            ], 200);
        }
    }

    public function delete(Request $request, Response $response)
    {
        $user = Persona::all()->find($request->id);

        if (!$user) {
            return response()->json([
                'message' => 'Wrong ID'
            ]);
        };

        $user->delete();

        return response()->json([
            'message' => 'User was deleted successfully'
        ]);
    }

    public function restore(Request $request, Response $response)
    {

        $user = Persona::onlyTrashed()->find($request->id);

        if (!$user) {
            return response()->json([
                'message' => 'Wrong ID'
            ]);
        };

        $user->restore();

        return response()->json([
            'message' => 'User was restored successfully',
            'data' => $user
        ]);
    }
}
