<?php

declare(strict_types=1);

spl_autoload_register(function (string $class): void {
    $file = __DIR__ . '/src/' . str_replace('FlipPlay\\', '', $class) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

use FlipPlay\Anime;
use FlipPlay\Drama;
use FlipPlay\Library;
use FlipPlay\LightNovel;
use FlipPlay\Manga;
use FlipPlay\User;

$library = new Library();

echo "=== FlipPlay ===\n\n";

// 1. Menambahkan media ke library
echo "1. Menambahkan media ke library\n";
$library->addMedia(new Anime('Fullmetal Alchemist: Brotherhood', 'Action', 2009, 'Bones', 64));
$library->addMedia(new Anime('Demon Slayer: Kimetsu no Yaiba', 'Action', 2019, 'ufotable', 63));
$library->addMedia(new Manga('Death Note', 'Thriller', 2003, 'Tsugumi Ohba', 108));
$library->addMedia(new Manga('Vagabond', 'Action', 1998, 'Takehiko Inoue', 327));
$library->addMedia(new LightNovel('Mushoku Tensei: Jobless Reincarnation', 'Fantasy', 2014, 'Rifujin na Magonote', 26));
$library->addMedia(new Drama('Squid Game', 'Thriller', 2021, 'Netflix', 9, false));
$library->addMedia(new Drama('Crash Landing on You', 'Romance', 2019, 'tvN', 16));
foreach ($library->getAll() as $media) {
    echo "   + [{$media->getType()}] {$media->getTitle()}\n";
}

// 2. Menampilkan daftar media yang tersedia
echo "\n2. Media yang tersedia\n";
foreach ($library->getAvailable() as $media) {
    echo "   - {$media->getInfo()}\n";
}

// 3. Mencari media berdasarkan judul
echo "\n3. Pencarian judul 'slayer'\n";
foreach ($library->searchByTitle('slayer') as $media) {
    echo "   Ditemukan: {$media->getInfo()}\n";
}

// 4. Menampilkan detail satu media
echo "\n4. Detail media 'Fullmetal Alchemist: Brotherhood'\n";
$detail = $library->findByTitle('Fullmetal Alchemist: Brotherhood');
echo $detail !== null ? "   {$detail->getInfo()}\n" : "   Media tidak ditemukan.\n";

// 5. Menampilkan koleksi media milik pengguna
echo "\n5. Koleksi pengguna\n";
$user = new User('Irwand');
$user->addToCollection($library->findByTitle('Fullmetal Alchemist: Brotherhood'));
$user->addToCollection($library->findByTitle('Mushoku Tensei: Jobless Reincarnation'));
echo "   Koleksi milik {$user->getName()}:\n";
foreach ($user->getCollection() as $media) {
    echo "   * [{$media->getType()}] {$media->getTitle()}\n";
}

// 6. Filter berdasarkan genre (Aura-Based Discovery dari Modul 2)
echo "\n6. Filter berdasarkan genre 'Action'\n";
foreach ($library->filterByGenre('Action') as $media) {
    echo "   - {$media->getInfo()}\n";
}
