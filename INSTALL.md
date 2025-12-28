# PANDUAN INSTALASI ICLABS

## Langkah-Langkah Setup

### 1. Install XAMPP
- Download XAMPP dari https://www.apachefriends.org/
- Install XAMPP di C:\xampp\
- Start Apache dan MySQL dari XAMPP Control Panel

### 2. Copy Project
- Pastikan folder iclabs sudah ada di `C:\xampp\htdocs\iclabs`
- Struktur folder harus seperti ini:
  ```
  C:\xampp\htdocs\iclabs\
  ├── app/
  ├── public/
  └── database/
  ```

### 3. Setup Database

#### Cara 1: Menggunakan phpMyAdmin
1. Buka browser, akses: http://localhost/phpmyadmin
2. Klik tab "SQL"
3. Copy semua isi file `database/schema.sql`
4. Paste ke SQL editor
5. Klik "Go" atau "Execute"
6. Database `iclabs` akan otomatis dibuat

#### Cara 2: Menggunakan MySQL CLI
1. Buka Command Prompt
2. Masuk ke folder MySQL:
   ```
   cd C:\xampp\mysql\bin
   ```
3. Login ke MySQL:
   ```
   mysql -u root -p
   ```
   (Tekan Enter jika tidak ada password)
4. Import database:
   ```
   source C:\xampp\htdocs\iclabs\database\schema.sql
   ```

### 4. Verifikasi Database
1. Buka phpMyAdmin
2. Pastikan database `iclabs` ada
3. Pastikan ada 9 tabel:
   - roles
   - users
   - laboratories
   - lab_schedules
   - assistant_schedules
   - head_laboran
   - lab_activities
   - lab_problems
   - problem_histories

### 5. Konfigurasi (Opsional)
Jika database username/password berbeda, edit file:
`app/config/database.php`

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'iclabs');
define('DB_USER', 'root');        // Ganti jika perlu
define('DB_PASS', '');            // Ganti jika ada password
```

### 6. Akses Aplikasi
Buka browser dan akses:
```
http://localhost/iclabs/public/
```

### 7. Login
Gunakan salah satu akun berikut:

**Admin:**
- Email: admin@iclabs.com
- Password: password123

**Koordinator:**
- Email: koordinator@iclabs.com
- Password: password123

**Asisten:**
- Email: asisten1@iclabs.com
- Password: password123

## Troubleshooting

### Problem: "Cannot connect to database"
**Solusi:**
- Pastikan MySQL service running di XAMPP
- Cek credential di `app/config/database.php`
- Import ulang database dari `database/schema.sql`

### Problem: "404 Not Found" semua halaman
**Solusi:**
- Pastikan Apache mod_rewrite aktif
- Cek file `.htaccess` ada di folder `public/`
- Akses HARUS menggunakan: http://localhost/iclabs/public/

### Problem: "Page not found" setelah login
**Solusi:**
- Pastikan semua file controller ada di `app/controllers/`
- Cek error di console browser (F12)
- Cek Apache error log di `C:\xampp\apache\logs\error.log`

### Problem: Upload foto tidak berfungsi
**Solusi:**
1. Buat folder `public/uploads/head-laboran/`
2. Right-click folder → Properties → Security
3. Edit → Users → Allow Full Control
4. Apply

## Testing Sistem

### Test 1: Public Access
1. Buka http://localhost/iclabs/public/
2. Harus muncul landing page dengan jadwal hari ini
3. Klik "Laboratory Schedule" → harus muncul semua jadwal

### Test 2: Login Admin
1. Klik "Login" di navbar
2. Login sebagai admin@iclabs.com
3. Harus redirect ke Admin Dashboard
4. Cek semua menu di sidebar berfungsi

### Test 3: CRUD Users (Admin)
1. Klik "User Management"
2. Klik "Add New User"
3. Isi form dan submit
4. User baru harus muncul di list

### Test 4: Report Problem (Asisten)
1. Logout dari admin
2. Login sebagai asisten1@iclabs.com
3. Klik "Report Problem"
4. Isi form dan submit
5. Laporan harus muncul di dashboard

### Test 5: Update Status (Koordinator)
1. Logout dari asisten
2. Login sebagai koordinator@iclabs.com
3. Klik problem di dashboard
4. Update status ke "in_progress"
5. Status harus berubah dan masuk history

## Selesai!
Jika semua langkah di atas berhasil, sistem ICLABS sudah siap digunakan.

---
Jika ada pertanyaan, hubungi developer atau cek README.md untuk dokumentasi lengkap.
