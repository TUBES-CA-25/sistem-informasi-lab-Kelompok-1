<?php $title = 'Home - ICLABS'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<section class="relative pt-24 pb-12 lg:pt-10 lg:pb-20 overflow-hidden bg-white">

    <div class="absolute top-0 right-0 -mr-24 -mt-24 w-[500px] h-[500px] bg-sky-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
    <div class="absolute top-0 left-0 -ml-24 -mt-24 w-[400px] h-[400px] bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
    <div class="absolute bottom-0 left-1/3 w-[300px] h-[300px] bg-cyan-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>

    <div class="relative max-w-screen-xl px-4 mx-auto z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-sky-50 border border-sky-100 text-sky-600 text-sm font-semibold mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-sky-500"></span>
                </span>
                Sistem Informasi Laboratorium Terpadu
            </div>

            <h1 class="text-5xl md:text-6xl font-extrabold tracking-tight text-slate-900 mb-6 leading-tight">
                Inovasi Dimulai dari <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 to-blue-600">Laboratorium Digital</span>
            </h1>

            <p class="text-lg text-slate-500 mb-8 leading-relaxed">
                Platform terpusat FIKOM UMI untuk manajemen praktikum, riset, dan pengembangan teknologi.
                Akses jadwal, data asisten, dan fasilitas lab dalam satu genggaman.
            </p>

            <div class="flex flex-wrap justify-center gap-4">
                <a href="<?= url('/schedule') ?>" class="px-8 py-3.5 text-base font-medium text-white bg-sky-500 hover:bg-sky-600 rounded-full shadow-lg shadow-sky-500/30 transition-all hover:-translate-y-1">
                    Lihat Jadwal
                </a>
                <a href="<?= url('/presence') ?>" class="px-8 py-3.5 text-base font-medium text-slate-700 bg-white border border-slate-200 hover:border-sky-300 hover:bg-sky-50 rounded-full transition-all hover:-translate-y-1">
                    Cek Kehadiran
                </a>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 text-center hover:border-sky-200 transition-colors group">
                <div class="w-12 h-12 mx-auto bg-sky-50 rounded-xl flex items-center justify-center text-sky-500 mb-3 group-hover:scale-110 transition-transform">
                    <i class="bi bi-motherboard text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-slate-800"><?= $stats['labs_count'] ?></h3>
                <p class="text-sm text-slate-500 font-medium">Laboratorium</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 text-center hover:border-sky-200 transition-colors group">
                <div class="w-12 h-12 mx-auto bg-blue-50 rounded-xl flex items-center justify-center text-blue-500 mb-3 group-hover:scale-110 transition-transform">
                    <i class="bi bi-people text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-slate-800"><?= $stats['assistants_count'] ?></h3>
                <p class="text-sm text-slate-500 font-medium">Asisten Aktif</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 text-center hover:border-sky-200 transition-colors group">
                <div class="w-12 h-12 mx-auto bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-500 mb-3 group-hover:scale-110 transition-transform">
                    <i class="bi bi-mortarboard text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-slate-800"><?= $stats['lecturers_count'] ?></h3>
                <p class="text-sm text-slate-500 font-medium">Dosen</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 text-center hover:border-sky-200 transition-colors group">
                <div class="w-12 h-12 mx-auto bg-cyan-50 rounded-xl flex items-center justify-center text-cyan-500 mb-3 group-hover:scale-110 transition-transform">
                    <i class="bi bi-person-check text-2xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">200+</h3>
                <p class="text-sm text-slate-500 font-medium">Mahasiswa</p>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-slate-50/50">
    <div class="max-w-screen-xl px-4 mx-auto">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">Fasilitas Laboratorium</h2>
                <p class="mt-2 text-slate-500">Mendukung kegiatan praktikum dan riset mahasiswa.</p>
            </div>
        </div>

        <div id="lab-carousel" class="relative w-full" data-carousel="slide">
            <div class="relative h-64 overflow-hidden rounded-2xl md:h-[400px] shadow-xl">
                <?php foreach ($labs as $index => $lab): ?>
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="https://placehold.co/1200x600/0ea5e9/ffffff?text=<?= urlencode($lab['lab_name']) ?>"
                            class="absolute block w-full h-full object-cover" alt="<?= $lab['lab_name'] ?>">

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>

                        <div class="absolute bottom-0 left-0 p-8 w-full md:w-2/3">
                            <span class="inline-block px-3 py-1 bg-sky-500 text-white text-xs font-bold rounded mb-3">
                                TERSEDIA
                            </span>
                            <h3 class="text-3xl font-bold text-white mb-2"><?= e($lab['lab_name']) ?></h3>
                            <div class="flex items-center text-slate-300 mb-4">
                                <i class="bi bi-geo-alt-fill mr-2 text-sky-400"></i>
                                <?= e($lab['location']) ?>
                            </div>
                            <p class="text-slate-300 line-clamp-2 text-sm md:text-base border-l-4 border-sky-500 pl-4">
                                <?= e($lab['description'] ?? 'Laboratorium dengan fasilitas lengkap untuk menunjang kegiatan belajar mengajar dan penelitian mahasiswa.') ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                <?php foreach ($labs as $index => $lab): ?>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $index + 1 ?>" data-carousel-slide-to="<?= $index ?>"></button>
                <?php endforeach; ?>
            </div>

            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/10 group-hover:bg-white/30 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none backdrop-blur-sm">
                    <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/10 group-hover:bg-white/30 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none backdrop-blur-sm">
                    <svg class="w-4 h-4 text-white rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-screen-xl px-4 mx-auto">
        <div class="flex items-center justify-between mb-10">
            <div>
                <h2 class="text-3xl font-bold text-slate-900">Kegiatan Terbaru</h2>
                <div class="h-1 w-20 bg-sky-500 mt-2 rounded-full"></div>
            </div>
            <a href="<?= url('/activities') ?>" class="text-sky-600 font-semibold hover:text-sky-700 flex items-center gap-2 transition-colors">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">
            <?php if (!empty($activities)): ?>
                <?php foreach ($activities as $activity): ?>
                    <article class="bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden group">
                        <div class="relative h-56 overflow-hidden">
                            <img src="<?= !empty($activity['image_cover']) ? $activity['image_cover'] : 'https://placehold.co/600x400/e0f2fe/0ea5e9?text=Kegiatan+Lab' ?>"
                                class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500" alt="Cover">
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-sm text-sky-600 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                                    <?= getActivityTypeLabel($activity['activity_type']) ?>
                                </span>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex items-center text-slate-400 text-xs font-medium mb-3 uppercase tracking-wider">
                                <i class="bi bi-calendar-event mr-2"></i>
                                <?= formatDate($activity['activity_date']) ?>
                            </div>

                            <h3 class="text-xl font-bold text-slate-900 mb-3 line-clamp-2 group-hover:text-sky-600 transition-colors">
                                <a href="#"><?= e($activity['title']) ?></a>
                            </h3>

                            <p class="text-slate-500 text-sm line-clamp-3 mb-4 leading-relaxed">
                                <?= e($activity['description']) ?>
                            </p>

                            <a href="#" class="inline-flex items-center text-sm font-semibold text-sky-500 hover:text-sky-700">
                                Baca Selengkapnya <i class="bi bi-chevron-right text-xs ml-1 mt-0.5"></i>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-3 text-center py-20 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full text-slate-300 mb-4 shadow-sm">
                        <i class="bi bi-journal-album text-3xl"></i>
                    </div>
                    <p class="text-slate-500 font-medium">Belum ada kegiatan yang dipublikasikan.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>