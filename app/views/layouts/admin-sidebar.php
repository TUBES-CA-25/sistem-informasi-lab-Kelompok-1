<?php
$uri = $_SERVER['REQUEST_URI'] ?? '';
function isSidebarActive($uri, $path)
{
    return strpos($uri, $path) !== false ? 'bg-sky-600 text-white shadow-lg' : 'text-slate-400 hover:bg-slate-800 hover:text-white';
}
?>

<aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-slate-900 border-r border-slate-800" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto">

        <a href="#" class="flex items-center ps-2.5 mb-8 mt-2">
            <div class="w-8 h-8 rounded bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center text-white font-bold mr-3">
                IC
            </div>
            <span class="self-center text-xl font-bold whitespace-nowrap text-white tracking-wide">ICLABS ADMIN</span>
        </a>

        <ul class="space-y-2 font-medium">

            <li>
                <a href="<?= url('/admin/dashboard') ?>" class="flex items-center p-3 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/dashboard') ?>">
                    <i class="bi bi-speedometer2 text-lg"></i>
                    <span class="ms-3">Dashboard</span>
                </a>
            </li>

            <li class="pt-4 pb-2 px-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Akademik & Jadwal</li>

            <li>
                <a href="<?= url('/admin/schedules') ?>" class="flex items-center p-3 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/schedules') ?>">
                    <i class="bi bi-calendar-week text-lg"></i>
                    <span class="ms-3">Jadwal Praktikum</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/assistant-schedules') ?>" class="flex items-center p-3 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/assistant-schedules') ?>">
                    <i class="bi bi-clock-history text-lg"></i>
                    <span class="ms-3">Jadwal Piket</span>
                </a>
            </li>

            <li class="pt-4 pb-2 px-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Manajemen Lab</li>

            <li>
                <a href="<?= url('/admin/head-laboran') ?>" class="flex items-center p-3 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/head-laboran') ?>">
                    <i class="bi bi-person-badge text-lg"></i>
                    <span class="ms-3">KaLab & Staff</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/laboratories') ?>" class="flex items-center p-3 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/laboratories') ?>">
                    <i class="bi bi-pc-display text-lg"></i>
                    <span class="ms-3">Data Lab</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/activities') ?>" class="flex items-center p-3 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/activities') ?>">
                    <i class="bi bi-newspaper text-lg"></i>
                    <span class="ms-3">Kegiatan / Blog</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/admin/problems') ?>" class="flex items-center p-3 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/problems') ?>">
                    <i class="bi bi-exclamation-triangle text-lg"></i>
                    <span class="ms-3">Laporan Masalah</span>
                </a>
            </li>

            <li class="pt-4 pb-2 px-3 text-xs font-bold text-slate-500 uppercase tracking-wider">System</li>

            <li>
                <a href="<?= url('/admin/users') ?>" class="flex items-center p-3 rounded-lg group transition-all duration-200 <?= isSidebarActive($uri, '/admin/users') ?>">
                    <i class="bi bi-people text-lg"></i>
                    <span class="ms-3">User Management</span>
                </a>
            </li>
            <li>
                <a href="<?= url('/logout') ?>" class="flex items-center p-3 text-rose-400 rounded-lg hover:bg-rose-900/20 hover:text-rose-300 group transition-all duration-200">
                    <i class="bi bi-box-arrow-right text-lg"></i>
                    <span class="ms-3">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>