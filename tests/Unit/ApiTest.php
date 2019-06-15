<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Comment;
use App\Like;
use App\Episode;
use App\Group;
use App\Favorite;
use App\UploadServer;
use App\DownloadsServer;
use App\Notification;
use App\Rating;
use App\GroupType;


class ApiTest extends TestCase
{
    use WithFaker;

    public $token;
    public $CurrentAuth;


    function setUp()
    {
        parent::setUp();

    }

    
    public function testLogin()
    {
        $response = $this->json('POST', 'api/login', [
            'email' => 'cesar39@example.net', 'password' => 'secret'
        ]);
        $data = json_decode($response->getContent());
        $this->token = $data->authUser->remember_token;
        $this->CurrentAuth = $data->authUser;
        $response->assertOk();
    }







    public function testRegister()
    {
        $response = $this->json('POST', 'api/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $data = json_decode($response->getContent());
        $this->token = $data->authUser->remember_token;
        $this->CurrentAuth = $data->authUser;
        $response->assertOk();
    }








    public function testAddLike()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('POST', 'api/likes', [
            'likestable_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'likestable_type' => $this->faker->randomElement($array = array('App\Episode', 'App\Group')),
        ]);
        $response->assertOk();
    }









    public function testdeleteLike()
    {
        $record = Like::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();

        $response = $this->actingAs($user, 'api')->json('delete', 'api/likes/' . $record->id);
        $response->assertOk();
    }



    public function testaddFavorite()
    {
        $user = User::inRandomOrder()->first();

        $response = $this->actingAs($user, 'api')->json('POST', 'api/favorites', [
            'favoritetable_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'favoritetable_type' => $this->faker->randomElement($array = array('App\Episode', 'App\Group')),
        ]);
        $response->assertOk();

    }





    public function testdeleteFovriate()
    {
        $user = User::inRandomOrder()->first();

        $record = Favorite::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('delete', 'api/favorites/' . $record->id);
        $response->assertOk();
    }




    public function testaddComment()
    {
        $user = User::inRandomOrder()->first();

        $response = $this->actingAs($user, 'api')->json('POST', 'api/comments', [
            'body' => $this->faker->sentence($nbWords = 15, $variableNbWords = true),
            'commenttable_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'commenttable_type' => $this->faker->randomElement($array = array('App\Episode', 'App\Group')),
        ]);
        $response->assertOk();

    }





    public function testdeleteComment()
    {
        $user = User::inRandomOrder()->first();

        $record = Comment::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('delete', 'api/comments/' . $record->id);
        $response->assertOk();
    }




    public function testUpdateComment()
    {
        $user = User::inRandomOrder()->first();

        $record = Comment::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('PUT', 'api/comments/' . $record->id, [
            'body' => $this->faker->sentence($nbWords = 15, $variableNbWords = true),
            'commenttable_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'commenttable_type' => $this->faker->randomElement($array = array('App\Episode', 'App\Group')),
        ]);
        $response->assertOk();
    }





    public function testaddEpisode()
    {
        $record = Group::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('POST', 'api/episode', [
            'group_id' => $record->id,
            'number' => $this->faker->numberBetween($min = 1, $max = 50),
            'description' => $this->faker->sentence($nbWords = 15, $variableNbWords = true),
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
        ]);
        $response->assertOk();
    }



    public function testupdateEpisode()
    {
        $record = Episode::inRandomOrder()->first();
        $record2 = Group::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('PUT', 'api/episode/' . $record->id, [
            'group_id' => $record2->id,
            'number' => $this->faker->numberBetween($min = 1, $max = 30),
            'description' => $this->faker->sentence($nbWords = 15, $variableNbWords = true),
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
        ]);
        $response->assertOk();
    }



    public function testdeleteEpisode()
    {
        $record = Episode::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('delete', 'api/episode/' . $record->id);
        $response->assertOk();
    }


   
    public function addGroup()
    {
        $user = User::inRandomOrder()->first();
        $groupType = App\GroupType::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('POST', 'api/group', [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence($nbWords = 15, $variableNbWords = true),
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
            'group_type_id'=> $groupType->id,
        ]);
        $response->assertOk();
    }



    public function testupdateGroup()
    {
        $record = Group::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $groupType = App\GroupType::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('PUT', 'api/group/' . $record->id, [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence($nbWords = 15, $variableNbWords = true),
            'image' => $this->faker->imageUrl($width = 640, $height = 480),
            'group_type_id' => $groupType->id,
        ]);
        $response->assertOk();
    }


    public function testdeleteGroup()
    {
        $record = Group::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('delete', 'api/group/' . $record->id);
        $response->assertOk();
    }


 
    public function testaddServerDownloads()
    {
        $user = User::inRandomOrder()->first();
        $episode = Episode::inRandomOrder()->first();

        $response = $this->actingAs($user, 'api')->json('POST', 'api/downloadsServer', [
            'server_name' => $this->faker->lastName,
            'episode_link' => $this->faker->imageUrl($width = 640, $height = 480),
            'episode_id'=> $episode->id,
        ]);
        $response->assertOk();
    }



    public function testuplodateDwonloadsServer()
    {
        $episode = Episode::inRandomOrder()->first();

        $user = User::inRandomOrder()->first();
        $record = DownloadsServer::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('PUT', 'api/downloadsServer/' . $record->id, [
            'server_name' => $this->faker->lastName,
            'episode_link' => $this->faker->imageUrl($width = 640, $height = 480),
            'episode_id' => $episode->id,
        ]);
        $response->assertOk();
    }


    public function testdownloadServerDelete()
    {
        $episode = Episode::inRandomOrder()->first();

        $user = User::inRandomOrder()->first();
        $record = DownloadsServer::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('delete', 'api/downloadsServer/' . $record->id);
        $response->assertOk();
    }


    public function testaddServerUploads()
    {
        $episode = Episode::inRandomOrder()->first();

        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('POST', 'api/uploadServer', [
            'server_name' => $this->faker->lastName,
            'episode_link' => $this->faker->imageUrl($width = 640, $height = 480),
            'episode_id' => $episode->id,
        ]);
        $response->assertOk();
    }

    
    public function testuploadServerDelete()
    {
        $user = User::inRandomOrder()->first();
        $record = UploadServer::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('delete', 'api/uploadServer/' . $record->id);
        $response->assertOk();
    }
     // 20
    public function testuploadsServerUpdate()
    {
        $user = User::inRandomOrder()->first();
        $record = UploadServer::inRandomOrder()->first();
        $episode = Episode::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('PUT', 'api/uploadServer/' . $record->id, [
            'server_name' => $this->faker->lastName,
            'episode_link' => $this->faker->imageUrl($width = 640, $height = 480),
            'episode_id' => $episode->id,
        ]);
        $response->assertOk();
    }



    public function testuplodateUser()
    {
        $user = User::inRandomOrder()->first();
        $record = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('PUT', 'api/user/' . $record->id, [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);
        $response->assertOk();
    }


    public function testdeleteUser()
    {
        $user = User::inRandomOrder()->first();
        $record = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('delete', 'api/user/' . $record->id);
        $response->assertOk();
    }

    public function testaddNotification()
    {
        $user = User::inRandomOrder()->first();
        $record = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('POST', 'api/notify', [
            'receiver_id' => $record->id,
            'body' => $this->faker->sentence($nbWords = 15, $variableNbWords = true),
        ]);
        $response->assertOk();
    }
    public function testUpdateNotification()
    {
        $user = User::inRandomOrder()->first();
        $record = Notification::inRandomOrder()->first();
        $record_2 = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('PUT', 'api/notify/' . $record->id, [
            'receiver_id' => $record_2->id,
            'body' => $this->faker->sentence($nbWords = 15, $variableNbWords = true),
        ]);
        $response->assertOk();
    }


     // 25
    public function testDeleteNotification()
    {
        $user = User::inRandomOrder()->first();
        $record = Notification::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('delete', 'api/notify/' . $record->id);
        $response->assertOk();
    }

    public function testLike()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->get('api/likes');
        $response->assertOk();
    }
    public function testNotify()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->get('api/notify');
        $response->assertOk();

    }
    public function testComment()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->get('api/comments');
        $response->assertOk();

    }


    public function testFavorite()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->get('api/favorites');
        $response->assertOk();
    }


     // 30
    public function testGroup()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->get('api/group');
        $response->assertOk();
    }
    public function testEpisodes()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->get('api/episode');
        $response->assertOk();
    }
    public function testUploadServer()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->get('api/uploadServer');
        $response->assertOk();
    }
    public function testDownloadsServer()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->get('api/downloadsServer');
        $response->assertOk();
    }
    
    public function testRating(){
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->get('api/rating');
        $response->assertOk();
    }


    // 35
    public function testAddRating()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('POST', 'api/rating', [
            'count'=> $this->faker->numberBetween($min = 1, $max = 5),
            'rating_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'rating_type' => $this->faker->randomElement($array = array('App\Episode', 'App\Group')),
        ]);
        $response->assertOk();
    }
    public function testUpdteRating()
    {
        $user = User::inRandomOrder()->first();
        $rating = Rating::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('PUT', 'api/rating/'. $rating->id, [
            'count' => $this->faker->numberBetween($min = 1, $max = 5),
            'rating_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'rating_type' => $this->faker->randomElement($array = array('App\Episode', 'App\Group')),
        ]);
        $response->assertOk();
    }
    public function testDeleteRating()
    {
        $record = Rating::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();

        $response = $this->actingAs($user, 'api')->json('delete', 'api/rating/' . $record->id);
        $response->assertOk();
    }
    


    public function testGroupType()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->get('api/groupType');
        $response->assertOk();
    }

    // 40
    public function testAddgroupType()
    {
        $user = User::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('POST', 'api/groupType', [
            'name' => $this->faker->randomElement($array = array('Manga', 'Movies', 'Collections')),
            'description' => $this->faker->sentence($nbWords = 15,$variableNbWords = true)]);
        $response->assertOk();
    }
    public function testUpdtegroupType()
    {
        $user = User::inRandomOrder()->first();
        $rating = GroupType::inRandomOrder()->first();
        $response = $this->actingAs($user, 'api')->json('PUT', 'api/groupType/' . $rating->id, [
            'name' => $this->faker->randomElement($array = array('Manga', 'Movies', 'Collections')),
            'description' => $this->faker->sentence($nbWords = 15,$variableNbWords = true)]);
        $response->assertOk();
    }
    public function testDeletegroupType()
    {
        $record = GroupType::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();

        $response = $this->actingAs($user, 'api')->json('delete', 'api/groupType/' . $record->id);
        $response->assertOk();
    }
   
     

}
