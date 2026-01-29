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
│   │   ├── ProblemHistoryModel.php
│   │   └── SettingsModel.php
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
    └── iclabs.sql             # Database schema & seed data
```

## 🗄️ Database Schema
### 14 Tabel:
1. **roles** - Role definitions (admin, koordinator, asisten)
2. **users** - User accounts dengan relasi ke role
3. **laboratories** - Data laboratorium
4. **assistant_schedules** - Jadwal piket asisten (tanggal, shift, user_id)
5. **schedule_sessions** - Jadwal sesi kuliah praktikum (jam, hari, lab_id)
6. **course_plans** - Rencana Pembelajaran Semester (RPS) per lab
7. **head_laboran** - Data kepala laboran (status, lokasi, phone)
8. **lab_activities** - Kegiatan laboratorium (title, date, status)
9. **lab_problems** - Laporan permasalahan lab (reporter, status)
10. **problem_histories** - Riwayat update status masalah
11. **lab_photos** - Foto dokumentasi laboratorium
12. **job_presets** - Template pekerjaan piket (putra/putri)
13. **app_settings** - Pengaturan aplikasi (job_putra, job_putri)
14. **lab_schedules_old** - Tabel lama jadwal (deprecated)

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
# Via MySQL CLI (port 3310)
mysql -u root -P 3310 < database/iclabs.sql
```

Atau manual:
1. Buka phpMyAdmin → http://localhost/phpmyadmin
2. Buat database baru: `iclabs`
3. Import file: `database/iclabs.sql`
4. Database akan berisi struktur tabel + data sample

### 3. Konfigurasi
Edit `app/config/database.php` jika perlu:
```php
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3310');        // Port MySQL (default 3310)
define('DB_NAME', 'iclabs');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
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
   - Tracking status (active/inactive) dan lokasi real-time
   - Field: phone, position, location, return_time, time_in

3. **Lab Problems**
   - Asisten hanya bisa create report
   - Koordinator & Admin bisa update status
   - Admin bisa delete
   - **Setiap update status WAJIB masuk ke problem_histories**

4. **Lab Activities**
   - Status: draft/published/cancelled
   - Public hanya melihat yang published

## 📞 Support
Jika ada pertanyaan atau bug, silakan hubungi administrator.

## 📄 License
Educational Purpose - ICLABS Project

---
**Developed by**: ICLABS Development Team
**Last Updated**: January 2026  
**Version**: 1.2.0  
**Database**: MariaDB 10.4.32 (Port 3310)  
**PHP Version**: 8.x
