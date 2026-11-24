# FlipPlay — Demo Modul 3 Praktikum Web

Prototype backend engine sederhana dengan PHP OOP (studi kasus FlipPlay), dijalankan sebagai simulasi terminal.

## Meneruskan Modul 1–2

Demo ini melanjutkan FlipPlay dari modul sebelumnya, bukan proyek baru:

- **Modul 1** — FlipPlay adalah platform hiburan digital (streaming video + digital reading) dengan konten anime, drama, manga, dan light novel. Demo M1: landing page HTML + Tailwind.
- **Modul 2** — halaman "The Vibe Grid": daftar media (anime/manga/drama) dari API publik Jikan, dengan Unified Search (filter judul real-time) dan Aura-Based Discovery (tombol aura untuk menyaring data).
- **Modul 3** — backend engine OOP-nya: class `Media` abstrak dengan 4 turunan sesuai 4 tipe konten FlipPlay, `Library` sebagai katalog, dan `User` dengan koleksi. Alur 6 (filter genre) meneruskan Aura-Based Discovery dari Modul 2 ke sisi backend.

## Cara menjalankan

```bash
php index.php
```

Butuh PHP 8.2+. Tidak perlu database atau web server. Bukan aplikasi interaktif — sesuai modul, ini simulasi terminal (tidak ada input `readline`).

## Testing

```bash
composer install
vendor/bin/phpunit --testdox
```

Pakai PHPUnit 11 (skill `laravel-testing`) — sengaja versi 11 supaya tetap jalan di PHP 8.2 (PHPUnit 12 butuh PHP 8.3+). 25 test, 61 assertion: `Library` (tambah, tersedia, cari, detail, filter genre), `Media` (inheritance Anime/Drama/Manga/Light Novel, info, status tersedia), `User` (koleksi), dan `Simulasi` (menjalankan `index.php` asli dan memeriksa keluarannya).

## Struktur

```
flipplay/
├── index.php        entry point, menjalankan 6 alur simulasi
├── composer.json    require-dev: phpunit/phpunit ^11.5
├── composer.lock
├── phpunit.xml
├── tests/Unit/      LibraryTest, MediaTest, UserTest, SimulasiTest
└── src/
    ├── Media.php       class induk (abstract)
    ├── Anime.php       turunan Media (studio + episode)
    ├── Drama.php       turunan Media (studio + episode)
    ├── Manga.php       turunan Media (penulis + chapter)
    ├── LightNovel.php  turunan Media (penulis + volume)
    ├── Library.php     katalog media: tambah, daftar, cari, detail, filter genre
    └── User.php        pengguna dan koleksinya
```

Semua class memakai namespace `FlipPlay` dan dimuat di `index.php` lewat autoloader sederhana.

## Data media

Judul nyata dengan angka terverifikasi (Wikipedia / MyAnimeList — sumber yang sama dengan data Jikan API; API Jikan tidak bisa dijangkau langsung dari VM ini, jadi angkanya dicek silang ke sana):

| Judul | Tipe | Genre | Tahun | Detail | Status |
| --- | --- | --- | --- | --- | --- |
| Fullmetal Alchemist: Brotherhood | Anime | Action | 2009 | Bones, 64 episode | Tersedia |
| Demon Slayer: Kimetsu no Yaiba | Anime | Action | 2019 | ufotable, 63 episode | Tersedia |
| Death Note | Manga | Thriller | 2003 | Tsugumi Ohba, 108 chapter | Tersedia |
| Vagabond | Manga | Action | 1998 | Takehiko Inoue, 327 chapter | Tersedia |
| Mushoku Tensei: Jobless Reincarnation | Light Novel | Fantasy | 2014 | Rifujin na Magonote, 26 volume | Tersedia |
| Squid Game | Drama | Thriller | 2021 | Netflix, 9 episode | Tidak tersedia |
| Crash Landing on You | Drama | Romance | 2019 | tvN, 16 episode | Tersedia |

Satu item sengaja tidak tersedia (Squid Game) untuk mendemonstrasikan filter `getAvailable()`.

## Alur simulasi

1. Menambahkan media ke library
2. Menampilkan daftar media yang tersedia
3. Mencari media berdasarkan judul
4. Menampilkan detail satu media
5. Menampilkan koleksi media milik pengguna
6. Filter berdasarkan genre (Aura-Based Discovery)

---

## Demo Modul 4 — Laravel REST API

Demo ini melanjutkan FlipPlay dari Modul 3: entitas yang sama (`Media` dan `User` + koleksi) kini jadi REST API dengan Laravel 12, database MySQL, dan Eloquent ORM. Simulasi terminal Modul 3 (`php index.php`, `src/`) tetap ada dan tetap jalan; `composer.json` di root sekarang milik Laravel.

### Setup

```bash
composer install
cp .env.example .env
# sesuaikan DB_DATABASE dkk. di .env, lalu buat database-nya di Laragon / XAMPP
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Cek route: `php artisan route:list`

### Endpoint

| Method | Endpoint | Keterangan |
| --- | --- | --- |
| GET | /api/media | Daftar media (filter `?title=` dan `?genre=`, pagination 10) |
| GET | /api/media/{id} | Detail satu media + pengguna yang mengoleksinya |
| POST | /api/media | Tambah media (201) |
| PATCH | /api/media/{id} | Ubah media |
| DELETE | /api/media/{id} | Hapus media (204) |
| GET | /api/users | Daftar pengguna + jumlah koleksi |
| GET | /api/users/{id} | Detail pengguna + koleksi medianya |
| POST | /api/users/{id}/collection | Tambah media ke koleksi (`{"media_id": 1}`, 201; duplikat 409) |
| DELETE | /api/users/{id}/collection/{media_id} | Hapus media dari koleksi (204; tidak ada di koleksi 404) |

Validasi gagal: 422. ID tidak ditemukan: 404.

### Struktur (tambahan Modul 4)

```
app/Models/Media.php            Eloquent + relasi users (belongsToMany)
app/Models/User.php             + relasi media (belongsToMany)
app/Http/Controllers/MediaController.php    CRUD standar
app/Http/Controllers/UserController.php     index/show + attach/detach koleksi
app/Http/Requests/              StoreMediaRequest, UpdateMediaRequest (sometimes buat PATCH)
app/Http/Resources/             MediaResource, UserResource (whenLoaded / whenCounted)
database/migrations/            media + pivot media_user
database/seeders/               MediaSeeder (7 judul Modul 3), UserSeeder
routes/api.php                  apiResource + route custom collection
```
