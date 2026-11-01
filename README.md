# Smart Coop

Aplikasi pemantauan kandang: akun peternak, perangkat, monitoring, laporan, dan panel admin. Perintah lampu serta pintu kandang dikirim lewat MQTT.

Stack yang terpasang di `composer.json`: Laravel 12, PHP 8.2, SQLite, Vite, Laravel Reverb, dan klien MQTT.

## Yang perlu dipasang

- PHP 8.2 atau lebih baru
- Composer 2
- Node.js 20 atau lebih baru, plus npm
- Broker MQTT di `127.0.0.1:1883` hanya jika ingin mencoba perintah lampu atau pintu. Alamat itu tertulis langsung di `app/Services/MqttService.php`. Halaman web tetap bisa dibuka tanpa broker.

## Menjalankan di komputer sendiri

```bash
git clone https://github.com/kuncooroo/smart_coop.git
cd smart_coop
```

Database bawaan adalah SQLite. Buat file kosongnya dulu.

Windows PowerShell:

```powershell
New-Item -ItemType File -Force -Path database\database.sqlite
```

macOS / Linux:

```bash
touch database/database.sqlite
```

```bash
composer run setup
php artisan db:seed
composer run dev
```

`composer run setup` menyalin `.env.example` ke `.env`, membuat `APP_KEY`, migrasi, memasang paket npm, dan membangun asset. `composer run dev` menjalankan server, antrean, log, dan Vite.

Buka [http://127.0.0.1:8000](http://127.0.0.1:8000). Di `.env`, set `APP_URL=http://127.0.0.1:8000`.

## Akun contoh

Akun ini dibuat oleh seeder di `database/seeders`.

| Peran | Login | Password | Masuk di |
| --- | --- | --- | --- |
| Peternak | `admin` atau `admin@gmail.com` | `123456` | `/login` |
| Peternak | `user` atau `user@gmail.com` | `123456` | `/login` |
| Super admin | `superadmin@gmail.com` | `password123` | `/admin/login` |
| Admin | `admin@gmail.com` | `password123` | `/admin/login` |

Login peternak menerima username atau email. Login admin memakai email. Ganti password ini jika aplikasi dipasang di tempat yang bisa diakses orang lain.

## Halaman

- `/` beranda
- `/dashboard` dan `/monitoring` setelah masuk sebagai peternak
- `/devices` perangkat
- `/laporan` laporan
- `/admin/dashboard` panel admin
