<?php
$uri = $_SERVER['REQUEST_URI'] ?? '';
function isSidebarActive($uri, $path)
{
    return strpos($uri, $path) !== false ? 'bg-sky-600 text-white shadow-md' : 'text-slate-400 hover:bg-slate-800 hover:text-white';
}
?>

<aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-slate-900 border-r border-slate-800 flex flex-col" aria-label="Sidebar">

    <div class="h-16 flex items-center px-6 border-b border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-lg shadow-sky-500/30">
                IC
            </div>
            <span class="self-center text-xl font-bold whitespace-nowrap text-white tracking-wide">ICLABS</span>
        </div>
    </div>

    <?php if ($_SESSION['role'] == 'admin'): ?>
    <div class="flex-1 px-3 py-4 overflow-y-auto">
        <ul class="space-y-1 font-medium">

            <li class="mb-4">
                <a href="<?= url('/') ?>" class="flex items-center p-3 rounded-lg text-emerald-400 bg-emerald-900/20 border border-emerald-900/50 hover:bg-emerald-900/40 transition-all group">
                    <i class="bi bi-house-door-fill text-lg group-hover:scale-110 transition-transform"></i>
                    <span class="ms-3 font-semibold">Ke Halaman Depan</span>
                </a>
            </li>

            <li class="px-3 pt-2 pb-1 text-xs font-bold text-slate-500 uppercase tracking-wider">Menu Utama</li>

            <li>
                <a href="<?= url('/admin/dashboard') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/dashboard') ?>">
                    <i class="bi bi-speedometer2 text-lg"></i>
                    <span class="ms-3">Dashboard Admin</span>
                </a>
            </li>

            <li class="px-3 pt-4 pb-1 text-xs font-bold text-slate-500 uppercase tracking-wider">Akademik</li>

            <li>
                <a href="<?= url('/admin/schedules') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/schedules') ?>">
                    <i class="bi bi-calendar-week text-lg"></i>
                    <span class="ms-3">Jadwal Praktikum</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/assistant-schedules') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/assistant-schedules') ?>">
                    <i class="bi bi-clock-history text-lg"></i>
                    <span class="ms-3">Jadwal Piket</span>
                </a>
            </li>

            <li class="px-3 pt-4 pb-1 text-xs font-bold text-slate-500 uppercase tracking-wider">Manajemen Lab</li>

            <li>
                <a href="<?= url('/admin/head-laboran') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/head-laboran') ?>">
                    <i class="bi bi-person-badge text-lg"></i>
                    <span class="ms-3">Presence / KaLab</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/laboratories') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/laboratories') ?>">
                    <i class="bi bi-pc-display text-lg"></i>
                    <span class="ms-3">Data Lab</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/activities') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/activities') ?>">
                    <i class="bi bi-newspaper text-lg"></i>
                    <span class="ms-3">Kegiatan / Blog</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/problems') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/problems') ?>">
                    <i class="bi bi-exclamation-triangle text-lg"></i>
                    <span class="ms-3">Laporan Masalah</span>
                </a>
            </li>

            <li class="px-3 pt-4 pb-1 text-xs font-bold text-slate-500 uppercase tracking-wider">System</li>

            <li>
                <a href="<?= url('/admin/users') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/users') ?>">
                    <i class="bi bi-people text-lg"></i>
                    <span class="ms-3">User Management</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/logout') ?>" class="flex items-center p-2 text-rose-400 rounded-lg hover:bg-rose-900/20 hover:text-rose-300 group transition-all duration-200">
                    <i class="bi bi-box-arrow-right text-lg"></i>
                    <span class="ms-3">Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <?php elseif ($_SESSION['role'] == 'koordinator'): ?>
    <div class="flex-1 px-3 py-4 overflow-y-auto">
        <ul class="space-y-1 font-medium">

            <li class="px-3 pt-2 pb-1 text-xs font-bold text-slate-500 uppercase tracking-wider">Menu Utama</li>

            <li>
                <a href="<?= url('/admin/dashboard') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/dashboard') ?>">
                    <i class="bi bi-speedometer2 text-lg"></i>
                    <span class="ms-3">Dashboard Admin</span>
                </a>
            </li>

            <li class="px-3 pt-4 pb-1 text-xs font-bold text-slate-500 uppercase tracking-wider">Akademik</li>

            <li>
                <a href="<?= url('/admin/schedules') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/schedules') ?>">
                    <i class="bi bi-calendar-week text-lg"></i>
                    <span class="ms-3">Jadwal Praktikum</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/assistant-schedules') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/assistant-schedules') ?>">
                    <i class="bi bi-clock-history text-lg"></i>
                    <span class="ms-3">Jadwal Piket</span>
                </a>
            </li>

            <li class="px-3 pt-4 pb-1 text-xs font-bold text-slate-500 uppercase tracking-wider">Manajemen Lab</li>

            <li>
                <a href="<?= url('/admin/head-laboran') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/head-laboran') ?>">
                    <i class="bi bi-person-badge text-lg"></i>
                    <span class="ms-3">Presence / KaLab</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/laboratories') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/laboratories') ?>">
                    <i class="bi bi-pc-display text-lg"></i>
                    <span class="ms-3">Data Lab</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/activities') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/activities') ?>">
                    <i class="bi bi-newspaper text-lg"></i>
                    <span class="ms-3">Kegiatan / Blog</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/problems') ?>" class="flex items-center p-2 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/problems') ?>">
                    <i class="bi bi-exclamation-triangle text-lg"></i>
                    <span class="ms-3">Laporan Masalah</span>
                </a>
            </li>

            <li class="px-3 pt-4 pb-1 text-xs font-bold text-slate-500 uppercase tracking-wider">System</li>

            <li>
                <a href="<?= url('/logout') ?>" class="flex items-center p-2 text-rose-400 rounded-lg hover:bg-rose-900/20 hover:text-rose-300 group transition-all duration-200">
                    <i class="bi bi-box-arrow-right text-lg"></i>
                    <span class="ms-3">Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <?php elseif ($_SESSION['role'] == 'asisten'): ?>

    <?php endif; ?>
</aside>