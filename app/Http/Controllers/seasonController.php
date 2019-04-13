<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Season;
use Storage;
class seasonController extends Controller
{
    //

    public function create(Request $request){
        $request->validate([
            'serie_id'=>'required|string',
            'number_season'=>'required',
        ]);
        Season::create([
            'serie_id'=>$request->serie_id,
            'number_season'=>$request->number_season,
            'poster'=> $request->file('poster')?$request->file('poster')->store('posters','public'):null,
            'banner'=> $request->file('banner')?$request->file('banner')->store('banners','public'):null,
        ]);

        return response()->json(['message' => 'Season creada'], 201);
    }
}
