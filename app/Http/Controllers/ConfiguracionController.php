<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfiguracionController extends Controller
{
    public function cupones()
    {
        $cupones = DB::table('cupones')->get();
        return $cupones;
    }

    public function crear_cupon(Request $req)
    {
        $cupon = DB::table('cupones')->updateorInsert(
            [
                'nombre' => $req->nombre
            ],
            [
                'tipo' => $req->tipo,
                'descripcion' => $req->descripcion,
                'restricciones' => $req->restricciones,
                'fec_registro' => $req->fec_registro,
                'fec_vencimiento' => $req->fec_vencimiento,
                'media_id' => $req->media_id,
            ]
        );

        return $cupon;
    }

    public function borrar_cupon(Request $req)
    {
        try {
            $cupon = DB::table('cupones')->where('id', $req->id)->delete();
            return 'El cupon fue eliminado';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function recetario()
    {
        $recetarios = DB::table('recetario')->select(
            'id',
            'tipo',
            'nombre',
            'descripcion'
        )->get();

        foreach ($recetarios as $recetario) {
            $descripcion = html_entity_decode(strip_tags($recetario->descripcion));
            $recetario->descripcion = str_replace("\n\n", ";", $descripcion);
        }

        return $recetarios;
    }

    public function crear_recetario(Request $req)
    {
        $recetario = DB::table('recetario')->updateorInsert(
            [
                'nombre' => $req->nombre
            ],
            [
                'tipo' => $req->tipo,
                'descripcion' => $req->descripcion,
            ]
        );

        return $recetario;
    }

    public function borrar_recetario(Request $req)
    {
        try {
            DB::table('recetario')->where('id', $req->id)->delete();
            return 'El recetario fue eliminado';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function patologia()
    {
        $patologias = DB::table('patologia')->get();

        foreach ($patologias as $patologia) {
            $descripcion = html_entity_decode(strip_tags($patologia->descripcion));
            $patologia->descripcion = str_replace("\n\n", ";", $descripcion);
        }

        return $patologias;
    }

    public function crear_patologia(Request $req)
    {
        $patologia = DB::table('patologia')->updateorInsert(
            [
                'nombre' => $req->nombre
            ],
            [
                'descripcion' => $req->descripcion
            ]
        );

        return $patologia;
    }

    public function borrar_patologia(Request $req)
    {
        try {
            DB::table('patologia')->where('id', $req->id)->delete();
            return 'El patologia fue eliminado';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function empresas()
    {
        $empresas = DB::table('empresa')->get();

        return $empresas;
    }

    public function crear_empresa(Request $req)
    {
        $empresa = DB::table('empresa')->updateorInsert(
            [
                'nombre' => $req->nombre
            ],
            [
                'estado' => 1,
            ]
        );

        return $empresa;
    }

    public function borrar_empresa(Request $req)
    {
        try {
            DB::table('empresa')->where('id', $req->id)->delete();
            return 'El empresa fue eliminado';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function consultorios()
    {

        $consultorios = DB::table('consultorio')->get();
        return $consultorios;
    }

    public function crear_consultorio(Request $req)
    {

        $consultorio = DB::table('consultorio')->updateorInsert(
            [
                'nombre' => $req->nombre
            ],
            [
                'direccion' => $req->direccion,
                'fono' => $req->fono,
                'estado' => 1,
            ]
        );

        return $consultorio;
    }

    public function borrar_consultorio(Request $req)
    {
        try {
            DB::table('consultorio')->where('id', $req->id)->delete();
            return 'El consultorio fue eliminado';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function usuarios_admin()
    {
        $usuarios = DB::table('usuario')->whereIn('tipousuario_id', [2, 3])->get();

        return $usuarios;
    }

    public function crear_usuario_admin(Request $req)
    {
        $usuarios = DB::table('usuario')->updateorInsert(
            [
                'email' => $req->email
            ],
            [
                'pass' => sha1(getenv('HASH_PASSWORD') . $req->pass),
                'persona_id' => $req->persona_id,
                'tipousuario_id' => $req->tipousuario_id,
                'estado' => 1
            ]
        );

        return $usuarios;
    }

    public function borrar_usuario_admin(Request $req)
    {
        try {
            DB::table('usuario')->where('id', $req->id)->delete();
            return 'El usuario fue eliminado';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
