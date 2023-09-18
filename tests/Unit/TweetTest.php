<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tweet;

use Illuminate\Support\Facades\Http;
class TweetTest extends TestCase
{

    public function test_create_new_tweet(){
        $content = 'New '.fake()->sentence();
        $user_id = User::all()->random()->id;

        $tweet = Tweet::create([
            'content' => $content,
            'user_id' => $user_id,
        ]);

        $this->assertDatabaseHas('tweets', [
            'id' => $tweet->id
        ]);
    }

    public function test_update_tweet_content(){
        $id = Tweet::all()->random()->id;
        $content = 'Updated Content '.fake()->sentence();
        $tweet = Tweet::find($id);
        $tweet->content = $content;
        $tweet->save();
        $this->assertDatabaseHas('tweets', [
            'id' => $id,
            'content' => $content,
        ]);
    }


}
