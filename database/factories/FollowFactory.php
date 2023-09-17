<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Follow;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follow>
 */
class FollowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $user_id = User::all()->random()->id;
        $follow_user = User::where('id', '!=', $user_id)->get()->random()->id;
        if (!Follow::where('user_id', $user_id)->where( 'follow_user_id', $follow_user)->first())
        return [
            //
            'user_id' => $user_id,
            'follow_user_id' => $follow_user,
        ];
    }
}
