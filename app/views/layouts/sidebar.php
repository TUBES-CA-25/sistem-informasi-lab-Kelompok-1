<?php
$uri = $_SERVER['REQUEST_URI'] ?? '';
function isSidebarActive($uri, $path)
{
    return strpos($uri, $path) !== false
        ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/20 font-medium border-l-4 border-white'
        : 'text-slate-400 hover:bg-slate-800 hover:text-white transition-colors duration-200';
}
?>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0 bg-slate-900 border-r border-slate-800 flex flex-col shadow-2xl"
    aria-label="Sidebar">

    <div class="h-16 flex items-center px-6 border-b border-slate-800 bg-slate-900 shrink-0">
        <a href="<?= url('/admin/dashboard') ?>" class="flex items-center gap-3 group">
            <div
                class="w-8 h-8 rounded bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center text-white font-bold shadow-lg shadow-sky-500/30">
                IC
            </div>
            <span class="self-center text-xl font-bold whitespace-nowrap text-white tracking-wide">ADMIN</span>
        </a>
    </div>

    <div class="flex-1 px-3 py-4 overflow-y-auto sidebar-scroll">

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
            <ul class="space-y-1">

                <li class="mb-6">
                    <a href="<?= url('/') ?>"
                        class="flex items-center p-2.5 rounded-xl text-emerald-400 bg-emerald-900/10 border border-emerald-900/30 hover:bg-emerald-900/30 transition-all group">
                        <i class="bi bi-house-door text-xl opacity-80 group-hover:scale-110 transition-transform"></i>
                        <span class="ms-3 text-sm font-semibold">Ke Halaman Depan</span>
                    </a>
                </li>

                <li>
                    <a href="<?= url('/admin/dashboard') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/dashboard') ?>">
                        <i class="bi bi-speedometer2 text-xl opacity-80"></i>
                        <span class="ms-3 text-sm">Dashboard</span>
                    </a>
                </li>

                <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Akademik</li>

                <li>
                    <a href="<?= url('/admin/calendar') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/calendar') ?>">
                        <i class="bi bi-calendar3 text-xl opacity-80"></i>
                        <span class="ms-3 text-sm">Kalender Akademik</span>
                    </a>
                </li>

                <li>
                    <a href="<?= url('/admin/schedules') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/schedules') ?>">
                        <i class="bi bi-table text-xl opacity-80"></i>
                        <span class="ms-3 text-sm">Data Jadwal</span>
                    </a>
                </li>
                <li>
                    <a href="<?= url('/admin/assistant-schedules') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/assistant-schedules') ?>">
                        <i class="bi bi-clock-history text-xl opacity-80"></i>
                        <span class="ms-3 text-sm">Jadwal Piket</span>
                    </a>
                </li>

                <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Manajemen Lab</li>
                <li>
                    <a href="<?= url('/admin/head-laboran') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/head-laboran') ?>">
                        <i class="bi bi-person-badge text-xl opacity-80"></i>
                        <span class="ms-3 text-sm">Presence / KaLab</span>
                    </a>
                </li>
                <li>
                    <a href="<?= url('/admin/laboratories') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/laboratories') ?>">
                        <i class="bi bi-pc-display text-xl opacity-80"></i>
                        <span class="ms-3 text-sm">Data Laboratorium</span>
                    </a>
                </li>
                <li>
                    <a href="<?= url('/admin/activities') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/activities') ?>">
                        <i class="bi bi-newspaper text-xl opacity-80"></i>
                        <span class="ms-3 text-sm">Kegiatan / Blog</span>
                    </a>
                </li>
                <li>
                    <a href="<?= url('/admin/problems') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/problems') ?>">
                        <i class="bi bi-exclamation-triangle text-xl opacity-80"></i>
                        <span class="ms-3 text-sm">Laporan Masalah</span>
                    </a>
                </li>

                <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">System</li>
                <li>
                    <a href="<?= url('/admin/users') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/admin/users') ?>">
                        <i class="bi bi-people text-xl opacity-80"></i>
                        <span class="ms-3 text-sm">User Management</span>
                    </a>
                </li>
            </ul>

        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'koordinator'): ?>
            <ul class="space-y-1">
                <li class="px-3 mt-2 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Main Menu</li>
                <li><a href="<?= url('/koordinator/dashboard') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/koordinator/dashboard') ?>"><i
                            class="bi bi-grid-1x2-fill text-lg opacity-80"></i><span
                            class="ms-3 text-sm">Dashboard</span></a></li>
                <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Laporan Masalah
                </li>
                <li><a href="<?= url('/koordinator/problems') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/koordinator/problems') ?>"><i
                            class="bi bi-exclamation-triangle-fill text-lg opacity-80"></i><span
                            class="ms-3 text-sm">Laporan Masalah</span></a></li>
            </ul>

        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] == 'asisten'): ?>
            <ul class="space-y-1">
                <li class="px-3 mt-2 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Main Menu</li>
                <li><a href="<?= url('/asisten/dashboard') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/asisten/dashboard') ?>"><i
                            class="bi bi-grid-1x2-fill text-lg opacity-80"></i><span
                            class="ms-3 text-sm">Dashboard</span></a></li>
                <li class="px-3 mt-6 mb-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Laporan Masalah
                </li>
                <li><a href="<?= url('/asisten/report-problem') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/asisten/report-problem') ?>"><i
                            class="bi bi-plus-circle-fill text-lg opacity-80"></i><span class="ms-3 text-sm">Lapor
                            Kerusakan</span></a></li>
                <li><a href="<?= url('/asisten/my-reports') ?>"
                        class="flex items-center p-2.5 rounded-xl group <?= isSidebarActive($uri, '/asisten/my-reports') ?>"><i
                            class="bi bi-list-ul text-lg opacity-80"></i><span class="ms-3 text-sm">Laporan Saya</span></a>
                </li>
            </ul>
        <?php endif; ?>
    </div>

    <div class="border-t border-slate-800 p-4 bg-slate-900 shrink-0">
        <a href="<?= url('/logout') ?>"
            class="flex items-center justify-center w-full p-2.5 text-xs font-bold text-rose-300 bg-rose-950/30 border border-rose-900/50 rounded-lg hover:bg-rose-900/50 hover:text-white transition-colors">
            <i class="bi bi-box-arrow-right me-2 text-sm"></i> LOGOUT
        </a>
    </div>

</aside>

<!-- Toast Notification Auto-Hide Script (For Admin Layout) -->
<script>
// Close toast notification function
function closeToast() {
    const toast = document.getElementById('toast-notification');
    if (toast) {
        toast.classList.add('translate-x-full', 'opacity-0');
        setTimeout(() => toast.remove(), 300);
    }
}

// Auto-hide toast after 5 seconds and slide-in animation
window.addEventListener('DOMContentLoaded', function() {
    const toast = document.getElementById('toast-notification');
    if (toast) {
        // Slide in animation
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Auto-hide after 5 seconds
        setTimeout(() => {
            closeToast();
        }, 5000);
    }
});
</script>