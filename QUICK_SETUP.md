# ⚡ QUICK SETUP - ICLABS

Panduan setup cepat untuk teman yang clone project ini.

---

## 🚀 SETUP DALAM 5 MENIT

```bash
# 1. Clone project
cd C:\xampp\htdocs
git clone [URL_GITHUB] iclabs
cd iclabs

# 2. Start XAMPP
# - Buka XAMPP Control Panel
# - Start Apache & MySQL

# 3. Check MySQL Port (PENTING!)
# Buka: C:\xampp\mysql\bin\my.ini
# Cari: port= (biasanya 3306 atau 3310)

# 4. Update Database Config
# Edit: app/config/database.php
# Line 7: define('DB_PORT', '3310'); // SESUAIKAN!
# Line 9: define('DB_PASS', '');     // Isi jika ada password

# 5. Import Database
# Buka: http://localhost/phpmyadmin
# Tab SQL → Choose File → database/schema.sql → Go

# 6. Test
# Buka: http://localhost/iclabs/public/
```

---

## 🔑 LOGIN

```
Admin:     admin@iclabs.com / password123
Koordinator: koordinator@iclabs.com / password123
Asisten:   asisten1@iclabs.com / password123
```

---

## ⚠️ YANG HARUS DICEK

1. ✅ **Port MySQL** → Update di `database.php`
2. ✅ **Database imported** → 9 tabel harus ada
3. ✅ **Apache + MySQL running** → Hijau di XAMPP

---

## 🐛 ERROR COMMON

**"Database connection failed"**
→ Check port MySQL & password di `database.php`

**"404 Not Found"**
→ Pastikan akses: `http://localhost/iclabs/public/`

**"Access denied"**
→ MySQL butuh password? Update `DB_PASS`

---

📖 **Dokumentasi Lengkap:** Baca `SETUP.md`

