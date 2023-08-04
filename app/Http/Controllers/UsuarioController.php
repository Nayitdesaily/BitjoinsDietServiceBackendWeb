<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
   public function register(Request $req)
   {

      $usuario = new Usuario();

      $usuario->tipousuario_id = 4;
      $usuario->email = $req->email;
      $usuario->pass = sha1(getenv('HASH_PASSWORD') . $req->pass);
      $usuario->persona_id = $req->persona_id;

      $usuario->save();

      // $token = $usuario->createToken('pass')->plainTextToken;

      return response()->json([
         "message" => "Usuario was created successfully",
         "data" => [
            "usuario" => $usuario
         ]
      ]);
   }

   public function login(Request $req)
   {

      $user = Usuario::where('email', $req->email)->first();

      // return $user;

      if (!$user) {
         return response()->json([
            "message" => "no existe el usuario"
         ]);
      }

      if ($user->pass !== sha1(getenv('HASH_PASSWORD') . $req->pass)) {
         return response()->json([
            "message" => "Usuario o contraseña incorrectas"
         ]);
      }

      $persona = Persona::find($user->persona_id);
      $user['persona_id'] = $persona;

      return response()->json([
         "message" => "Usuario ingreso correctamente",
         "data" => $user
      ]);
   }

   public function reset(Request $req)
   {

      $user = Usuario::where('email', $req->email)->where('tipousuario_id', 4)->first();

      if (!$user) {
         return response()->json([
            "message" => "no existe el usuario"
         ]);
      }

      $user->pass = sha1(getenv('HASH_PASSWORD') . $req->pass);
      $user->save();

      return response()->json([
         "message" => "Usuario actualizado correctamente",
         "data" => $user
      ]);
   }

   public function get_per_id(Request $req)
   {
      $usuario = Usuario::find($req->id);

      if (!$usuario) {
         return response()->json([
            "message" => "Usuario does not found"
         ]);
      }

      return response()->json([
         "message" => "Usuario was found successfully",
         "data" => $usuario
      ]);
   }

   public function get_all()
   {
      $usuarios = Usuario::all();
      return $usuarios;
   }

   public function get_tipo_usuario()
   {
      $tipos = DB::table('tipousuario')->get();
      return $tipos;
   }
}
