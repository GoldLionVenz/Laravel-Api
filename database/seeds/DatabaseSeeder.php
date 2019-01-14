<?php

use Illuminate\Database\Seeder;
use App\Serie;
use App\Season;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $series=factory(App\Serie::class,10)->create();
        $series->each(function(App\Serie $serie) use ($series) {
            $count=1;
            for($i=0;$i<random_int(1,7);$i++){
                factory(App\Season::class)
                    ->create([
                        'serie_id'=>$serie->id,
                        'number_season'=>$count++
                        ]);
            }
        });
        // $this->call(UsersTableSeeder::class);
           /* $gameId=str_random(20);
            Serie::create([
                'title'=>'Game of Thrones',
                'poster'=> 'https://m.media-amazon.com/images/M/MV5BMjE3NTQ1NDg1Ml5BMl5BanBnXkFtZTgwNzY2NDA0MjI@._V1_SX300.jpg',
                'plot'=>'In the mythical continent of Westeros, several powerful families fight for control of the Seven Kingdoms. As conflict erupts in the kingdoms of men, an ancient enemy rises once again to threaten them all. Meanwhile, the last heirs of a recently usurped dynasty plot to take back their homeland from across the Narrow Sea.',
                'imdbRating'=>9.5,
                'id'=>$gameId,
            ]);
            Season::create([
                'serie_id'=>$gameId,
                'number_season'=>1,
                'poster'=>$gameId,
                'banner'=>$gameId
            ]);
            Season::create([
                'serie_id'=>$gameId,
                'number_season'=>2,
                'poster'=>$gameId,
                'banner'=>$gameId
            ]);
            Season::create([
                'serie_id'=>$gameId,
                'number_season'=>3,
                'poster'=>$gameId,
                'banner'=>$gameId
            ]);
            $daredevilId=str_random(20);
            Serie::create([
                'title'=>'Daredevil',
                'poster'=> 'https://m.media-amazon.com/images/M/MV5BODcwOTg2MDE3NF5BMl5BanBnXkFtZTgwNTUyNTY1NjM@._V1_SX300.jpg',
                'plot'=>'As a child Matt Murdock was blinded by a chemical spill in a freak accident. Instead of limiting him it gave him superhuman senses that enabled him to see the world in a unique and powerful way. Now he uses these powers to deliver justice, not only as a lawyer in his own law firm, but also as vigilante at night, stalking the streets of Hells Kitchen as Daredevil, the man without fear.',
                'imdbRating'=>8.7,
                'id'=>$daredevilId,
            ]);
            Season::create([
                'serie_id'=>$daredevilId,
                'number_season'=>1,
                'poster'=>$daredevilId,
                'banner'=>$daredevilId
            ]);
            Season::create([
                'serie_id'=>$daredevilId,
                'number_season'=>2,
                'poster'=>$daredevilId,
                'banner'=>$daredevilId
            ]);
            Season::create([
                'serie_id'=>$daredevilId,
                'number_season'=>3,
                'poster'=>$daredevilId,
                'banner'=>$daredevilId
            ]);
            $walkingId=str_random(20);
            Serie::create([
                'title'=>'The Walking Dead',
                'poster'=> 'https://m.media-amazon.com/images/M/MV5BMTcwMDAzMDk3OF5BMl5BanBnXkFtZTgwMjY0MzcyNjM@._V1_SX300.jpg',
                'plot'=>"Sheriff Deputy Rick Grimes gets shot and falls into a coma. When awoken he finds himself in a Zombie Apocalypse. Not knowing what to do he sets out to find his family, after he's done that he gets connected to a group to become the leader. He takes charge and tries to help this group of people survive, find a place to live, and get them food. This show is all about survival, the risks, and the things you'll have to do to survive.",
                'imdbRating'=>8.4,
                'id'=>$walkingId,
            ]);
            Season::create([
                'serie_id'=>$walkingId,
                'number_season'=>1,
                'poster'=>$walkingId,
                'banner'=>$walkingId
            ]);
            Season::create([
                'serie_id'=>$walkingId,
                'number_season'=>2,
                'poster'=>$walkingId,
                'banner'=>$walkingId
            ]);
            Season::create([
                'serie_id'=>$walkingId,
                'number_season'=>3,
                'poster'=>$walkingId,
                'banner'=>$walkingId
            ]);*/

            
       
    }
}
