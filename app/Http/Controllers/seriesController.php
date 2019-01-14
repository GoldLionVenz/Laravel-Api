<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Serie;
use Storage;
class seriesController extends Controller
{
    public function all(){
        $series=Serie::all();
       
        
        return $series;
        //return response()->json(['data' => $series], 201);
        
    }

    public function allWithSeasons(){
        $series=Serie::all()->load('seasons');
       
        
        return $series;
    }
    public function title(Serie $serie){
        $serie->load('seasons');

        $poster='';
        $banner='';
        if(sizeof($serie->seasons)>0){
            foreach ($serie->seasons as $season) {
                if($season->poster!=null&&$season->banner!=null){
                    $poster=$season->poster;
                    $banner=$season->banner;
                }
            }
        }else{
            $poster=$serie->poster;
        }
        $serie->lastPoster=$poster;
        $serie->lastBanner=$banner;
        return $serie;
    }
    public function add(Request $request){
        $request->validate([
            'title'       => 'required|string',
            'plot'    => 'required|string',
        ]);
        
        $file = str_replace('data:image/jpeg;base64,','',$request->input('file')) ;
        $file = str_replace(' ', '+', $file);
        $posterPath = 'posters/'.str_random(40).'.'.'jpg';
        Storage::disk('public')->put($posterPath, base64_decode($file));
        Serie::create([
            'id'=>str_random(20),
            'title'=>$request->title, 
            'plot'=>$request->plot,
            'imdbRating'=>$request->imdbRating,
            'poster'=>Storage::url($posterPath),
        ]);
        return response()->json(['message' => 'series creada'], 201);
    }

}
