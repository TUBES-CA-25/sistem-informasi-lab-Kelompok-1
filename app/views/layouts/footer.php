<footer class="bg-white border-t border-gray-200 mt-auto">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="<?= url('/') ?>" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-primary">ICLABS</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0">
                <li>
                    <a href="<?= url('/schedule') ?>" class="hover:underline me-4 md:me-6">Jadwal</a>
                </li>
                <li>
                    <a href="<?= url('/presence') ?>" class="hover:underline me-4 md:me-6">Presence</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Kontak</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center">© <?= date('Y') ?> <a href="#" class="hover:underline">FIKOM UMI</a>. All Rights Reserved.</span>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

<script src="<?= asset('js/main.js') ?>"></script>
</body>

</html>