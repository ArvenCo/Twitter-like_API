<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        \App\Models\User::insert($this->collection(10));
       //DB::collection('users')->insert($this->collection());
    }

    function collection($value = 10){
        $arr = [];
        for($i=0;$i<$value ;$i++){
            array_push($arr, [
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);
        }
        return $arr;
    }
}
