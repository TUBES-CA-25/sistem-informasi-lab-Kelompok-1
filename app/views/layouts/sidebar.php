<?php
$uri = $_SERVER['REQUEST_URI'] ?? '';

// Helper function sederhana untuk cek menu aktif
function isSidebarActive($uri, $path)
{
    return strpos($uri, $path) !== false
        ? 'bg-sky-600 text-white shadow-md shadow-sky-500/20 font-semibold'
        : 'text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200';
}
?>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-slate-900 border-r border-slate-800 flex flex-col shadow-xl"
    aria-label="Sidebar">

    <div class="h-20 flex items-center px-6 border-b border-slate-800 bg-slate-900 shrink-0">
        <a href="<?= url('/admin/dashboard') ?>" class="flex items-center gap-3 group">
            <img src="<?= url('/assets/images/logo-iclabs.png') ?>" alt="Logo ICLABS"
                class="h-10 w-auto object-contain">

            <div class="flex flex-col">
                <span class="text-lg font-bold text-white tracking-wide leading-none">ICLABS</span>
                <span class="text-[10px] font-medium text-slate-500 uppercase tracking-widest mt-1">Admin Panel</span>
            </div>
        </a>
    </div>

    <div class="flex-1 px-3 py-6 overflow-y-auto custom-scrollbar">
        <ul class="space-y-1">

            <li>
                <a href="<?= url('/admin/dashboard') ?>"
                    class="flex items-center p-3 rounded-lg <?= isSidebarActive($uri, '/admin/dashboard') ?>">
                    <i class="bi bi-grid-fill text-lg w-6 text-center"></i>
                    <span class="ms-3 text-sm">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="<?= url('/admin/users') ?>"
                    class="flex items-center p-3 rounded-lg <?= isSidebarActive($uri, '/admin/users') ?>">
                    <i class="bi bi-people-fill text-lg w-6 text-center"></i>
                    <span class="ms-3 text-sm">Pengguna (Users)</span>
                </a>
            </li>

            <li>
                <a href="<?= url('/admin/laboratories') ?>"
                    class="flex items-center p-3 rounded-lg <?= isSidebarActive($uri, '/admin/laboratories') ?>">
                    <i class="bi bi-pc-display-horizontal text-lg w-6 text-center"></i>
                    <span class="ms-3 text-sm">Laboratorium</span>
                </a>
            </li>

            <li>
                <a href="<?= url('/admin/head-laboran') ?>"
                    class="flex items-center p-3 rounded-lg <?= isSidebarActive($uri, '/admin/head-laboran') ?>">
                    <i class="bi bi-person-badge-fill text-lg w-6 text-center"></i>
                    <span class="ms-3 text-sm">Kepala Lab</span>
                </a>
            </li>

            <li>
                <a href="<?= url('/admin/calendar') ?>"
                    class="flex items-center p-3 rounded-lg <?= isSidebarActive($uri, '/admin/calendar') ?>">
                    <i class="bi bi-calendar3 text-lg w-6 text-center"></i>
                    <span class="ms-3 text-sm">Kalender Akademik</span>
                </a>
            </li>

            <li>
                <a href="<?= url('/admin/schedules') ?>"
                    class="flex items-center p-3 rounded-lg <?= isSidebarActive($uri, '/admin/schedules') ?>">
                    <i class="bi bi-calendar-week-fill text-lg w-6 text-center"></i>
                    <span class="ms-3 text-sm">Jadwal Kuliah</span>
                </a>
            </li>

            <li>
                <a href="<?= url('/admin/assistant-schedules') ?>"
                    class="flex items-center p-3 rounded-lg <?= isSidebarActive($uri, '/admin/assistant-schedules') ?>">
                    <i class="bi bi-clock-history text-lg w-6 text-center"></i>
                    <span class="ms-3 text-sm">Jadwal Piket</span>
                </a>
            </li>

            <li>
                <a href="<?= url('/admin/problems') ?>"
                    class="flex items-center p-3 rounded-lg <?= isSidebarActive($uri, '/admin/problems') ?>">
                    <i class="bi bi-exclamation-triangle-fill text-lg w-6 text-center"></i>
                    <span class="ms-3 text-sm">Laporan Masalah</span>
                </a>
            </li>

            <li>
                <a href="<?= url('/admin/activities') ?>"
                    class="flex items-center p-3 rounded-lg <?= isSidebarActive($uri, '/admin/activities') ?>">
                    <i class="bi bi-newspaper text-lg w-6 text-center"></i>
                    <span class="ms-3 text-sm">Berita / Kegiatan</span>
                </a>
            </li>

        </ul>
    </div>

    <div class="border-t border-slate-800 p-4 bg-slate-900 shrink-0 space-y-2">

        <a href="<?= url('/') ?>"
            class="flex items-center justify-center w-full p-2.5 text-xs font-bold text-slate-300 bg-slate-800/80 border border-slate-700 rounded-lg hover:bg-sky-600 hover:text-white hover:border-sky-600 transition-all duration-300 group">
            <i class="bi bi-house-door-fill me-2 text-sm"></i>
            HALAMAN DEPAN
        </a>

        <a href="<?= url('/logout') ?>"
            class="flex items-center justify-center w-full p-2.5 text-xs font-bold text-rose-300 bg-rose-950/20 border border-rose-900/30 rounded-lg hover:bg-rose-600 hover:text-white hover:border-rose-600 transition-all duration-300 group">
            <i class="bi bi-box-arrow-right me-2 text-sm group-hover:translate-x-1 transition-transform"></i>
            LOGOUT
        </a>
    </div>

</aside>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #334155;
        border-radius: 20px;
    }
</style>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('toast-notification');
        if (toast) {
            setTimeout(() => {
                toast.classList.remove('translate-x-full', 'opacity-0');
            }, 100);
            setTimeout(() => {
                closeToast();
            }, 5000);
        }
    });

    function closeToast() {
        const toast = document.getElementById('toast-notification');
        if (toast) {
            toast.classList.add('translate-x-full', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }
    }
</script>