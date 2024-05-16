Cara install:
1. buat database dengan nama rent_car
2. copy .env.example dan ubah menjadi .env
3. install library yang digunakan dengan melakukan pada terminal:
`composer install`
4. lakukan migrate database:
`php artisan migrate:fresh --seed`
5. jalankan aplikasi dengan:
`php artisan serve`

catatan:
- bisa login menggunakan admin, email: admin@rentcar.com, password: Secret123
- bisa login menggunakan customer, email: rafli@rentcar.com, password: Secret123