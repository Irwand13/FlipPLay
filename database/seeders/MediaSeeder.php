<?php

namespace Database\Seeders;

use App\Models\Media;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run(): void
    {
        // Data yang sama dengan demo Modul 3 (judul + angka terverifikasi).
        $media = [
            ['title' => 'Fullmetal Alchemist: Brotherhood', 'type' => 'anime', 'genre' => 'Action', 'year' => 2009, 'creator' => 'Bones', 'episodes' => 64, 'is_available' => true],
            ['title' => 'Demon Slayer: Kimetsu no Yaiba', 'type' => 'anime', 'genre' => 'Action', 'year' => 2019, 'creator' => 'ufotable', 'episodes' => 63, 'is_available' => true],
            ['title' => 'Death Note', 'type' => 'manga', 'genre' => 'Thriller', 'year' => 2003, 'creator' => 'Tsugumi Ohba', 'episodes' => 108, 'is_available' => true],
            ['title' => 'Vagabond', 'type' => 'manga', 'genre' => 'Action', 'year' => 1998, 'creator' => 'Takehiko Inoue', 'episodes' => 327, 'is_available' => true],
            ['title' => 'Mushoku Tensei: Jobless Reincarnation', 'type' => 'light_novel', 'genre' => 'Fantasy', 'year' => 2014, 'creator' => 'Rifujin na Magonote', 'episodes' => 26, 'is_available' => true],
            ['title' => 'Squid Game', 'type' => 'drama', 'genre' => 'Thriller', 'year' => 2021, 'creator' => 'Netflix', 'episodes' => 9, 'is_available' => false],
            ['title' => 'Crash Landing on You', 'type' => 'drama', 'genre' => 'Romance', 'year' => 2019, 'creator' => 'tvN', 'episodes' => 16, 'is_available' => true],
        ];

        foreach ($media as $item) {
            Media::create($item);
        }
    }
}
