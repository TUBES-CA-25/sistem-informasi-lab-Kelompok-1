<div class="sidebar">
    <div class="sidebar-brand">ICLABS</div>
    <ul class="sidebar-menu">
        <li><a href="<?= url('/admin/dashboard') ?>" class="<?= ($_SERVER['REQUEST_URI'] ?? '') == '/admin/dashboard' ? 'active' : '' ?>">Dashboard</a></li>
        <li><a href="<?= url('/admin/schedules') ?>">Jadwal Praktikum</a></li>
        <li><a href="<?= url('/admin/assistant-schedules') ?>">Jadwal Piket</a></li>
        <li><a href="<?= url('/admin/head-laboran') ?>">Head Laboran</a></li>
        <li><a href="<?= url('/admin/users') ?>">User Management</a></li>
        <li><a href="<?= url('/admin/laboratories') ?>">Laboratories</a></li>
        <li><a href="<?= url('/admin/activities') ?>">Kegiatan Lab</a></li>
        <li><a href="<?= url('/admin/problems') ?>">Permasalahan Lab</a></li>
        <li><a href="<?= url('/logout') ?>">Logout</a></li>
    </ul>
</div>
