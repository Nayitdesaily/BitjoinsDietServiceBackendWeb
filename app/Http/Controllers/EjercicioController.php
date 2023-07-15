<?php

namespace App\Http\Controllers;

use App\Models\Ejercicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EjercicioController extends Controller
{
    public function get_all()
    {
        $ejercicios = Ejercicio::all();

        return response()->json([
            "message" => 'Ejercicios were found successfully',
            "data" => $ejercicios
        ]);
    }

    public function get_per_id(Request $request)
    {
        $ejercicio = Ejercicio::find($request->id);

        if (!$ejercicio) {
            return response()->json([
                "message" => "Ejercicio do not found, wrong ID"
            ]);
        };

        return response()->json([
            "message" => 'Ejercicios was found successfully',
            "data" => $ejercicio
        ]);
    }

    public function create(Request $request)
    {
        $ejercicio = new Ejercicio();
        $ejercicio->planalimentacion_id = $request->planalimentacion_id;
        $ejercicio->tipoejercicio = $request->tipoejercicio;
        $ejercicio->tiempo = $request->tiempo;
        $ejercicio->observaciones = $request->observaciones;

        //Upload File on field 'imagen'
        $file = $request->file('imagen');
        $name = 'ejercicio_' . $file->hashName();
        $file->storeAs('public/ejercicios', $name);
        $ejercicio->imagen = $name;

        //Validation requests
        $errors = Validator::make($request->all(), [
            'planalimentacion_id' => 'required',
            'tipoejercicio' => 'required',
            'tiempo' => 'required',
            'imagen' => 'required',
            'observaciones' => 'required'
        ])->errors();

        if ($errors->all() != []) {
            return response()->json([
                "error" => $errors->all()
            ]);
        }

        $ejercicio->save();

        return response()->json([
            "message" => 'Ejercicio was created successfully',
            "data" => $ejercicio
        ]);

        // Save the ejercicio object in database

    }

    public function update(Request $request)
    {
        $ejercicio = Ejercicio::find($request->id);

        if (!$ejercicio) {
            return response()->json([
                "message" => "Ejercico does not found"
            ]);
        };

        $ejercicio->planalimentacion_id = $request->planalimentacion_id;
        $ejercicio->tipoejercicio = $request->tipoejercicio;
        $ejercicio->tiempo = $request->tiempo;
        $ejercicio->observaciones = $request->observaciones;

        //Upload File on field 'imagen'

        $MIN_NUMBER_RANDOM = 100000;
        $MAX_NUMBER_RANDOM = 1000000;

        $rand_number = rand($MIN_NUMBER_RANDOM, $MAX_NUMBER_RANDOM);
        $extension = pathinfo($request->file('imagen')->getClientOriginalName(), PATHINFO_EXTENSION);
        $image_name = 'ejercicio_' . $rand_number . "." . $extension;
        $path = $request->file('imagen')->storeAs('public/img', $image_name);
        $ejercicio->imagen = explode("/", $path)[2];

        //Validation requests

        $errors = Validator::make($request->all(), [
            'plan_alimentacion_id' => 'required',
            'tipoejercicio' => 'required',
            'tiempo' => 'required',
            'imagen' => 'required',
            'observaciones' => 'required'
        ])->errors();

        if ($errors->all() != []) {
            return response()->json([
                "error" => $errors->all()
            ]);
        }

        $ejercicio->save();

        return response()->json([
            "message" => 'Ejercicio was updated successfully',
            "data" => $request->file('imagen')
        ]);
    }
}
