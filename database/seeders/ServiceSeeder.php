<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('services')->insert([
            'name' => 'Layanan Pengaduan',
            'description' => 'Laporkan kejadian kriminal atau gangguan keamanan',
            'icon' => 'Shield',
            'link' => 'https://wa.me65465'
        ]);
    }
}
