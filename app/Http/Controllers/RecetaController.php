<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecetaController extends Controller
{
    public function create(Request $req)
    {
        $recipe = new Receta();

        $recipe->recipe_title = $req->recipe_title;
        $recipe->recipe_description = $req->recipe_description;
        $recipe->recipe_ingredients = $req->recipe_ingredients;
        $recipe->recipe_directions = $req->recipe_directions;
        $recipe->recipe_cals = $req->recipe_cals;
        $recipe->recipe_time = $req->recipe_time;
        $recipe->recipe_servings = $req->recipe_servings;
        $recipe->recipe_notes = $req->recipe_notes;

        //Upload video file
        $recipe_video = $req->file('recipe_video');
        $recipe_video_name = "recipevideo_" . $recipe_video->hashName();
        $recipe_video->storeAs('public/recipevideo', $recipe_video_name);
        $recipe->recipe_video = $recipe_video_name;

        //Upload audio file
        $recipe_image = $req->file('recipe_image');
        $recipe_image_name = "recipeimage_" . $recipe_image->hashName();
        $recipe_image->storeAs('public/recipeimage', $recipe_image_name);
        $recipe->recipe_image = $recipe_image_name;

        $recipe->recipe_date = $req->recipe_date;
        $recipe->recipe_featured = $req->recipe_featured;
        $recipe->recipe_status = $req->recipe_status;
        $recipe->recipe_category = $req->recipe_category;

        //Validation of requests
        $errors = Validator::make($req->all(), [
            'recipe_title' => 'required',
            'recipe_description' => 'required',
            'recipe_ingredients' => 'required',
            'recipe_directions' => 'required',
            'recipe_cals' => 'required',
            'recipe_time' => 'required',
            'recipe_servings' => 'required',
            'recipe_notes' => 'required',
            'recipe_date' => 'required',
            'recipe_featured' => 'required',
            'recipe_status' => 'required',
            'recipe_category' => 'required',
        ])->errors();

        if ($errors->all() != []) {
            return response()->json([
                "errors" => $errors->all()
            ]);
        }

        //Save recipe in database
        $recipe->save();

        return response()->json([
            "message" => "Recipe was created successfully",
            "data" => $recipe
        ]);
    }

    public function get_all()
    {
        $recipes = Receta::all();

        foreach ($recipes as $recipe) {

            $recipe_ingredients = str_replace(
                "•",
                ",",
                mb_substr(strip_tags(html_entity_decode($recipe->recipe_ingredients)), 2)
            );
            $recipe_description = str_replace(
                "•",
                ",",
                mb_substr(strip_tags(html_entity_decode($recipe->recipe_description)), 0)
            );
            $recipe_directions = str_replace(
                array("1.", "2.", "3.", "4.", "5."),
                "",
                mb_substr(strip_tags(html_entity_decode($recipe->recipe_directions)), 3)
            );

            $recipe['recipe_ingredients'] = $recipe_ingredients;
            $recipe['recipe_description'] = $recipe_description;
            $recipe['recipe_directions'] = $recipe_directions;
        }

        return response()->json([
            "message" => "Recetas were found successfully",
            "data" => $recipes
        ]);
    }

    public function get_per_id(Request $req)
    {
        $recipe = Receta::find($req->id);

        if (!$recipe) {
            return response()->json([
                "message" => "Receta does not found",
            ]);
        }

        $recipe_ingredients = str_replace(
            "•",
            ",",
            mb_substr(strip_tags(html_entity_decode($recipe->recipe_ingredients)), 1)
        );
        $recipe_description = str_replace(
            "•",
            ",",
            mb_substr(strip_tags(html_entity_decode($recipe->recipe_description)), 1)
        );
        $recipe_directions = str_replace(
            array("1.", "2.", "3.", "4.", "5."),
            "",
            strip_tags(html_entity_decode($recipe->recipe_directions))
        );

        $category = Categoria::find($recipe->recipe_category);

        $recipe['recipe_category'] = $category;
        $recipe['recipe_ingredients'] = $recipe_ingredients;
        $recipe['recipe_description'] = $recipe_description;
        $recipe['recipe_directions'] = $recipe_directions;

        return response()->json([
            "message" => "Receta was found successfully",
            "data" => $recipe
        ]);
    }
}
