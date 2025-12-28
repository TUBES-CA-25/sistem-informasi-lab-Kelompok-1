# ICLABS - Laboratory Information System

## 📋 Overview
ICLABS adalah sistem informasi laboratorium berbasis web yang dibangun dengan PHP Native (tanpa framework) untuk mengelola jadwal, kegiatan, dan permasalahan laboratorium komputer.

## 🛠️ Teknologi
- **Backend**: PHP 8.x Native (MVC Pattern)
- **Database**: MySQL dengan PDO
- **Frontend**: HTML5, CSS3, JavaScript
- **Authentication**: Session-based
- **Security**: Password hashing (bcrypt), Prepared Statements, Input Sanitization

## 📁 Struktur Folder
```
iclabs/
├── app/
│   ├── config/
│   │   ├── database.php       # Database configuration & PDO connection
│   │   └── routes.php         # All route definitions
│   ├── core/
│   │   ├── Router.php         # Request routing & dispatching
│   │   ├── Controller.php     # Base controller class
│   │   └── Model.php          # Base model class
│   ├── helpers/
│   │   └── functions.php      # Helper functions (auth, sanitize, etc.)
│   ├── models/
│   │   ├── RoleModel.php
│   │   ├── UserModel.php
│   │   ├── LaboratoryModel.php
│   │   ├── LabScheduleModel.php
│   │   ├── AssistantScheduleModel.php
│   │   ├── HeadLaboranModel.php
│   │   ├── LabActivityModel.php
│   │   ├── LabProblemModel.php
│   │   └── ProblemHistoryModel.php
│   ├── controllers/
│   │   ├── AuthController.php
│   │   ├── LandingController.php
│   │   ├── ApiController.php
│   │   ├── AsistenController.php
│   │   ├── KoordinatorController.php
│   │   └── AdminController.php
│   └── views/
│       ├── layouts/
│       ├── landing/
│       ├── auth/
│       ├── admin/
│       ├── asisten/
│       └── koordinator/
├── public/
│   ├── index.php              # Front controller
│   ├── .htaccess              # URL rewriting
│   └── assets/
│       ├── css/
│       ├── js/
│       └── uploads/
└── database/
    └── schema.sql             # Database schema & seed data
```

## 🗄️ Database Schema
### 9 Tabel Utama:
1. **roles** - Role definitions (admin, koordinator, asisten)
2. **users** - User accounts dengan relasi ke role
3. **laboratories** - Data laboratorium
4. **lab_schedules** - Jadwal praktikum per lab
5. **assistant_schedules** - Jadwal piket asisten
6. **head_laboran** - Data kepala laboran
7. **lab_activities** - Kegiatan laboratorium
8. **lab_problems** - Laporan permasalahan lab
9. **problem_histories** - Riwayat update status masalah

## 👥 Role & Access Control

### PUBLIC (Tanpa Login):
- ✅ Landing page
- ✅ Lihat jadwal laboratorium
- ✅ Lihat head laboran (status & lokasi)
- ✅ Lihat kegiatan laboratorium

### ASISTEN (Login Required):
- ✅ Dashboard pribadi
- ✅ Melaporkan permasalahan lab
- ✅ Lihat riwayat laporan sendiri

### KOORDINATOR (Login Required):
- ✅ Dashboard dengan statistik
- ✅ Lihat semua laporan masalah
- ✅ Update status masalah (reported → in_progress → resolved)
- ✅ Menambah catatan pada update

### ADMIN (Full Access):
- ✅ Dashboard lengkap dengan statistik
- ✅ **User Management** - CRUD users
- ✅ **Laboratory Management** - CRUD laboratories
- ✅ **Lab Schedules** - CRUD jadwal praktikum
- ✅ **Assistant Schedules** - CRUD jadwal piket
- ✅ **Head Laboran** - CRUD kepala laboran (+ upload foto)
- ✅ **Lab Activities** - CRUD kegiatan lab
- ✅ **Problems Management** - View, update status, delete problems

## 🚀 Instalasi

### 1. Prerequisites
- XAMPP/WAMP (PHP 8.x + MySQL)
- Web browser modern

### 2. Setup Database
```bash
# Buka phpMyAdmin atau MySQL CLI
# Import file database
mysql -u root -p < database/schema.sql
```

Atau manual:
1. Buka phpMyAdmin → http://localhost/phpmyadmin
2. Import file: `database/schema.sql`
3. Database `iclabs` akan otomatis dibuat dengan data sample

### 3. Konfigurasi
Edit `app/config/database.php` jika perlu:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'iclabs');
define('DB_USER', 'root');
define('DB_PASS', '');
```

### 4. URL Rewrite (Apache)
Pastikan `mod_rewrite` aktif di Apache:
- XAMPP: Sudah aktif by default
- File `.htaccess` sudah tersedia di folder `public/`

### 5. Akses Aplikasi
```
http://localhost/iclabs/public/
```

## 🔑 Default Login Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@iclabs.com | password123 |
| Koordinator | koordinator@iclabs.com | password123 |
| Asisten 1 | asisten1@iclabs.com | password123 |
| Asisten 2 | asisten2@iclabs.com | password123 |
| Asisten 3 | asisten3@iclabs.com | password123 |

## 📍 Route Map

### Public Routes
- `GET /` - Landing page
- `GET /schedule` - Jadwal laboratorium
- `GET /login` - Login form

### Authentication
- `POST /auth/login` - Process login
- `GET /logout` - Logout

### API (JSON)
- `GET /api/schedules` - Get schedules (public)
- `GET /api/head-laboran` - Get head laboran (public)
- `GET /api/lab-activities` - Get activities (public)

### Asisten Routes
- `GET /asisten/dashboard`
- `GET /asisten/report-problem`
- `POST /asisten/report-problem`
- `GET /asisten/my-reports`

### Koordinator Routes
- `GET /koordinator/dashboard`
- `GET /koordinator/problems`
- `GET /koordinator/problems/:id`
- `POST /koordinator/problems/:id/update-status`

### Admin Routes (CRUD Complete)
- Dashboard: `GET /admin/dashboard`
- Users: `GET /admin/users` + create/edit/delete
- Laboratories: `GET /admin/laboratories` + CRUD
- Schedules: `GET /admin/schedules` + CRUD
- Assistant Schedules: `GET /admin/assistant-schedules` + CRUD
- Head Laboran: `GET /admin/head-laboran` + CRUD
- Activities: `GET /admin/activities` + CRUD
- Problems: `GET /admin/problems` + view/update/delete

## 🔒 Security Features
- ✅ Password hashing menggunakan bcrypt
- ✅ PDO Prepared Statements (SQL Injection prevention)
- ✅ Input sanitization & validation
- ✅ Session-based authentication
- ✅ Role-based access control (RBAC)
- ✅ CSRF protection ready (token helpers available)

## 📝 Business Rules
1. **User Management**
   - Admin tidak bisa menghapus akun sendiri
   - Email harus unique
   - Password minimal 6 karakter

2. **Head Laboran**
   - Satu user hanya bisa menjadi 1 head laboran
   - Support upload foto

3. **Lab Problems**
   - Asisten hanya bisa create report
   - Koordinator & Admin bisa update status
   - Admin bisa delete
   - **Setiap update status WAJIB masuk ke problem_histories**

4. **Lab Activities**
   - Status: draft/published/cancelled
   - Public hanya melihat yang published

## 🎨 UI/UX
- **Public Pages**: Navbar + Hero section + Cards
- **Admin Panel**: Sidebar navigation + Top navbar + Content area
- **Responsive**: Grid layout dengan auto-fit
- **Color Scheme**: 
  - Primary: #2563eb (Blue)
  - Success: #10b981 (Green)
  - Warning: #f59e0b (Orange)
  - Danger: #ef4444 (Red)

## 🧪 Testing Checklist

### Authentication
- [ ] Login dengan email & password yang benar
- [ ] Login dengan credential salah (harus gagal)
- [ ] Logout berhasil
- [ ] Redirect ke dashboard sesuai role setelah login

### Public Access
- [ ] Landing page dapat diakses tanpa login
- [ ] Schedule page dapat diakses tanpa login
- [ ] Head laboran terlihat di landing
- [ ] Activities terlihat di landing

### Asisten Features
- [ ] Dashboard asisten muncul setelah login
- [ ] Form report problem berfungsi
- [ ] Laporan masuk ke database
- [ ] Riwayat laporan sendiri muncul

### Koordinator Features
- [ ] Dashboard dengan statistik tampil
- [ ] List semua problems tampil
- [ ] Detail problem dapat dibuka
- [ ] Update status problem berhasil
- [ ] History tercatat saat update

### Admin Features
- [ ] Dashboard dengan statistik lengkap
- [ ] CRUD Users berfungsi
- [ ] CRUD Laboratories berfungsi
- [ ] CRUD Lab Schedules berfungsi
- [ ] CRUD Assistant Schedules berfungsi
- [ ] CRUD Head Laboran berfungsi (+ upload foto)
- [ ] CRUD Activities berfungsi
- [ ] View & update problems berfungsi
- [ ] Delete problem berfungsi

### Data Integrity
- [ ] Foreign key constraints berfungsi
- [ ] Tidak bisa delete lab yang punya schedule
- [ ] Tidak bisa delete user yang punya data relasi
- [ ] History problem tersimpan setiap update

## 🐛 Troubleshooting

### Error: "Database connection failed"
- Pastikan MySQL service berjalan
- Cek credential di `config/database.php`
- Pastikan database `iclabs` sudah dibuat

### Error: "404 Not Found" pada semua route
- Pastikan mod_rewrite Apache aktif
- Cek file `.htaccess` ada di folder `public/`
- Pastikan URL menggunakan `/public/`

### Error: "Call to undefined function"
- Pastikan semua file di `app/helpers/` di-load
- Cek `public/index.php` sudah require semua files

### Upload foto tidak berfungsi
- Pastikan folder `public/uploads/` writable (chmod 777)
- Cek max upload size di php.ini

## 📞 Support
Jika ada pertanyaan atau bug, silakan hubungi administrator.

## 📄 License
Educational Purpose - ICLABS Project

---
**Developed by**: Senior Full-Stack Engineer  
**Date**: December 2025  
**Version**: 1.0.0
