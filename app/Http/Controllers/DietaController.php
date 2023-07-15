<?php

namespace App\Http\Controllers;

use App\Models\Dieta;
use App\Models\PlanAlimentacion;
use App\Models\Recomendaciones;
use Carbon\Carbon;
use Carbon\Exceptions\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DietaController extends Controller
{
   public function get_dieta(Request $req)
   {
      $dietas = Dieta::where('planalimentacion_id', $req->id)->orderBy('id', 'ASC')->get();
      $plan_alimentacion = PlanAlimentacion::find($req->id);

      if (count($dietas) == 0) {
         return response()->json([
            "message" => "Dietas do not found, porfavor ingresa un id de plan de alimentacion valido"
         ]);
      }

      $array_merge = array();

      for ($i = 0; $i < count($dietas) - 1; $i++) {
         $get_id = $dietas[$i]->opcion;
         $arr_comidas = array();

         for ($j = 0; $j < count($dietas); $j++) {
            if ($get_id == $dietas[$j]->opcion) {
               $obj_array_comidas = array('comida' => $dietas[$j]->comida);
               $obj_array_descripcion = array('descripcion' => $dietas[$j]->descripcion);
               $obj_com_desc = array_merge((array) $obj_array_comidas, (array) $obj_array_descripcion);
               array_push($arr_comidas, $obj_com_desc);
            }
         }
         $obj_opcion = (object) array('opcion' => $get_id);
         $obj_comidas = (object) array('comidas' => $arr_comidas);
         $obj_planalimentacion_id = (object) array('planalimentacion_id' => $dietas[$i]->planalimentacion_id);
         $obj_oplabel = (object) array('oplabel' => $dietas[$i]->oplabel);
         $obj_fecha_inicio = (object) array('fecha_inicio' => empty(null));
         $obj_fecha_inicio_dia = (object) array('fecha_inicio_dia' => empty(null));

         $obj_join_comidas = (object) array_merge(
            (array) $obj_planalimentacion_id,
            (array)$obj_fecha_inicio,
            (array)$obj_fecha_inicio_dia,
            (array) $obj_oplabel,
            (array) $obj_opcion,
            (array) $obj_comidas
         );
         array_push($array_merge, $obj_join_comidas);
      }

      $obj_final  = array();

      foreach ($array_merge as $current) {
         if (!in_array($current, $obj_final)) {
            $obj_final[] = $current;
         }
      }

      $i = 0;

      foreach ($obj_final as $obj) {

         if ($plan_alimentacion->fecha_inicio == "0000-00-00" || strlen($plan_alimentacion->fecha_inicio) == 0) {
            $fecha_inicio = date('Y-m-d', strtotime($plan_alimentacion->fecultimaact));
         } else {
            $fecha_inicio = date('Y-m-d', strtotime($plan_alimentacion->fecha_inicio));
         }


         $obj->fecha_inicio = date('Y-m-d', strtotime($fecha_inicio . "+{$i} day"));
         $obj->fecha_inicio_dia = Carbon::createFromFormat('Y-m-d', $obj->fecha_inicio)->format('l');

         $i++;
      }

      return response()->json([
         "message" => "Dietas were found succesfully",
         "data" => $obj_final
      ]);
   }

   public function get_recomendaciones(Request $req)
   {
      $recomedaciones = Recomendaciones::where('planalimentacion_id', $req->id)->orderBy('tipo', 'ASC')->get();

      if (count($recomedaciones) == 0) {
         return response()->json([
            "message" => "Recomendaciones do not found"
         ]);
      }

      return response()->json([
         "message" => "Recomendaciones were found succesfully",
         "data" =>  $recomedaciones
      ]);
   }

   public function create(Request $req)
   {
      $dieta = Dieta::create([
         "planalimentacion_id" => $req->planalimentacion_id,
         "opcion" => $req->opcion,
         "comida" => $req->comida,
         "label" => $req->label,
         "descripcion" => $req->descripcion,
         "oplabel" => $req->oplabel,
         "fecha_inicio" => $req->fecha_inicio,
      ]);

      return response()->json([
         "message" => "Dieta was created sucessfully",
         "data" => $dieta
      ]);
   }

   public function get_last_dieta(Request $req)
   {
      $dietas = Dieta::where('planalimentacion_id', $req->id)->orderBy('id', 'ASC')->get();
      $plan_alimentacion = PlanAlimentacion::find($req->id);

      if (count($dietas) == 0) {
         return response()->json([
            "message" => "Dietas do not found, porfavor ingresa un id de plan de alimentacion valido"
         ]);
      }

      $array_merge = array();

      for ($i = 0; $i < count($dietas) - 1; $i++) {
         $get_id = $dietas[$i]->opcion;
         $arr_comidas = array();

         for ($j = 0; $j < count($dietas); $j++) {
            if ($get_id == $dietas[$j]->opcion) {
               $obj_array_comidas = array('comida' => $dietas[$j]->comida);
               $obj_array_descripcion = array('descripcion' => $dietas[$j]->descripcion);
               $obj_com_desc = array_merge((array) $obj_array_comidas, (array) $obj_array_descripcion);

               array_push($arr_comidas, $obj_com_desc);
            }
         }
         $obj_opcion = (object) array('opcion' => $get_id);
         $obj_comidas = (object) array('comidas' => $arr_comidas);
         $obj_planalimentacion_id = (object) array('planalimentacion_id' => $dietas[$i]->planalimentacion_id);
         $obj_oplabel = (object) array('oplabel' => $dietas[$i]->oplabel);
         $obj_fecha_inicio = (object) array('fecha_inicio' => empty(null));
         $obj_fecha_inicio_dia = (object) array('fecha_inicio_dia' => empty(null));

         $obj_join_comidas = (object) array_merge(
            (array) $obj_planalimentacion_id,
            (array)$obj_fecha_inicio,
            (array)$obj_fecha_inicio_dia,
            (array) $obj_oplabel,
            (array) $obj_opcion,
            (array) $obj_comidas,
         );
         array_push($array_merge, $obj_join_comidas);
      }

      $obj_final  = array();

      foreach ($array_merge as $current) {
         if (!in_array($current, $obj_final)) {
            $obj_final[] = $current;
         }
      }

      $i = 0;
      $today = Carbon::now()->format('Y-m-d');
      $obj_dieta_today = array();

      foreach ($obj_final as $obj) {

         $fecha_inicio = date('Y-m-d', strtotime($plan_alimentacion->fecultimaact));
         $obj->fecha_inicio = date('Y-m-d', strtotime($fecha_inicio . "+{$i} day"));
         $obj->fecha_inicio_dia = Carbon::createFromFormat('Y-m-d', $obj->fecha_inicio)->format('l');

         if ($obj->fecha_inicio == $today) {
            $obj_dieta_today = $obj;
         }

         $i++;
      }

      return response()->json([
         "message" => "The current dieta was found succesfully",
         "data" => $obj_dieta_today
      ]);
   }

   public function get_dieta_web(Request $req)
   {
      try {
         $dietas = DB::table('dieta')->where('planalimentacion_id', $req->id)
            ->select(
               'id',
               'planalimentacion_id',
               'opcion',
               'comida',
               'descripcion'
            )
            ->orderBy('opcion', 'asc')
            ->orderBy('comida', 'asc')
            ->get();

         $dietas = collect($dietas)->groupBy('opcion');
         return $dietas;
      } catch (\Exception $e) {
         return $e;
      }
   }
}
