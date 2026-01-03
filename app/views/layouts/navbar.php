<nav class="bg-white/90 backdrop-blur-md border-b border-slate-200 fixed w-full z-50 top-0 start-0 transition-all duration-300">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

        <a href="<?= url('/') ?>" class="flex items-center gap-2 group">
            <div class="bg-gradient-to-tr from-sky-500 to-blue-600 text-white p-2 rounded-lg shadow-lg shadow-sky-500/30 group-hover:scale-110 transition-transform duration-300">
                <i class="bi bi-pc-display-horizontal text-xl"></i>
            </div>
            <span class="self-center text-2xl font-extrabold whitespace-nowrap text-slate-800 tracking-tight group-hover:text-sky-600 transition-colors">
                ICLABS
            </span>
        </a>

        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

            <?php if (isLoggedIn()): ?>
                <?php
                // LOGIKA MENENTUKAN TOMBOL SESUAI ROLE
                $role = getUserRole(); // admin, asisten, koordinator
                $dashboardLink = '#';
                $btnLabel = 'Dashboard';
                $btnColor = 'bg-slate-800 hover:bg-slate-900'; // Default
                $btnIcon = 'bi-speedometer2';

                if ($role == 'admin') {
                    $dashboardLink = url('/admin/dashboard');
                    $btnLabel = 'Admin Panel';
                    $btnColor = 'bg-sky-600 hover:bg-sky-700 shadow-sky-500/30';
                    $btnIcon = 'bi-shield-lock';
                } elseif ($role == 'asisten') {
                    $dashboardLink = url('/asisten/dashboard');
                    $btnLabel = 'Halaman Asisten';
                    $btnColor = 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-500/30';
                    $btnIcon = 'bi-person-workspace';
                } elseif ($role == 'koordinator') {
                    $dashboardLink = url('/koordinator/dashboard');
                    $btnLabel = 'Koordinator';
                    $btnColor = 'bg-amber-600 hover:bg-amber-700 shadow-amber-500/30';
                    $btnIcon = 'bi-person-gear';
                }
                ?>

                <div class="flex items-center gap-3">
                    <a href="<?= $dashboardLink ?>" class="text-white <?= $btnColor ?> font-medium rounded-full text-sm px-5 py-2.5 text-center shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center">
                        <i class="bi <?= $btnIcon ?> mr-2"></i> <?= $btnLabel ?>
                    </a>

                    <button type="button" class="flex text-sm bg-slate-800 rounded-full md:me-0 focus:ring-4 focus:ring-slate-300" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                        <span class="sr-only">Open user menu</span>
                        <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold border border-slate-200">
                            <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                        </div>
                    </button>
                </div>

                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-slate-100 rounded-xl shadow-xl border border-slate-200 min-w-[200px]" id="user-dropdown">
                    <div class="px-4 py-3">
                        <span class="block text-sm text-slate-900 font-bold"><?= e($_SESSION['user_name'] ?? 'User') ?></span>
                        <span class="block text-xs text-slate-500 truncate"><?= e($_SESSION['user_email'] ?? '') ?></span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="<?= url('/logout') ?>" class="block px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 font-medium">
                                <i class="bi bi-box-arrow-right me-2"></i> Sign out
                            </a>
                        </li>
                    </ul>
                </div>

            <?php else: ?>
                <a href="<?= url('/login') ?>" class="text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-full text-sm px-6 py-2.5 text-center shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    Login Portal
                </a>
            <?php endif; ?>

            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-slate-500 rounded-lg md:hidden hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-200 ms-2" aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-slate-100 rounded-lg bg-slate-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white/0">
                <li>
                    <a href="<?= url('/') ?>" class="block py-2 px-3 rounded md:p-0 transition-colors <?= ($_SERVER['REQUEST_URI'] == '/iclabs/public/' || $_SERVER['REQUEST_URI'] == '/iclabs/public/home') ? 'text-sky-600 font-bold' : 'text-slate-700 hover:text-sky-600' ?>">
                        Home
                    </a>
                </li>
                <li>
                    <a href="<?= url('/schedule') ?>" class="block py-2 px-3 rounded md:p-0 transition-colors <?= strpos($_SERVER['REQUEST_URI'], '/schedule') !== false ? 'text-sky-600 font-bold' : 'text-slate-700 hover:text-sky-600' ?>">
                        Jadwal Lab
                    </a>
                </li>
                <li>
                    <a href="<?= url('/presence') ?>" class="block py-2 px-3 rounded md:p-0 transition-colors <?= strpos($_SERVER['REQUEST_URI'], '/presence') !== false ? 'text-sky-600 font-bold' : 'text-slate-700 hover:text-sky-600' ?>">
                        Presence
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="h-20"></div>