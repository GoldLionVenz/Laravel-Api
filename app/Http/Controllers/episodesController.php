<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Episode;
use Storage;
class episodesController extends Controller
{
    //
    public function show(Episode $episode){
        return $episode->load('season')->load('season.serie');
    }

    public function add(Request $request){
        /*$request->validate([
            'title'       => 'required|string',
            'plot'    => 'required|string',
        ]);*/
        /*data:application/octet-stream;base64,*/
        $videoFile=str_replace('data:video/mp4;base64,','',$request->input('video'));
        $videoFile=str_replace(' ', '+', $videoFile);
        $videoPath = 'videos/'.str_random(40).'.'.'mp4';
        Storage::disk('public')->put($videoPath, base64_decode($videoFile));
        $subtitleFile=str_replace('data:application/octet-stream;base64,','',$request->input('subtitle'));
        $subtitleFile=str_replace(' ', '+', $subtitleFile);
        $subtitlePath='subtitles/'.str_random(40).'.'.'vtt';
        Storage::disk('public')->put($subtitlePath, base64_decode($subtitleFile));
        Episode::create([
            'id'=>str_random(20),
            'title'=>'$request->title', 
            'plot'=>'$request->plot',
            'number_episode'=>1,
            'imdbRating'=>9.5,
            'season_id'=>1,
            'video'=>Storage::url($videoPath),
            'subtitle'=>Storage::url($subtitlePath),
        ]);
        return response()->json(['message' => 'Episodio Agregado'], 201);
    }
}
