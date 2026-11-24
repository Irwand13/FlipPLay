<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $irwand = User::create([
            'name' => 'Irwand',
            'email' => 'irwand@flipplay.test',
            'password' => Hash::make('password'),
        ]);

        $vio = User::create([
            'name' => 'Vio',
            'email' => 'vio@flipplay.test',
            'password' => Hash::make('password'),
        ]);

        $irwand->media()->attach(
            Media::whereIn('title', ['Fullmetal Alchemist: Brotherhood', 'Death Note'])->pluck('id')
        );

        $vio->media()->attach(
            Media::whereIn('title', ['Demon Slayer: Kimetsu no Yaiba', 'Crash Landing on You'])->pluck('id')
        );
    }
}
