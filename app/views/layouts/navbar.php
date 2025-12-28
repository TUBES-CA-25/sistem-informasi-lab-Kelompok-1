<nav class="navbar">
    <div class="container">
        <a href="<?= url('/') ?>" class="navbar-brand">ICLABS</a>
        <ul class="navbar-menu">
            <li><a href="<?= url('/') ?>">Home</a></li>
            <li><a href="<?= url('/schedule') ?>">Laboratory Schedule</a></li>
            <li><a href="<?= url('/#laboratory-management') ?>">Laboratory Management</a></li>
            <?php if (isLoggedIn()): ?>
                <li><a href="<?= url('/' . getUserRole() . '/dashboard') ?>">Dashboard</a></li>
                <li><a href="<?= url('/logout') ?>">Logout</a></li>
            <?php else: ?>
                <li><a href="<?= url('/login') ?>" class="btn btn-primary">Login</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
