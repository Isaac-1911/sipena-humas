<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Archive;

class ArchiveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'Dokumentasi Operasi Patuh 2026',
                'description' => 'Kegiatan operasi patuh oleh Polres Jember.',
                'file_path' => 'archives/operasi-patuh.jpg',
                'category' => 'image',
            ],
            [
                'title' => 'Pengamanan Acara Festival Kota',
                'description' => 'Dokumentasi pengamanan festival tahunan.',
                'file_path' => 'archives/festival.jpg',
                'category' => 'image',
            ],
            [
                'title' => 'Video Kegiatan Sosialisasi',
                'description' => 'Sosialisasi keamanan kepada masyarakat.',
                'file_path' => 'archives/sosialisasi.mp4',
                'category' => 'video',
            ],
            [
                'title' => 'Laporan Kegiatan Bulanan',
                'description' => 'Dokumen laporan kegiatan HUMAS.',
                'file_path' => 'archives/laporan.pdf',
                'category' => 'document',
            ],
            [
                'title' => 'Pelatihan Internal HUMAS',
                'description' => 'Dokumentasi pelatihan internal staf.',
                'file_path' => 'archives/pelatihan.jpg',
                'category' => 'image',
            ],
        ];

        foreach ($data as $item) {
            Archive::create($item);
        }
    }
}
