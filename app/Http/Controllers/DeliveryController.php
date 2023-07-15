<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{

    public function delivery_platos()
    {
        $platos = DB::table('delivery_platos')
            ->join('tipo_general', 'delivery_platos.tipo_comida_id', '=', 'tipo_general.id')
            ->select('delivery_platos.*', 'tipo_general.nombre as tipo_comida')->get();
        return $platos;
    }

    public function borrar_delivery_plato(Request $req)
    {
        DB::table('delivery_platos')
            ->where('id', $req->id);
        return 'El plato ha sido eliminado';
    }

    public function delivery_motorizados()
    {
        $motorizados = DB::table('delivery_motorizados')->get();
        return $motorizados;
    }

    public function borrar_delivery_motorizado(Request $req)
    {
        DB::table('delivery_motorizado')
            ->where('id', $req->id);
        return 'El motorizado ha sido eliminado';
    }


    public function delivery_unidades_medidas()
    {
        $unidad = DB::table('unidad_medida')
            ->get();
        return $unidad;
    }

    public function borrar_delivery_unidades_medida(Request $req)
    {
        DB::table('unidad_medida')
            ->where('id', $req->id);
        return 'La unidad de medida ha sido eliminado';
    }

    public function delivery_tipo_comida()
    {
        $platos = DB::table('tipo_general')->get();
        return $platos;
    }

    public function borrar_delivery_tipo_comida(Request $req)
    {
        DB::table('unidad_medida')
            ->where('id', $req->id);
        return 'La unidad de medida ha sido eliminado';
    }
}
