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
        $posterPath='';
        if($request->input('poster')){
            $filePoster = str_replace('data:image/jpeg;base64,','',$request->input('poster')) ;
            $filePoster = str_replace(' ', '+', $filePoster);
            $posterPath = 'posters/'.str_random(40).'.'.'jpg';
            Storage::disk('public')->put($posterPath, base64_decode($filePoster));
        }
        $BannerPath='';
        if($request->input('banner')){
            $fileBanner = str_replace('data:image/jpeg;base64,','',$request->input('banner')) ;
            $fileBanner = str_replace(' ', '+', $fileBanner);
            $BannerPath = 'banners/'.str_random(40).'.'.'jpg';
            Storage::disk('public')->put($BannerPath, base64_decode($fileBanner));
        }

        Season::create([
            'serie_id'=>$request->serie_id,
            'number_season'=>$request->number_season,
            'poster'=>$posterPath!=''?Storage::url($posterPath):null,
            'banner'=>$BannerPath!=''?Storage::url($BannerPath):null,
        ]);

        return response()->json(['message' => 'Season creada'], 201);
    }
}
