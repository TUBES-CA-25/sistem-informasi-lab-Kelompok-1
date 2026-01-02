<nav class="bg-white border-b border-gray-200 fixed w-full z-50 top-0 start-0 border-gray-200 glass-effect">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="<?= url('/') ?>" class="flex items-center space-x-3 rtl:space-x-reverse">
            <div class="bg-primary text-white p-1.5 rounded-lg">
                <i class="bi bi-pc-display-horizontal text-xl"></i>
            </div>
            <span class="self-center text-2xl font-bold whitespace-nowrap text-gray-900 tracking-tight">ICLABS</span>
        </a>

        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <?php if (isLoggedIn()): ?>
                <a href="<?= url('/' . getUserRole() . '/dashboard') ?>" class="text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            <?php else: ?>
                <a href="<?= url('/login') ?>" class="text-black bg-secondary hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center">
                    Login
                </a>
            <?php endif; ?>

            <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-sticky" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
                <li>
                    <a href="<?= url('/') ?>" class="block py-2 px-3 rounded md:p-0 <?= ($_SERVER['REQUEST_URI'] == '/iclabs/public/' || $_SERVER['REQUEST_URI'] == '/iclabs/public/home') ? 'text-primary' : 'text-gray-900 hover:text-primary' ?>">Home</a>
                </li>
                <li>
                    <a href="<?= url('/schedule') ?>" class="block py-2 px-3 rounded md:p-0 <?= strpos($_SERVER['REQUEST_URI'], '/schedule') !== false ? 'text-primary' : 'text-gray-900 hover:text-primary' ?>">Jadwal Lab</a>
                </li>
                <li>
                    <a href="<?= url('/presence') ?>" class="block py-2 px-3 rounded md:p-0 <?= strpos($_SERVER['REQUEST_URI'], '/presence') !== false ? 'text-primary' : 'text-gray-900 hover:text-primary' ?>">Presence</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="h-20"></div>