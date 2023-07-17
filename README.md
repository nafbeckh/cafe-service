
# Cafe Service
Cafe Service merupakan aplikasi berbasis web untuk melayani pemesanan menu di sebuah cafe.  

## Instalasi 

### Spesifikasi 
- PHP ^7.3
- Laravel 8
- MySQL

### Cara Instal 

1. Clone project `https://github.com/nafbeckh/cafe-service.git` 
2. Masuk ke direktori project `cd cafe-service` 
3. Install dependensi `composer install` 
4. Copy file .env `cp .env.example .env`
5. Generate key dengan `php artisan key:generate`
6. Setting database di file `.env`
7. Migrasi database `php artisan migrate --seed`
8. Jalankan server `php artisan serv`
9. Selesai

### Aktifkan W

1. Buat akun di [pusher.com](https://pusher.com/)
2. Buat Pusher Channel
3. Masukkan App Keys channel tersebut ke dalam file `.env`

Contoh:
```
PUSHER_APP_ID=xxxxxxx
PUSHER_APP_KEY=xxxxxxxxxxxxxxxxxxxx
PUSHER_APP_SECRET=xxxxxxxxxxxxxxxxxxxx
PUSHER_APP_CLUSTER=xxx
```

### Login Admin 

```
Username: admin
Password: admin123
```
