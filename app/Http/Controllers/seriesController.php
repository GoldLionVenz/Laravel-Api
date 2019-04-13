<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Serie;
use Storage;
class seriesController extends Controller
{
    public function all(){
        $series=Serie::with('subcriptores')->latest()->simplePaginate(12);
       
        
        return $series;
        //return response()->json(['data' => $series], 201);
        
    }

    public function allWithSeasons(){
        $series=Serie::all()->load('seasons');
       
        
        return $series;
    }
    public function title(Serie $serie){
        $serie->load(['subcriptores','seasons'])->load('seasons.episodes');
        return [
            'data'=>$serie,
            'lastSeason'=>$serie->lastSeason()
        ];
    }
    public function add(Request $request){
        $request->validate([
            'title'       => 'required|string',
            'plot'    => 'required|string',
        ]);
        
        $poster= $request->file('poster');
        Serie::create([
            'id'=>str_random(20),
            'title'=>$request->title, 
            'plot'=>$request->plot,
            'imdbRating'=>$request->imdbRating,
            'poster'=>$poster->store('posters','public'),
        ]);
        return response()->json(['message' => 'series creada'], 201);
    }

    public function suscribe(Request $request){
        $serie = Serie::find($request->serie_id);
        if($serie){
            $serie->subcriptores()->attach($request->user());
            return response()->json(['message' => 'Suscripcion Agregada'], 201);
        }else{
            return response()->json(['message' => 'series not found'], 404);
        }
    }

    
    public function unsubscribe(Request $request){
        $serie = Serie::find($request->serie_id);
        if($serie){
            $serie->subcriptores()->detach($request->user());
            return response()->json(['message' => 'Suscripcion Cancelada'], 201);
        }else{
            return response()->json(['message' => 'series not found'], 404);
        }
    }

}
