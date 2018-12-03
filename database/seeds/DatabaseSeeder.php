<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

 //   $users = factory(App\User::class, 15)->create();
//    $GroupType = factory(App\GroupType::class, 3)->create();
 //   $groups = factory(App\Group::class,5)->create();
   
  //  $episodes = factory(App\Episode::class, 12)->create();
 //   $downlondservers = factory(App\DownloadsServer::class, 7)->create();
 //   $uploadsServer = factory(App\UploadServer::class, 7)->create();
  //  $rating = factory(App\Rating::class, 12)->create();
    $comments = factory(App\Comment::class,5)->create();
    $liks = factory(App\Like::class, 5)->create();
    $favorites = factory(App\Favorite::class, 5)->create();
    $notifications = factory(App\Notification::class, 3)->create();
   
  }
}
