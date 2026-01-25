<footer class="bg-white mt-10 md:mt-20 pb-4 md:pb-8 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 md:px-20 lg:px-32">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-0 md:gap-8 py-6 md:py-12 items-start">
            
            <div class="hidden md:flex justify-center md:justify-start">
                <img src="<?= BASE_URL ?>/assets/images/logo-iclabs.png" 
                     alt="ICLABS Logo" 
                     class="h-48 w-auto object-contain animate-float"
                     onerror="this.src='https://cdn-icons-png.flaticon.com/512/2083/2083213.png'">
            </div>

            <div class="hidden md:flex justify-center mt-8 md:mt-2">
                <ul class="space-y-5 text-center md:text-left">
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

            <div class="flex flex-col items-center md:items-end mt-0 md:mt-2">
                <div class="text-center md:text-left w-full">
                    <h3 class="font-bold text-slate-900 text-lg mb-3 md:mb-2">Contact</h3>
                    
                    <ul class="space-y-2 md:space-y-5">
                        <li class="flex justify-center md:justify-start">
                            <a href="https://www.instagram.com/labfikomumi/" target="_blank" class="flex items-center gap-2 text-slate-600 hover:text-sky-600 group transition-colors">
                                <i class="bi bi-instagram text-xl text-slate-900 group-hover:text-sky-600 min-w-[24px]"></i>
                                <span class="font-medium text-sm md:text-base">labfikomumi</span>
                            </a>
                        </li>
                        <li class="flex justify-center md:justify-start">
                            <a href="https://www.youtube.com/@iclabsfikom-umi8404" target="_blank" class="flex items-center gap-2 text-slate-600 hover:text-sky-600 group transition-colors">
                                <i class="bi bi-youtube text-xl text-slate-900 group-hover:text-sky-600 min-w-[24px]"></i>
                                <span class="font-medium text-sm md:text-base">ICLABS FIKOM-UMI</span>
                            </a>
                        </li>
                        <li class="flex justify-center md:justify-start">
                            <a href="https://iclabs.fikom.umi.ac.id/" target="_blank" class="flex items-center gap-2 text-slate-600 hover:text-sky-600 group transition-colors">
                                <i class="bi bi-globe text-xl text-slate-900 group-hover:text-sky-600 min-w-[24px]"></i>
                                <span class="font-medium text-sm md:text-base">iclabs.fikom.umi.ac.id</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-2 md:pt-8 mt-2 md:mt-4">
            <p class="text-xs md:text-sm text-slate-500 font-medium text-center md:text-left">
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
        if(this.getAttribute('href').length > 1) {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                e.preventDefault();
                const target = document.querySelector(this.hash);
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            }
        }
    });
});
</script>