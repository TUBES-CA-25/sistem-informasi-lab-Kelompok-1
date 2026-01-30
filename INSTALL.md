# 📦 INSTALASI ICLABS

> **Panduan Lengkap Instalasi Laboratory Information System**

---

## 📋 Prasyarat Sistem

### Minimum Requirements
- **Operating System**: Windows 10/11, macOS, Linux
- **RAM**: 4GB minimum, 8GB recommended
- **Storage**: 500MB free space
- **Browser**: Chrome 90+, Firefox 88+, Edge 90+

### Software Requirements
| Software | Version | Download |
|----------|---------|----------|
| **XAMPP** | 8.0+ | [https://www.apachefriends.org](https://www.apachefriends.org) |
| **PHP** | 8.0+ | (Included in XAMPP) |
| **MySQL/MariaDB** | 5.7+ / 10.4+ | (Included in XAMPP) |
| **Git** (Optional) | Latest | [https://git-scm.com](https://git-scm.com) |

---

## 🚀 Instalasi Step-by-Step

### Step 1: Install XAMPP

1. Download XAMPP dari [https://www.apachefriends.org](https://www.apachefriends.org)
2. Install XAMPP di `C:\xampp` (Windows) atau `/opt/lampp` (Linux)
3. Jalankan **XAMPP Control Panel**
4. Start **Apache** dan **MySQL**

![XAMPP Control Panel](https://via.placeholder.com/600x200/0ea5e9/ffffff?text=XAMPP+Control+Panel)

---

### Step 2: Download Project

#### Opsi A: Via Git (Recommended)
```bash
cd C:\xampp\htdocs
git clone https://github.com/yourusername/iclabs.git
cd iclabs
```

#### Opsi B: Download ZIP
1. Download ZIP dari GitHub
2. Extract ke `C:\xampp\htdocs\iclabs`
3. Pastikan struktur folder:
   ```
   C:\xampp\htdocs\iclabs\
   ├── app/
   ├── database/
   ├── public/
   └── README.md
   ```

---

### Step 3: Konfigurasi Database

#### 3.1 Buat Database

1. Buka **phpMyAdmin**: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Klik tab **"New"** atau **"Databases"**
3. Masukkan nama database: `iclabs`
4. Collation: `utf8mb4_unicode_ci`
5. Klik **"Create"**

![Create Database](https://via.placeholder.com/600x200/22c55e/ffffff?text=Create+Database+iclabs)

#### 3.2 Import Schema

1. Pilih database **iclabs**
2. Klik tab **"Import"**
3. Klik **"Choose File"**
4. Pilih file: `database/iclabs.sql`
5. Klik **"Go"** / **"Import"**
6. Tunggu hingga selesai (14 tables created)

✅ **Berhasil**: Muncul pesan "Import has been successfully finished"

---

### Step 4: Konfigurasi Aplikasi

#### 4.1 Edit Database Config

Buka file: `app/config/database.php`

```php
<?php
/**
 * Database Configuration
 */

// Database Connection Settings
define('DB_HOST', 'localhost');
define('DB_PORT', 3310);        // PENTING: Sesuaikan port MySQL
define('DB_NAME', 'iclabs');
define('DB_USER', 'root');
define('DB_PASS', '');          // Password MySQL (default: kosong)

// DSN String
define('DB_DSN', 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4');
```

**⚠️ Catatan Port MySQL:**
- Default MySQL: `3306`
- XAMPP MySQL (jika port conflict): `3310` atau `3307`
- Cek port di **XAMPP Control Panel** → MySQL → Config → my.ini

#### 4.2 Cek Base URL

File: `public/index.php`

```php
// Base URL Configuration
define('BASE_URL', 'http://localhost/iclabs/public');
```

**Jika folder berbeda:**
```php
// Contoh: C:\xampp\htdocs\myproject\
define('BASE_URL', 'http://localhost/myproject/public');
```

---

### Step 5: Verifikasi Instalasi

#### 5.1 Test Database Connection

Buat file test: `public/test-db.php`

```php
<?php
require_once '../app/config/database.php';

try {
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASS);
    echo "✅ Database connection successful!";
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
```

Akses: [http://localhost/iclabs/public/test-db.php](http://localhost/iclabs/public/test-db.php)

#### 5.2 Akses Aplikasi

Buka browser, akses: **http://localhost/iclabs/public**

Jika berhasil, Anda akan melihat **Landing Page ICLABS** 🎉

---

### Step 6: Login ke System

#### Default Accounts

| Role | Email | Password |
|------|-------|----------|
| **Admin** | admin@iclabs.com | admin123 |
| **Koordinator** | koordinator@iclabs.com | koordinator123 |
| **Asisten** | asisten@iclabs.com | asisten123 |

**⚠️ PENTING**: Ganti password default setelah login pertama!

---

## 🔧 Troubleshooting

### ❌ Error: "Access denied for user 'root'@'localhost'"

**Solusi:**
1. Buka **phpMyAdmin**
2. Login dengan user `root` tanpa password
3. Jika gagal, reset password MySQL:
   ```sql
   UPDATE mysql.user SET Password=PASSWORD('') WHERE User='root';
   FLUSH PRIVILEGES;
   ```

### ❌ Error: "SQLSTATE[HY000] [2002] No connection could be made"

**Solusi:**
1. Pastikan MySQL running di XAMPP Control Panel
2. Cek port MySQL (3306 atau 3310)
3. Edit `app/config/database.php` → sesuaikan `DB_PORT`

### ❌ Error: "404 Not Found" atau blank page

**Solusi:**
1. Pastikan struktur folder benar:
   ```
   htdocs/iclabs/public/index.php ✅
   htdocs/public/iclabs/index.php ❌ (salah!)
   ```
2. Cek Apache running di XAMPP
3. Clear browser cache (Ctrl + Shift + R)

### ❌ CSS/Styling tidak muncul

**Solusi:**
1. Periksa koneksi internet (Tailwind CSS via CDN)
2. Buka Developer Tools (F12) → Console → cek error
3. Pastikan Bootstrap Icons CDN loaded

### ❌ Upload file gagal

**Solusi:**
1. Buat folder `public/uploads/` jika belum ada
2. Set permissions (Linux/Mac):
   ```bash
   chmod -R 755 public/uploads
   ```
3. Cek `php.ini`:
   ```ini
   upload_max_filesize = 5M
   post_max_size = 8M
   ```

---

## 🔐 Keamanan Post-Installation

### 1. Hapus File Test
```bash
rm public/test-db.php
```

### 2. Ganti Password Default

Login sebagai Admin → User Management → Edit Admin → Change Password

### 3. Set Secure Permissions

**Windows**: Right-click folder → Properties → Security

**Linux/Mac**:
```bash
# Folder
chmod 755 app/ database/ public/

# Upload folder (writable)
chmod 775 public/uploads/

# Files
chmod 644 app/**/*.php
chmod 644 public/index.php
```

### 4. Backup Database

```bash
# Via Command Line
mysqldump -u root -p iclabs > backup_iclabs_$(date +%Y%m%d).sql

# Via phpMyAdmin
Export → Quick → SQL → Go
```

---

## 🆕 Update Aplikasi

### Via Git
```bash
cd C:\xampp\htdocs\iclabs
git pull origin main
```

### Manual
1. Download versi terbaru
2. Replace semua file kecuali:
   - `app/config/database.php` (keep your config)
   - `public/uploads/` (keep uploaded files)
3. Import migration files (jika ada)

---

## 📞 Bantuan & Support

- **Issue**: [GitHub Issues](https://github.com/yourusername/iclabs/issues)
- **Email**: [your-email@example.com](mailto:your-email@example.com)
- **Documentation**: [README.md](README.md)
- **Project Summary**: [PROJECT_SUMMARY.md](PROJECT_SUMMARY.md)

---

## ✅ Checklist Instalasi

- [ ] XAMPP installed & running (Apache + MySQL)
- [ ] Database `iclabs` created
- [ ] Schema imported (14 tables)
- [ ] Database config edited
- [ ] Test connection success
- [ ] Landing page accessible
- [ ] Login success (Admin/Koordinator/Asisten)
- [ ] Upload folder created & writable
- [ ] Default passwords changed
- [ ] Test file deleted

**🎉 Instalasi Selesai! Happy Coding!**

