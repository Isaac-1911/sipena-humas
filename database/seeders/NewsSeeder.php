<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news')->insert([
            'title' => 'Testing News',
            'slug' => 'testing-news',
            'content' => 'Testing content!',
            'thumbnail' => 'thumbnail/lkjafldkjafd',
            'published_at' => now(),
            'is_published' => 0,
            'author_id' => 1,
            
        ]);
    }
}
