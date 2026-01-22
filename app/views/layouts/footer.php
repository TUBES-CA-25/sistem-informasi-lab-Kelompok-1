<footer class="bg-white mt-20 pb-8 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 items-center py-12">
            
            <div class="flex justify-center md:justify-start">
                <img src="<?= BASE_URL ?>/assets/images/logo-iclabs.png" 
                     alt="ICLABS Logo" 
                     class="h-32 w-auto object-contain animate-float"
                     onerror="this.src='https://cdn-icons-png.flaticon.com/512/2083/2083213.png'">
            </div>

            <div class="text-center md:text-left">
                <ul class="space-y-4">
                    <li>
                        <a href="<?= url('/#sarana') ?>" class="text-slate-600 hover:text-sky-600 font-medium text-base transition-colors">
                            Sarana & Prasarana
                        </a>
                    </li>
                    <li>
                        <a href="<?= url('/#activity') ?>" class="text-slate-600 hover:text-sky-600 font-medium text-base transition-colors">
                            Laboratorium Activity
                        </a>
                    </li>
                    <li>
                        <a href="<?= url('/schedule') ?>" class="text-slate-600 hover:text-sky-600 font-medium text-base transition-colors">
                            Laboratorium Schedule
                        </a>
                    </li>
                    <li>
                        <a href="<?= url('/presence') ?>" class="text-slate-600 hover:text-sky-600 font-medium text-base transition-colors">
                            Laboratorium Management
                        </a>
                    </li>
                </ul>
            </div>

            <div class="text-center md:text-left">
                <h3 class="font-bold text-slate-900 text-lg mb-2">Contact</h3>
                <ul class="space-y-4">
                    <li>
                        <a href="https://www.instagram.com/labfikomumi/" target="_blank" class="flex items-center justify-center md:justify-start gap-3 text-slate-600 hover:text-sky-600 group transition-colors">
                            <i class="bi bi-instagram text-xl text-slate-900 group-hover:text-sky-600"></i>
                            <span class="font-medium">labfikomumi</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/@iclabsfikom-umi8404" target="_blank" class="flex items-center justify-center md:justify-start gap-3 text-slate-600 hover:text-sky-600 group transition-colors">
                            <i class="bi bi-youtube text-xl text-slate-900 group-hover:text-sky-600"></i>
                            <span class="font-medium">ICLABS FIKOM-UMI</span>
                        </a>
                    </li>
                    <li>
                        <a href="https://iclabs.fikom.umi.ac.id/" target="_blank" class="flex items-center justify-center md:justify-start gap-3 text-slate-600 hover:text-sky-600 group transition-colors">
                            <i class="bi bi-globe text-xl text-slate-900 group-hover:text-sky-600"></i>
                            <span class="font-medium">iclabs.fikom.umi.ac.id</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-8 mt-4">
            <p class="text-sm text-slate-500 font-medium text-center md:text-left">
                Copyright © <?= date('Y') ?> LAB FIKOM UMI
            </p>
        </div>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
<script src="<?= asset('js/main.js') ?>"></script>
<script>
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});
</script>
</body>
</html>