<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;
class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for($i = 0; $i < 400; $i++) {
            $title = fake()->unique()->text();
            $slug = str_slug($title, '-');
            $content = fake()->text();
            Blog::create([
                'title'=> $title,
                'slug'=> $slug,
                "description"=>fake()->text(),
                'body'=> "# {$title} \n {$content}",
                'user_id'=> 1,
            ]);
        }
    }
}
