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

function tanya(string $prompt): string
{
    if (function_exists('readline')) {
        $jawab = readline($prompt);
        if ($jawab !== false) {
            return trim($jawab);
        }
    }

    echo $prompt;
    $jawab = fgets(STDIN);

    return $jawab === false ? '' : trim($jawab);
}

/** @param Media[] $daftar */
function tampilkan(array $daftar): void
{
    if ($daftar === []) {
        echo "   (tidak ada)\n";
        return;
    }

    foreach ($daftar as $media) {
        echo "   - {$media->getInfo()}\n";
    }
}

$library = new Library();
$library->addMedia(new Anime('Fullmetal Alchemist: Brotherhood', 'Action', 2009, 'Bones', 64));
$library->addMedia(new Anime('Demon Slayer: Kimetsu no Yaiba', 'Action', 2019, 'ufotable', 63));
$library->addMedia(new Manga('Death Note', 'Thriller', 2003, 'Tsugumi Ohba', 108));
$library->addMedia(new Manga('Vagabond', 'Action', 1998, 'Takehiko Inoue', 327));
$library->addMedia(new LightNovel('Mushoku Tensei: Jobless Reincarnation', 'Fantasy', 2014, 'Rifujin na Magonote', 26));
$library->addMedia(new Drama('Squid Game', 'Thriller', 2021, 'Netflix', 9, false));
$library->addMedia(new Drama('Crash Landing on You', 'Romance', 2019, 'tvN', 16));

$user = new User('Irwand');

while (true) {
    echo "\n=== FlipPlay Interaktif ===\n";
    echo "1. Tambah media\n";
    echo "2. Daftar media tersedia\n";
    echo "3. Cari judul\n";
    echo "4. Detail media\n";
    echo "5. Koleksi pengguna\n";
    echo "6. Tambah ke koleksi\n";
    echo "7. Filter genre\n";
    echo "0. Keluar\n";

    $pilih = tanya('Pilih: ');

    if ($pilih === '0') {
        echo "Sampai jumpa!\n";
        break;
    }

    if ($pilih === '1') {
        $tipe = strtolower(tanya('Tipe (anime/manga/drama/lightnovel): '));
        $judul = tanya('Judul: ');
        $genre = tanya('Genre: ');
        $tahun = (int) tanya('Tahun rilis: ');

        if ($tipe === 'anime' || $tipe === 'drama') {
            $studio = tanya('Studio: ');
            $episode = (int) tanya('Jumlah episode: ');
        } elseif ($tipe === 'manga') {
            $penulis = tanya('Penulis: ');
            $chapter = (int) tanya('Jumlah chapter: ');
        } elseif ($tipe === 'lightnovel') {
            $penulis = tanya('Penulis: ');
            $volume = (int) tanya('Jumlah volume: ');
        } else {
            echo "Tipe tidak dikenal.\n";
            continue;
        }

        $tersedia = strtolower(tanya('Tersedia? (y/n): ')) !== 'n';

        if ($tipe === 'anime') {
            $media = new Anime($judul, $genre, $tahun, $studio, $episode, $tersedia);
        } elseif ($tipe === 'drama') {
            $media = new Drama($judul, $genre, $tahun, $studio, $episode, $tersedia);
        } elseif ($tipe === 'manga') {
            $media = new Manga($judul, $genre, $tahun, $penulis, $chapter, $tersedia);
        } else {
            $media = new LightNovel($judul, $genre, $tahun, $penulis, $volume, $tersedia);
        }

        $library->addMedia($media);
        echo "Ditambahkan: {$media->getInfo()}\n";
        continue;
    }

    if ($pilih === '2') {
        tampilkan($library->getAvailable());
        continue;
    }

    if ($pilih === '3') {
        $kata = tanya('Kata kunci judul: ');
        tampilkan($library->searchByTitle($kata));
        continue;
    }

    if ($pilih === '4') {
        $judul = tanya('Judul persis: ');
        $detail = $library->findByTitle($judul);
        echo $detail !== null ? "   {$detail->getInfo()}\n" : "   Media tidak ditemukan.\n";
        continue;
    }

    if ($pilih === '5') {
        echo "Koleksi milik {$user->getName()}:\n";
        $koleksi = $user->getCollection();
        if ($koleksi === []) {
            echo "   (masih kosong)\n";
        }
        foreach ($koleksi as $media) {
            echo "   * [{$media->getType()}] {$media->getTitle()}\n";
        }
        continue;
    }

    if ($pilih === '6') {
        $judul = tanya('Judul persis: ');
        $media = $library->findByTitle($judul);
        if ($media === null) {
            echo "Media tidak ditemukan.\n";
            continue;
        }
        $user->addToCollection($media);
        echo "Masuk koleksi: {$media->getTitle()}\n";
        continue;
    }

    if ($pilih === '7') {
        $genre = tanya('Genre: ');
        tampilkan($library->filterByGenre($genre));
        continue;
    }

    echo "Pilihan tidak dikenal.\n";
}