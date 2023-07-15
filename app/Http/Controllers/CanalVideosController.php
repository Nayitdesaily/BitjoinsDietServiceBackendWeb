<?php

namespace App\Http\Controllers;

use App\Models\CanalTag;
use App\Models\CanalVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CanalVideosController extends Controller
{
    public function get_per_id(Request $req)
    {
        $canal_tag = CanalTag::find($req->id);

        if (!$canal_tag) {
            return response()->json([
                "message" => "Canal tag does not found"
            ]);
        }

        $canal_videos = CanalVideo::where('canal_tags_id', $canal_tag->id)->get();

        foreach ($canal_videos as $canal_video) {
            $canal_video->canal_tags_id = $canal_tag;
        };

        return response()->json([
            "message" => "Canal videos was found successfully",
            "data" => $canal_videos
        ]);
    }

    public function get_all()
    {
        $canal_videos = CanalVideo::all();

        foreach ($canal_videos as $canal_video) {
            $canal_tag = CanalTag::find($canal_video->canal_tags_id);

            $canal_video['canal_tags_id'] = $canal_tag;
        }

        return response()->json([
            "message" => "Canal videos were found successfully",
            "data" => $canal_videos
        ]);
    }

    public function create(Request $req)
    {

        $canal_video = new CanalVideo();

        $canal_video->canal_tags_id = $req->canal_tags_id;
        $canal_video->titulo = $req->titulo;
        $canal_video->descripcion = $req->descripcion;
        $canal_video->fechareg = $req->fechareg;
        $canal_video->codigo_video = $req->codigo_video;

        $file = $req->file('urlvideo');

        if (!$file) {
            return response()->json([
                "message" => "File does not download"
            ]);
        }

        $name = 'canal_video_' . $file->hashName();
        $file->storeAs('public/canal_video', $name);
        $canal_video->urlvideo = $name;

        //Validation requests
        $errors = Validator::make($req->all(), [
            'canal_tags_id' => 'required',
            'descripcion' => 'required',
            'fechareg' => 'required',
            'titulo' => 'required',
            'urlvideo' => 'required',
            'codigo_video' => 'required'
        ])->errors();

        if ($errors->all() != []) {
            return response()->json([
                "error" => $errors->all()
            ]);
        }

        //Save canal_video object in database
        $canal_video->save();

        return response()->json([
            "message" => "Canal video was created successfully",
            "data" => $canal_video
        ]);
    }
}
