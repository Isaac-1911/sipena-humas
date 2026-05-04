<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use Illuminate\Support\Str;

class MessageSeeder extends Seeder
{
    public function run(): void
    {
        Message::truncate();

        $data = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'subject' => 'Permohonan Informasi',
                'message' => 'Saya ingin menanyakan terkait jadwal pelayanan di Polres Jember.',
                'is_read' => false,
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@gmail.com',
                'subject' => 'Laporan Kehilangan',
                'message' => 'Saya kehilangan KTP dan ingin membuat laporan kehilangan.',
                'is_read' => true,
            ],
            [
                'name' => 'Ahmad Fauzi',
                'email' => 'ahmad@gmail.com',
                'subject' => 'Pengaduan Masyarakat',
                'message' => 'Saya ingin melaporkan kejadian yang terjadi di lingkungan saya.',
                'is_read' => false,
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@gmail.com',
                'subject' => 'Informasi SIM',
                'message' => 'Apakah perpanjangan SIM bisa dilakukan secara online?',
                'is_read' => true,
            ],
            [
                'name' => 'Rizky Pratama',
                'email' => 'rizky@gmail.com',
                'subject' => 'Jadwal Operasional',
                'message' => 'Mohon info jam operasional pelayanan publik di Polres.',
                'is_read' => false,
            ],
        ];

        foreach ($data as $item) {
            Message::create([
                'name' => $item['name'],
                'email' => $item['email'],
                'subject' => $item['subject'],
                'message' => $item['message'],
                'is_read' => $item['is_read'],
                'created_at' => now()->subDays(rand(0, 5)),
                'updated_at' => now(),
            ]);
        }
    }
}
