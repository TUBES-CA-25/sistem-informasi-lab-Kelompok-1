<?php
$uri = $_SERVER['REQUEST_URI'] ?? '';

// Helper function untuk menentukan class active
function isSidebarActive($uri, $path)
{
    // Cek apakah URI saat ini mengandung path menu
    return strpos($uri, $path) !== false 
        ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/20 font-medium' 
        : 'text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200';
}
?>

<style>
    .sidebar-scroll::-webkit-scrollbar { width: 5px; }
    .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
    .sidebar-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
    .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: #475569; }
</style>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-slate-900 border-r border-slate-800 flex flex-col shadow-2xl" aria-label="Sidebar">
    
    <div class="h-16 flex items-center px-6 border-b border-slate-800 bg-slate-900 shrink-0">
        <a href="<?= url('/admin/dashboard') ?>" class="flex items-center gap-3 group">
            <div class="relative flex items-center justify-center w-8 h-8 rounded-lg bg-gradient-to-br from-sky-500 to-blue-600 text-white font-bold shadow-lg shadow-sky-500/20 group-hover:shadow-sky-500/40 transition-all duration-300">
                IC
                <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-emerald-400 rounded-full border-2 border-slate-900"></span>
            </div>
            <span class="self-center text-xl font-bold whitespace-nowrap text-white tracking-wide group-hover:text-sky-400 transition-colors">
                ICLABS
            </span>
        </a>
    </div>

    <div class="flex-1 px-3 py-4 overflow-y-auto sidebar-scroll">
        
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <ul class="space-y-1">
            <li class="mb-6">
                <a href="<?= url('/') ?>" target="_blank" class="flex items-center p-3 rounded-xl text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 hover:bg-emerald-500/20 transition-all group">
                    <i class="bi bi-rocket-takeoff-fill text-lg group-hover:translate-x-1 transition-transform"></i>
                    <span class="ms-3 font-semibold text-sm">Lihat Website Utama</span>
                </a>
            </li>

            <li class="px-3 mt-2 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Main Menu</li>
            <li>
                <a href="<?= url('/admin/dashboard') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/dashboard') ?>">
                    <i class="bi bi-grid-1x2-fill text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Dashboard Admin</span>
                </a>
            </li>

            <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Akademik</li>
            <li>
                <a href="<?= url('/admin/schedules') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/schedules') ?>">
                    <i class="bi bi-calendar-week-fill text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Jadwal Praktikum</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/assistant-schedules') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/assistant-schedules') ?>">
                    <i class="bi bi-clock-history text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Jadwal Piket</span>
                </a>
            </li>

            <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Manajemen Lab</li>
            <li>
                <a href="<?= url('/admin/head-laboran') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/head-laboran') ?>">
                    <i class="bi bi-person-badge-fill text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Staff & Presence</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/laboratories') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/laboratories') ?>">
                    <i class="bi bi-pc-display text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Data Lab</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/activities') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/activities') ?>">
                    <i class="bi bi-postcard-heart-fill text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Kegiatan & Berita</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/problems') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/problems') ?>">
                    <i class="bi bi-exclamation-octagon-fill text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Laporan Masalah</span>
                </a>
            </li>

            <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">System</li>
            <li>
                <a href="<?= url('/admin/users') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/users') ?>">
                    <i class="bi bi-people-fill text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">User Management</span>
                </a>
            </li>
        </ul>

        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'koordinator'): ?>
        <ul class="space-y-1">
            <li class="px-3 mt-2 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Main Menu</li>
            <li>
                <a href="<?= url('/admin/dashboard') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/dashboard') ?>">
                    <i class="bi bi-grid-1x2-fill text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Dashboard</span>
                </a>
            </li>

            <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Akademik</li>
            <li>
                <a href="<?= url('/admin/schedules') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/schedules') ?>">
                    <i class="bi bi-calendar-week-fill text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Jadwal Praktikum</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/assistant-schedules') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/assistant-schedules') ?>">
                    <i class="bi bi-clock-history text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Jadwal Piket</span>
                </a>
            </li>

            <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Monitoring</li>
            <li>
                <a href="<?= url('/admin/head-laboran') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/head-laboran') ?>">
                    <i class="bi bi-person-badge-fill text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Staff & Presence</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/laboratories') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/laboratories') ?>">
                    <i class="bi bi-pc-display text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Data Lab</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/activities') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/activities') ?>">
                    <i class="bi bi-newspaper text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Kegiatan</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/problems') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/problems') ?>">
                    <i class="bi bi-exclamation-triangle-fill text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Laporan Masalah</span>
                </a>
            </li>
        </ul>

        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'asisten'): ?>
        <ul class="space-y-1">
            <li class="px-3 mt-2 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Main Menu</li>
            <li>
                <a href="<?= url('/admin/dashboard') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/dashboard') ?>">
                    <i class="bi bi-grid-1x2-fill text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Dashboard</span>
                </a>
            </li>

            <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Jadwal</li>
            <li>
                <a href="<?= url('/admin/schedules') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/schedules') ?>">
                    <i class="bi bi-calendar-check-fill text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Jadwal Praktikum</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/assistant-schedules') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/assistant-schedules') ?>">
                    <i class="bi bi-clock-fill text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Jadwal Piket Saya</span>
                </a>
            </li>

            <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Laporan</li>
            <li>
                <a href="<?= url('/admin/activities') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/activities') ?>">
                    <i class="bi bi-pencil-square text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Input Kegiatan</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/problems') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/problems') ?>">
                    <i class="bi bi-tools text-lg opacity-80"></i>
                    <span class="ms-3 text-sm">Lapor Kerusakan</span>
                </a>
            </li>
        </ul>
        <?php endif; ?>

    </div>

    <div class="border-t border-slate-800 p-4 bg-slate-900">
        <a href="<?= url('/logout') ?>" class="flex items-center gap-3 p-3 rounded-xl hover:bg-rose-500/10 text-slate-400 hover:text-rose-400 transition-all group">
            <i class="bi bi-box-arrow-left text-xl group-hover:-translate-x-1 transition-transform"></i>
            <div class="flex-1 text-left">
                <span class="block text-sm font-medium">Log Out</span>
            </div>
        </a>
    </div>

</aside>