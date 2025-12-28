# ✅ CHECKLIST AKHIR - ICLABS SYSTEM

## 📦 INSTALASI & SETUP

### Database Setup
- [ ] Database `iclabs` sudah dibuat
- [ ] Semua 9 tabel sudah ter-create:
  - [ ] roles
  - [ ] users
  - [ ] laboratories
  - [ ] lab_schedules
  - [ ] assistant_schedules
  - [ ] head_laboran
  - [ ] lab_activities
  - [ ] lab_problems
  - [ ] problem_histories
- [ ] Seed data sudah ter-insert (5 users, 4 labs, dll)
- [ ] Foreign key constraints berfungsi

### File Structure
- [ ] Folder `app/config/` lengkap (database.php, routes.php)
- [ ] Folder `app/core/` lengkap (Router, Controller, Model)
- [ ] Folder `app/helpers/` ada functions.php
- [ ] Semua 9 Models ada di `app/models/`
- [ ] Semua 6 Controllers ada di `app/controllers/`
- [ ] Views lengkap di `app/views/`
- [ ] Assets (css, js) ada di `public/assets/`
- [ ] File `public/index.php` dan `.htaccess` ada

### Configuration
- [ ] Database connection di `app/config/database.php` sudah benar
- [ ] BASE_URL di `public/index.php` sudah sesuai
- [ ] Apache mod_rewrite aktif
- [ ] Folder `public/uploads/` writable (chmod 777)

---

## 🔐 AUTHENTICATION & AUTHORIZATION

### Login System
- [ ] Halaman login dapat diakses: `/login`
- [ ] Login dengan credential benar berhasil
- [ ] Login dengan credential salah gagal (error message muncul)
- [ ] Password di-hash dengan bcrypt
- [ ] Session ter-set setelah login (user_id, role, dll)
- [ ] Redirect sesuai role setelah login:
  - [ ] Admin → `/admin/dashboard`
  - [ ] Koordinator → `/koordinator/dashboard`
  - [ ] Asisten → `/asisten/dashboard`

### Logout System
- [ ] Logout berhasil menghapus session
- [ ] Redirect ke login page setelah logout
- [ ] Flash message "logged out" muncul

### Role-Based Access
- [ ] Public dapat akses landing page tanpa login
- [ ] Asisten tidak bisa akses halaman koordinator
- [ ] Asisten tidak bisa akses halaman admin
- [ ] Koordinator tidak bisa akses halaman admin
- [ ] Admin bisa akses semua halaman

---

## 🌐 PUBLIC PAGES (Tanpa Login)

### Landing Page (/)
- [ ] Hero section tampil dengan baik
- [ ] Jadwal hari ini tampil (jika ada)
- [ ] Section "Laboratory Management" tampil
- [ ] Head Laboran cards tampil dengan foto/inisial
- [ ] Recent activities tampil (max 5)
- [ ] Navbar berfungsi (Home, Schedule, Login)

### Schedule Page (/schedule)
- [ ] Semua jadwal lab tampil dalam tabel
- [ ] Data lengkap: Day, Time, Lab, Course, Lecturer, Assistant
- [ ] Sorting berdasarkan hari dan waktu

### API Endpoints (JSON)
- [ ] `/api/schedules` return JSON dengan data schedules
- [ ] `/api/head-laboran` return JSON dengan data head laboran
- [ ] `/api/lab-activities` return JSON dengan data activities
- [ ] Response format: `{"success": true, "data": [...]}`

---

## 👤 ASISTEN FEATURES

### Dashboard Asisten
- [ ] Setelah login, dashboard tampil
- [ ] Nama asisten tampil di header
- [ ] Tabel "My Problem Reports" tampil
- [ ] Data laporan sendiri muncul dengan status terbaru
- [ ] Sidebar navigation berfungsi

### Report Problem
- [ ] Form report problem dapat diakses
- [ ] Dropdown laboratories terisi data dari DB
- [ ] Dropdown problem type ada 4 pilihan (hardware, software, network, other)
- [ ] Form validation berfungsi (required fields)
- [ ] Submit berhasil masuk ke database `lab_problems`
- [ ] Status default: "reported"
- [ ] `reported_by` otomatis terisi dari session user_id
- [ ] **History otomatis ter-insert ke `problem_histories`**
- [ ] Redirect ke dashboard dengan flash message success

### My Reports
- [ ] Hanya laporan milik asisten yang login yang tampil
- [ ] Data lengkap: Lab, PC, Type, Description, Status, Date

---

## 🔧 KOORDINATOR FEATURES

### Dashboard Koordinator
- [ ] Dashboard tampil setelah login
- [ ] 4 Statistik cards tampil:
  - [ ] Total Problems
  - [ ] Reported
  - [ ] In Progress
  - [ ] Resolved
- [ ] Tabel "Pending Problems" tampil (status = reported)
- [ ] Sidebar navigation berfungsi

### View All Problems
- [ ] List semua problems tampil
- [ ] Filter by status berfungsi (All, Reported, In Progress, Resolved)
- [ ] Data lengkap: Lab, PC, Type, Reporter, Date, Status
- [ ] Button "View" untuk detail

### Problem Detail & Update Status
- [ ] Detail problem tampil lengkap
- [ ] Form update status ada
- [ ] Dropdown status: Reported, In Progress, Resolved
- [ ] Field note/catatan tersedia
- [ ] Submit update berhasil:
  - [ ] Status di `lab_problems` ter-update
  - [ ] **Entry baru masuk ke `problem_histories`**
  - [ ] Flash message success muncul
- [ ] History table tampil di bawah (urut terbaru)
- [ ] History menampilkan: Status, Note, Updated By, Date

---

## ⚙️ ADMIN FEATURES

### Dashboard Admin
- [ ] Dashboard tampil dengan statistik lengkap
- [ ] Stat cards tampil: Users, Labs, Problems, etc.
- [ ] Tabel "Recent Problems" tampil (10 terakhir)
- [ ] Sidebar navigation lengkap

### User Management (CRUD)
- [ ] **List Users**: Tabel users tampil dengan role
- [ ] **Create User**:
  - [ ] Form create user dapat diakses
  - [ ] Dropdown roles terisi data dari DB
  - [ ] Password minimal 6 karakter
  - [ ] Email validation berfungsi
  - [ ] Check duplicate email berfungsi
  - [ ] Password di-hash sebelum save
  - [ ] User baru masuk DB dengan status default "active"
- [ ] **Edit User**:
  - [ ] Form edit terisi data lama
  - [ ] Password optional (kosong = tidak berubah)
  - [ ] Update berhasil
- [ ] **Delete User**:
  - [ ] Admin tidak bisa delete akun sendiri
  - [ ] Confirmation dialog muncul
  - [ ] Delete berhasil

### Laboratory Management (CRUD)
- [ ] **List Labs**: Semua lab tampil
- [ ] **Create Lab**: Form berfungsi, data masuk DB
- [ ] **Edit Lab**: Data ter-update
- [ ] **Delete Lab**: Lab terhapus (jika tidak ada relasi)

### Lab Schedules (CRUD)
- [ ] **List Schedules**: Tampil dengan info lab
- [ ] **Create Schedule**:
  - [ ] Dropdown labs terisi
  - [ ] Dropdown days ada 7 hari
  - [ ] Time picker berfungsi
  - [ ] Data masuk DB dengan `created_at`
- [ ] **Edit Schedule**: Update berhasil
- [ ] **Delete Schedule**: Hapus berhasil

### Assistant Schedules / Piket (CRUD)
- [ ] **List**: Tampil dengan nama asisten
- [ ] **Create**:
  - [ ] Dropdown hanya asisten (role_id = 3) yang active
  - [ ] Status default: "scheduled"
  - [ ] Data masuk DB
- [ ] **Edit**: Update berhasil
- [ ] **Delete**: Hapus berhasil

### Head Laboran (CRUD)
- [ ] **List**: Tampil dengan user info
- [ ] **Create**:
  - [ ] Upload foto berfungsi
  - [ ] Foto tersimpan di `public/uploads/head-laboran/`
  - [ ] Check user_id unique (tidak boleh duplicate)
  - [ ] Data masuk DB
- [ ] **Edit**:
  - [ ] Form terisi data lama
  - [ ] Upload foto baru replace foto lama
  - [ ] Update berhasil
- [ ] **Delete**:
  - [ ] Foto lama terhapus dari server
  - [ ] Data terhapus dari DB

### Lab Activities (CRUD)
- [ ] **List**: Tampil dengan creator name
- [ ] **Create**:
  - [ ] Dropdown activity_type ada 5 pilihan
  - [ ] Date picker berfungsi
  - [ ] Status default: "draft"
  - [ ] `created_by` otomatis dari session
  - [ ] Data masuk DB
- [ ] **Edit**: Update berhasil
- [ ] **Delete**: Hapus berhasil

### Problems Management
- [ ] **List Problems**:
  - [ ] Statistik 4 cards tampil
  - [ ] Filter by status berfungsi
  - [ ] Semua problems tampil
- [ ] **View Detail**:
  - [ ] Info lengkap tampil
  - [ ] Form update status ada
  - [ ] History tampil di bawah
- [ ] **Update Status**:
  - [ ] Status ter-update di `lab_problems`
  - [ ] **History ter-insert ke `problem_histories`**
  - [ ] Note tersimpan
  - [ ] `updated_by` otomatis dari session
- [ ] **Delete Problem**:
  - [ ] Histories terkait terhapus dulu
  - [ ] Problem terhapus dari DB
  - [ ] Confirmation dialog muncul

---

## 🔒 SECURITY CHECKS

### Input Validation & Sanitization
- [ ] Semua input di-sanitize dengan `sanitize()` function
- [ ] Email validation berfungsi
- [ ] Password minimal 6 karakter
- [ ] Required fields validation berfungsi
- [ ] XSS prevention (htmlspecialchars)

### SQL Injection Prevention
- [ ] Semua query menggunakan PDO Prepared Statements
- [ ] Tidak ada SQL langsung di controller
- [ ] Parameter binding berfungsi
- [ ] Test dengan input: `' OR '1'='1` (harus gagal)

### Authentication & Session
- [ ] Session dimulai di `public/index.php`
- [ ] Login credentials di-verify dengan `password_verify()`
- [ ] Session variables ter-set: user_id, role, user_name
- [ ] Logout menghapus session dengan `session_destroy()`
- [ ] Middleware `requireLogin()` berfungsi
- [ ] Middleware `requireRole()` berfungsi

### File Upload Security
- [ ] Upload hanya accept image types (jpg, jpeg, png)
- [ ] File extension validation berfungsi
- [ ] File rename dengan `uniqid()` untuk prevent overwrite
- [ ] Folder uploads writable tapi tidak executable

---

## 🗃️ DATABASE INTEGRITY

### Foreign Keys
- [ ] Delete user dengan head_laboran → CASCADE
- [ ] Delete user dengan reports → CASCADE
- [ ] Delete lab dengan schedules → CASCADE
- [ ] Delete problem dengan histories → CASCADE
- [ ] Test: Coba delete user yang punya data → otomatis hapus data terkait

### Data Consistency
- [ ] Setiap problem punya minimal 1 history (saat create)
- [ ] Setiap update status problem masuk ke history
- [ ] `created_at` otomatis terisi saat insert
- [ ] `updated_at` otomatis terisi di histories
- [ ] Email unique di tabel users
- [ ] user_id unique di tabel head_laboran

### Indexing
- [ ] Index pada `users.email` ada
- [ ] Index pada `users.role_id` ada
- [ ] Index pada `lab_schedules.day` ada
- [ ] Index pada `lab_problems.status` ada
- [ ] Query performance bagus

---

## 🎨 UI/UX CHECKS

### Responsive Design
- [ ] Landing page responsive di mobile
- [ ] Admin panel readable di tablet
- [ ] Form layout tidak break di small screen
- [ ] Table scrollable horizontal jika terlalu lebar

### Navigation
- [ ] Public navbar ada di semua public pages
- [ ] Admin sidebar sticky/fixed
- [ ] Active menu highlighted
- [ ] Breadcrumb/back button tersedia

### Flash Messages
- [ ] Success message tampil (hijau)
- [ ] Error message tampil (merah)
- [ ] Flash message auto-hide setelah 5 detik
- [ ] Flash message muncul setelah CRUD operation

### Forms
- [ ] Required fields ada tanda *
- [ ] Placeholder text helpful
- [ ] Validation error message clear
- [ ] Cancel button redirect ke list page
- [ ] Submit button jelas (Create, Update, Delete)

### Tables
- [ ] Header row styled berbeda
- [ ] Odd/even row untuk readability
- [ ] Action buttons grouping (Edit, Delete)
- [ ] Empty state message jika tidak ada data
- [ ] Date/time formatted (bukan raw timestamp)

### Badges & Status
- [ ] Status "active" → hijau
- [ ] Status "inactive" → merah
- [ ] Status "reported" → kuning
- [ ] Status "in_progress" → biru
- [ ] Status "resolved" → hijau
- [ ] Badge readable dan consistent

---

## 📊 BUSINESS LOGIC

### Problem Report Flow
1. [ ] Asisten create report → status: "reported"
2. [ ] History entry created: status "reported"
3. [ ] Koordinator update → status: "in_progress"
4. [ ] History entry created: status "in_progress" + note
5. [ ] Koordinator resolve → status: "resolved"
6. [ ] History entry created: status "resolved" + note
7. [ ] Semua history tampil berurutan (terbaru di atas)

### User-Role Relationship
- [ ] Admin (role_id = 1) punya full access
- [ ] Koordinator (role_id = 2) limited access
- [ ] Asisten (role_id = 3) minimal access
- [ ] Role tidak bisa diubah sembarangan (only admin)

### Schedule Management
- [ ] Jadwal hari ini otomatis muncul di landing
- [ ] `getTodaySchedules()` return sesuai hari sistem
- [ ] Hari dalam bahasa Indonesia di public page
- [ ] Hari dalam bahasa Inggris di database

### Activity Publication
- [ ] Activity dengan status "draft" tidak tampil di public
- [ ] Activity dengan status "published" tampil di public
- [ ] Activity dengan status "cancelled" tidak tampil di public
- [ ] Sorting by date (upcoming first)

---

## 🧪 TESTING SCENARIOS

### Test 1: Fresh Install
```
1. Import database/schema.sql
2. Akses http://localhost/iclabs/public/
3. Landing page harus muncul tanpa error
4. Login sebagai admin → Dashboard harus tampil
```

### Test 2: CRUD Complete
```
1. Login sebagai admin
2. Create 1 user baru
3. Create 1 laboratory baru
4. Create 1 schedule baru
5. Edit schedule yang baru dibuat
6. Delete schedule
7. Semua operasi harus berhasil tanpa error
```

### Test 3: Problem Workflow
```
1. Login sebagai asisten1
2. Report problem di Lab 1
3. Logout
4. Login sebagai koordinator
5. Lihat problem yang dilaporkan
6. Update status ke "in_progress" dengan note
7. Check history → harus ada 2 entries
8. Update status ke "resolved"
9. Check history → harus ada 3 entries
```

### Test 4: Access Control
```
1. Login sebagai asisten
2. Coba akses /admin/dashboard → harus forbidden/redirect
3. Coba akses /koordinator/dashboard → harus forbidden/redirect
4. Akses /asisten/dashboard → harus berhasil
```

### Test 5: Security
```
1. Coba SQL injection di form login: email = ' OR '1'='1
2. Harus gagal login (prepared statement protection)
3. Coba XSS di form report: description = <script>alert('XSS')</script>
4. Harus ter-sanitize (tampil sebagai text, tidak execute)
```

---

## 📈 PERFORMANCE CHECKS

- [ ] Page load < 2 detik (local)
- [ ] Database query < 100ms
- [ ] Image upload < 5MB file size limit
- [ ] No N+1 query problem (check di Models)
- [ ] Index digunakan untuk query WHERE/ORDER BY

---

## 📚 DOCUMENTATION

- [ ] README.md lengkap dengan:
  - [ ] Overview sistem
  - [ ] Teknologi yang digunakan
  - [ ] Struktur folder
  - [ ] Database schema
  - [ ] Role & access control
  - [ ] Route map
  - [ ] Installation guide
  - [ ] Default credentials
  - [ ] Security features
  - [ ] Troubleshooting
- [ ] INSTALL.md ada dengan step-by-step
- [ ] SQL schema.sql ter-dokumentasi dengan comments
- [ ] Inline code comments di fungsi-fungsi penting

---

## 🎯 FINAL CHECKS

### Before Demo/Presentation
- [ ] Database reset dengan fresh data
- [ ] Test login semua role
- [ ] Screenshot semua halaman penting
- [ ] Prepare demo flow/scenario
- [ ] Check tidak ada error di console browser
- [ ] Check tidak ada error di Apache error.log

### Code Quality
- [ ] Tidak ada hardcoded credentials di code
- [ ] Tidak ada `var_dump()` atau `dd()` di production code
- [ ] Consistent naming convention (camelCase, snake_case)
- [ ] Indentation consistent (4 spaces atau tab)
- [ ] No trailing whitespaces

### Deployment Ready
- [ ] .gitignore configured (exclude uploads/, config/)
- [ ] Database backup tersedia
- [ ] Environment variables ready (jika perlu)
- [ ] Error reporting OFF di production (php.ini)
- [ ] HTTPS ready (jika deploy ke production)

---

## ✅ SIGN-OFF

**Developer:** _________________
**Date:** _________________
**Status:** [ ] READY FOR DEMO  [ ] NEED FIXES

**Notes:**
_______________________________________
_______________________________________
_______________________________________

---

**SISTEM ICLABS SIAP DIGUNAKAN! 🎉**
