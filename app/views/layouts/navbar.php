<nav
    class="bg-white/95 backdrop-blur-md border-b border-slate-200 fixed w-full z-50 top-0 start-0 transition-all duration-300">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

        <a href="<?= url('/') ?>" class="flex items-center gap-3 group">
            <img src="<?= url('/assets/images/logo-iclabs.png') ?>" alt="Logo ICLABS"
                class="h-10 w-auto object-contain group-hover:scale-105 transition-transform duration-300">

            <span
                class="self-center text-2xl font-extrabold tracking-tight text-slate-800 group-hover:text-sky-600 transition-colors">
                ICLABS
            </span>
        </a>

        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

            <?php if (isLoggedIn()): ?>
                <div class="flex items-center gap-4">
                    <div class="hidden md:block text-right">
                        <span
                            class="block text-sm font-bold text-slate-700"><?= e(explode(' ', $_SESSION['user_name'])[0]) ?></span>
                        <span
                            class="block text-[10px] font-bold uppercase tracking-wider text-slate-500"><?= getUserRole() ?></span>
                    </div>

                    <button type="button"
                        class="flex text-sm bg-slate-800 rounded-full md:me-0 focus:ring-4 focus:ring-slate-300 transition-transform hover:scale-105"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                        data-dropdown-placement="bottom">
                        <span class="sr-only">Open user menu</span>
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold border-2 border-slate-200 shadow-sm">
                            <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                        </div>
                    </button>
                </div>

                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-slate-100 rounded-xl shadow-xl border border-slate-200 min-w-[200px]"
                    id="user-dropdown">
                    <div class="px-4 py-3">
                        <span
                            class="block text-sm text-slate-900 font-bold"><?= e($_SESSION['user_name'] ?? 'User') ?></span>
                        <span class="block text-xs text-slate-500 truncate"><?= e($_SESSION['user_email'] ?? '') ?></span>
                    </div>

                    <?php if (getUserRole() == 'admin'): ?>
                        <ul class="py-2" aria-labelledby="user-menu-button">
                            <li>
                                <a href="<?= url('/admin/dashboard') ?>"
                                    class="block px-4 py-2 text-sm text-sky-600 hover:bg-sky-50 font-bold">
                                    <i class="bi bi-speedometer2 me-2"></i> Ke Dashboard Admin
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>

                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="<?= url('/logout') ?>"
                                class="block px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 font-medium">
                                <i class="bi bi-box-arrow-right me-2"></i> Sign out
                            </a>
                        </li>
                    </ul>
                </div>

            <?php else: ?>
                <a href="<?= url('/login') ?>"
                    class="text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-full text-sm px-6 py-2.5 text-center shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                    Login Portal
                </a>
            <?php endif; ?>

            <button data-collapse-toggle="navbar-sticky" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-slate-500 rounded-lg md:hidden hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-slate-200 ms-2"
                aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul
                class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-slate-100 rounded-lg bg-slate-50 md:space-x-6 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white/0">

                <li>
                    <a href="<?= url('/') ?>"
                        class="block py-2 px-3 rounded md:p-0 transition-colors <?= ($_SERVER['REQUEST_URI'] == '/iclabs/public/' || $_SERVER['REQUEST_URI'] == '/iclabs/public/home') ? 'text-sky-600 font-bold' : 'text-slate-600 hover:text-sky-600' ?>">
                        Home
                    </a>
                </li>
                <li>
                    <a href="<?= url('/schedule') ?>"
                        class="block py-2 px-3 rounded md:p-0 transition-colors <?= strpos($_SERVER['REQUEST_URI'], '/schedule') !== false ? 'text-sky-600 font-bold' : 'text-slate-600 hover:text-sky-600' ?>">
                        Jadwal Lab
                    </a>
                </li>
                <li>
                    <a href="<?= url('/presence') ?>"
                        class="block py-2 px-3 rounded md:p-0 transition-colors <?= strpos($_SERVER['REQUEST_URI'], '/presence') !== false ? 'text-sky-600 font-bold' : 'text-slate-600 hover:text-sky-600' ?>">
                        Presence
                    </a>
                </li>

                <?php if (isLoggedIn()): ?>
                    <?php $role = getUserRole(); ?>

                    <?php if ($role == 'koordinator'): ?>
                        <li class="hidden md:block w-px h-5 bg-slate-300 mx-2"></li>
                        <li>
                            <a href="<?= url('/koordinator/assistant-schedules') ?>"
                                class="block py-2 px-3 rounded md:p-0 text-amber-600 hover:text-amber-700 font-medium transition-colors">
                                Piket
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('/koordinator/laboratories') ?>"
                                class="block py-2 px-3 rounded md:p-0 text-amber-600 hover:text-amber-700 font-medium transition-colors">
                                Data Lab
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('/koordinator/problems') ?>"
                                class="block py-2 px-3 rounded md:p-0 text-amber-600 hover:text-amber-700 font-medium transition-colors">
                                Permasalahan
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('/koordinator/activities') ?>"
                                class="block py-2 px-3 rounded md:p-0 text-amber-600 hover:text-amber-700 font-medium transition-colors">
                                Kegiatan
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($role == 'asisten'): ?>
                        <li class="hidden md:block w-px h-5 bg-slate-300 mx-1"></li>

                        <li>
                            <a href="<?= url('/asisten/jobdesk') ?>"
                                class="block py-2 px-3 rounded md:p-0 transition-colors <?= strpos($_SERVER['REQUEST_URI'], '/jobdesk') !== false ? 'text-emerald-600 font-bold' : 'text-slate-600 hover:text-emerald-600' ?>">
                                <i class="bi bi-briefcase mr-1"></i> Jobdesk
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('/asisten/problems') ?>"
                                class="block py-2 px-3 rounded md:p-0 transition-colors <?= strpos($_SERVER['REQUEST_URI'], '/problems') !== false ? 'text-emerald-600 font-bold' : 'text-slate-600 hover:text-emerald-600' ?>">
                                Masalah Lab
                            </a>
                        </li>
                        <li>
                            <a href="<?= url('/asisten/assistant-schedules') ?>"
                                class="block py-2 px-3 rounded md:p-0 transition-colors <?= strpos($_SERVER['REQUEST_URI'], '/assistant-schedules') !== false ? 'text-emerald-600 font-bold' : 'text-slate-600 hover:text-emerald-600' ?>">
                                Jadwal Piket
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if ($role == 'admin'): ?>
                        <li class="hidden md:block w-px h-5 bg-slate-300 mx-1"></li>
                        <li>
                            <a href="<?= url('/admin/dashboard') ?>"
                                class="block py-2 px-3 rounded md:p-0 text-white bg-sky-600 hover:bg-sky-700 md:bg-transparent md:text-sky-600 md:hover:text-sky-800 font-bold transition-colors">
                                <i class="bi bi-shield-lock-fill mr-1"></i> ADMIN PANEL
                            </a>
                        </li>
                    <?php endif; ?>

                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>
<div class="h-20"></div>