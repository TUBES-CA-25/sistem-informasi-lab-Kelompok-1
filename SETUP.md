# 🚀 SETUP GUIDE - ICLABS Project

Panduan lengkap untuk setup project ICLABS setelah clone dari GitHub.

---

## 📋 PREREQUISITES

Pastikan sudah terinstall:
- ✅ **XAMPP** (Apache + MySQL + PHP 8.x)
- ✅ **Git** (untuk clone repository)
- ✅ **Web Browser** (Chrome/Firefox/Edge)

---

## 🔧 LANGKAH-LANGKAH SETUP

### **1. Clone Repository**

Buka terminal/command prompt, lalu:

```bash
cd C:\xampp\htdocs
git clone [URL_REPOSITORY_GITHUB] iclabs
cd iclabs
```

---

### **2. Start XAMPP Services**

1. Buka **XAMPP Control Panel**
2. Klik **Start** pada **Apache**
3. Klik **Start** pada **MySQL**
4. Pastikan background kedua service berubah hijau

---

### **3. Check MySQL Port (PENTING!)**

Cek port MySQL yang digunakan:

```bash
# Lihat file my.ini
notepad C:\xampp\mysql\bin\my.ini
```

Cari baris `port=`, biasanya:
- `port=3306` (default) atau
- `port=3310` (seperti config saat ini)

**Catat port number ini!**

---

### **4. Update Database Configuration**

Edit file: `app/config/database.php`

```php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3310');  // ⚠️ SESUAIKAN dengan port MySQL kamu!
define('DB_NAME', 'iclabs');
define('DB_USER', 'root');
define('DB_PASS', '');      // ⚠️ Isi jika MySQL kamu pakai password
define('DB_CHARSET', 'utf8mb4');
```

**Update bagian ini:**
- `DB_PORT` → Sesuaikan dengan port MySQL kamu (3306 atau 3310)
- `DB_PASS` → Isi password MySQL jika ada (biasanya kosong di XAMPP)

---

### **5. Import Database**

#### **Option A: Via phpMyAdmin (Recommended)**

1. Buka browser: `http://localhost/phpmyadmin`
2. Klik tab **SQL**
3. Klik **Choose File** → Pilih `database/schema.sql`
4. Klik **Go**
5. Tunggu sampai selesai (akan muncul pesan sukses)

#### **Option B: Via MySQL Command Line**

```bash
cd C:\xampp\mysql\bin
.\mysql.exe -u root -P 3310 -e "source C:/xampp/htdocs/iclabs/database/schema.sql"
```

**⚠️ Ganti `-P 3310` dengan port MySQL kamu!**

---

### **6. Verify Database**

Pastikan database sudah terbuat:

1. Buka phpMyAdmin: `http://localhost/phpmyadmin`
2. Cek database `iclabs` sudah ada
3. Pastikan ada **9 tabel**:
   - roles
   - users
   - laboratories
   - lab_schedules
   - assistant_schedules
   - head_laboran
   - lab_activities
   - lab_problems
   - problem_histories

---

### **7. Test Akses Website**

Buka browser dan akses:

```
http://localhost/iclabs/public/
```

**✅ Jika berhasil:** Landing page muncul dengan tampilan modern

**❌ Jika error:** Lanjut ke Troubleshooting

---

### **8. Login dengan Akun Default**

Akses halaman login: `http://localhost/iclabs/public/login`

**Akun yang tersedia:**

```
👨‍💼 Admin:
Email: admin@iclabs.com
Password: password123

👨‍🏫 Koordinator:
Email: koordinator@iclabs.com
Password: password123

👨‍🎓 Asisten:
Email: asisten1@iclabs.com
Password: password123
```

---

## ⚙️ KONFIGURASI TAMBAHAN (Opsional)

### **Ganti Base URL (Jika Perlu)**

Edit file: `public/index.php`

```php
define('BASE_URL', 'http://localhost/iclabs/public');
```

Ganti jika:
- Project ada di subfolder berbeda
- Pakai virtual host
- Pakai domain custom

---

### **Enable URL Rewriting (Recommended)**

Untuk URL yang lebih clean (tanpa `/index.php`):

1. Buka: `C:\xampp\apache\conf\httpd.conf`
2. Cari baris: `#LoadModule rewrite_module modules/mod_rewrite.so`
3. Hapus tanda `#` di depannya
4. **Restart Apache** di XAMPP Control Panel

---

### **Setup Favicon (Logo FIKOM)**

Jika ada logo FIKOM:

1. Convert logo ke favicon: https://favicon.io/
2. Download hasil conversion
3. Copy semua file ke: `public/assets/images/`
4. Refresh browser dengan **Ctrl+F5**

---

## 🐛 TROUBLESHOOTING

### **Problem 1: "Database connection failed"**

**Solusi:**
1. Pastikan MySQL running di XAMPP
2. Check port di `app/config/database.php`
3. Check password MySQL (biasanya kosong)

Test connection:
```bash
php -r "try { $pdo = new PDO('mysql:host=127.0.0.1;port=3310', 'root', ''); echo 'OK'; } catch (Exception $e) { echo $e->getMessage(); }"
```

---

### **Problem 2: "Page not found / 404"**

**Solusi:**
1. Pastikan URL: `http://localhost/iclabs/public/`
2. Check file `.htaccess` ada di folder `public/`
3. Aktifkan mod_rewrite Apache (lihat di atas)

---

### **Problem 3: "Access denied for user 'root'@'localhost'"**

**Solusi:**
1. MySQL butuh password → Update `DB_PASS` di `database.php`
2. Atau reset password MySQL jadi kosong

---

### **Problem 4: "View not found"**

**Solusi:**
1. Pastikan semua folder ada di `app/views/`
2. Re-clone repository jika ada file missing
3. Check capitalization (Windows tidak case-sensitive tapi Linux iya)

---

### **Problem 5: "Call to undefined function"**

**Solusi:**
1. Pastikan `app/helpers/functions.php` ter-load
2. Check `public/index.php` ada baris:
   ```php
   require_once APP_PATH . '/helpers/functions.php';
   ```

---

## 📁 STRUKTUR PROJECT

Pastikan struktur folder lengkap:

```
iclabs/
├── app/
│   ├── config/
│   │   ├── database.php
│   │   └── routes.php
│   ├── controllers/
│   ├── core/
│   ├── helpers/
│   ├── models/
│   └── views/
├── database/
│   └── schema.sql
├── public/
│   ├── .htaccess
│   ├── index.php
│   └── assets/
├── .gitignore
├── README.md
├── INSTALL.md
└── SETUP.md (file ini)
```

---

## ✅ CHECKLIST SETELAH SETUP

- [ ] XAMPP Apache & MySQL running
- [ ] Database `iclabs` sudah diimport (9 tabel)
- [ ] Port MySQL sudah sesuai di `database.php`
- [ ] Landing page bisa diakses
- [ ] Login berhasil dengan akun default
- [ ] Test semua role (admin, koordinator, asisten)

---

## 🎯 NEXT STEPS

Setelah setup berhasil:

1. **Test Semua Fitur** → Gunakan `CHECKLIST.md`
2. **Ganti Password Default** → Login sebagai admin, edit user
3. **Customize** → Sesuaikan dengan kebutuhan
4. **Development** → Mulai develop fitur baru

---

## 📞 BANTUAN

Jika masih ada masalah:

1. Cek `README.md` untuk dokumentasi lengkap
2. Cek Apache error log: `C:\xampp\apache\logs\error.log`
3. Cek browser console (F12) untuk JavaScript error
4. Contact developer team

---

**Happy Coding! 🚀**

---

**Last Updated:** January 2, 2026
**Version:** 1.0.0
