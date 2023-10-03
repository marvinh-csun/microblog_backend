<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        
        for($i = 0; $i < 1000; $i++) {
            Comment::create([
                "comment"=>fake()->text(),
                "user_id"=>fake()->numberBetween(1,5), //make sure you register at least five users
                "blog_id"=>fake()->numberBetween(1,10),
            ]);
        }
    }
}
