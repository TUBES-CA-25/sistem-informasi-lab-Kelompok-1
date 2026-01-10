<?php
$uri = $_SERVER['REQUEST_URI'] ?? '';

// Helper function untuk menentukan class active
function isSidebarActive($uri, $path)
{
    return strpos($uri, $path) !== false
        ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/20 font-medium border-l-4 border-white'
        : 'text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200';
}
?>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-slate-900 border-r border-slate-800 flex flex-col shadow-2xl" aria-label="Sidebar">

    <div class="h-16 flex items-center px-6 border-b border-slate-800 bg-slate-900 shrink-0">
        <a href="#" class="flex items-center gap-3 group">
            <div class="w-8 h-8 rounded bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-lg shadow-sky-500/30">
                IC
            </div>
            <span class="self-center text-xl font-bold whitespace-nowrap text-white tracking-wide">ADMIN</span>
        </a>
    </div>

    <div class="flex-1 px-3 py-4 overflow-y-auto sidebar-scroll">
        <ul class="space-y-1">

            <li class="mb-6">
                <a href="<?= url('/') ?>" class="flex items-center p-2.5 rounded-xl text-emerald-400 bg-emerald-900/10 border border-emerald-900/30 hover:bg-emerald-900/30 transition-all group">
                    <i class="bi bi-house-door text-xl opacity-80 group-hover:scale-110 transition-transform"></i>
                    <span class="ms-3 text-sm font-semibold">Ke Halaman Depan</span>
                </a>
            </li>

            <li>
                <a href="<?= url('/admin/dashboard') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/dashboard') ?>">
                    <i class="bi bi-speedometer2 text-xl opacity-80"></i>
                    <span class="ms-3 text-sm">Dashboard</span>
                </a>
            </li>

            <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Akademik</li>
            <li>
                <a href="<?= url('/admin/schedules') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/schedules') ?>">
                    <i class="bi bi-calendar-week text-xl opacity-80"></i>
                    <span class="ms-3 text-sm">Jadwal Praktikum</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/assistant-schedules') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/assistant-schedules') ?>">
                    <i class="bi bi-clock-history text-xl opacity-80"></i>
                    <span class="ms-3 text-sm">Jadwal Piket</span>
                </a>
            </li>

            <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Manajemen Lab</li>
            <li>
                <a href="<?= url('/admin/head-laboran') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/head-laboran') ?>">
                    <i class="bi bi-person-badge text-xl opacity-80"></i>
                    <span class="ms-3 text-sm">Presence / KaLab</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/laboratories') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/laboratories') ?>">
                    <i class="bi bi-pc-display text-xl opacity-80"></i>
                    <span class="ms-3 text-sm">Data Laboratorium</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/activities') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/activities') ?>">
                    <i class="bi bi-newspaper text-xl opacity-80"></i>
                    <span class="ms-3 text-sm">Kegiatan / Blog</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/problems') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/problems') ?>">
                    <i class="bi bi-exclamation-triangle text-xl opacity-80"></i>
                    <span class="ms-3 text-sm">Laporan Masalah</span>
                </a>
            </li>

            <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">System</li>
            <li>
                <a href="<?= url('/admin/users') ?>" class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/users') ?>">
                    <i class="bi bi-people text-xl opacity-80"></i>
                    <span class="ms-3 text-sm">User Management</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="border-t border-slate-800 p-4 bg-slate-900 shrink-0">
        <div class="flex items-center gap-3 mb-3 px-2">
            <div class="w-9 h-9 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold text-white border border-slate-600">
                <?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?>
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-medium text-white truncate"><?= e($_SESSION['user_name'] ?? 'Admin') ?></p>
                <p class="text-[10px] text-sky-400 uppercase tracking-wide font-bold">Administrator</p>
            </div>
        </div>
        <a href="<?= url('/logout') ?>" class="flex items-center justify-center w-full p-2.5 text-xs font-bold text-rose-300 bg-rose-950/30 border border-rose-900/50 rounded-lg hover:bg-rose-900/50 hover:text-white transition-colors">
            <i class="bi bi-box-arrow-right me-2 text-sm"></i> LOGOUT
        </a>
    </div>

</aside>