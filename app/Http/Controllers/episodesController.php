<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Episode;
use App\Comment;
use App\Season;
use App\Notifications\NewEpisode;
use Storage;
class episodesController extends Controller
{
    //
    public function show(Episode $episode){
        return $episode->load(['season','season.serie']);
    }

    public function add(Request $request){
        $season=Season::find($request->season_id);
        /*$request->validate([
            'title'       => 'required|string',
            'plot'    => 'required|string',
        ]);*/
        /*data:application/octet-stream;base64,*/
        $episode= new Episode([
            'id'=>str_random(20),
            'title'=>$request->title, 
            'plot'=>$request->plot,
            'season_id'=>$request->season_id,
            'number_episode'=>$request->number_episode,
            'imdbRating'=>$request->imdb_rating,
            'video'=> $request->file('video')?$request->file('video')->store('videos','public'):null,
            'subtitle'=>$request->file('video')?base64_encode($request->file('video')):null,
        ]);
        $season->episodes()->save($episode);
        $notification=$episode->load(['season','season.serie']);;
        $subcriptores=$season->serie->subcriptores;
        Notification::send($subcriptores,new NewEpisode($notification));
        return response()->json(['message' => 'Episodio Agregado'], 201);
    }

    public function addComment(Episode $episode,Request $request)
    {
        $comment=new Comment([
            'user_id'=>$request->user()->id,
            'content'=>$request->content,
        ]);
        $episode->comments()->save($comment);
        return response()->json(['message' => 'Comentario Agregado'], 201);
    }

    public function getComments(Episode $episode)
    {
        return $episode->comments()->with('user')->latest()->paginate(2); 
    }

    public function getEpisodes(){
        return Episode::with(['season','season.serie'])->latest()->paginate(15);
    }
    
}
