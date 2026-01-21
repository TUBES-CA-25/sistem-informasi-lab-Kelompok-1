<?php $title = 'Home - ICLABS'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<section class="relative bg-white overflow-hidden pt-24 pb-10 lg:pt-28">
    <div
        class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-sky-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob">
    </div>
    <div
        class="absolute top-0 left-0 -ml-20 -mt-20 w-[500px] h-[500px] bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000">
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <div id="hero-carousel" class="relative w-full" data-carousel="static">

            <div class="relative h-[650px] overflow-hidden rounded-2xl">

                <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center h-full px-4 md:px-8">
                        <div class="space-y-6 text-center lg:text-left pt-10 lg:pt-0">
                            <div>
                                <h2 class="text-sky-500 font-bold tracking-widest text-sm uppercase mb-2">SISTEM
                                    INFORMASI</h2>
                                <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 leading-tight">
                                    ICLABS <br>
                                    <span class="text-2xl md:text-3xl font-bold text-slate-600 block mt-2">Fakultas Ilmu
                                        Komputer</span>
                                    <span class="text-xl md:text-2xl font-medium text-slate-500 block">Universitas
                                        Muslim Indonesia</span>
                                </h1>
                            </div>
                            <p class="text-slate-500 text-lg leading-relaxed max-w-lg mx-auto lg:mx-0">
                                Platform monitoring sistem informasi laboratorium terpadu untuk manajemen praktikum yang
                                efisien dan transparan.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                <a href="<?= url('/schedule') ?>"
                                    class="px-8 py-3 bg-blue-600 text-white font-bold rounded-full shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-transform hover:-translate-y-1">
                                    Lihat Jadwal
                                </a>
                                <a href="<?= url('/login') ?>"
                                    class="px-8 py-3 bg-white text-blue-600 border-2 border-blue-100 font-bold rounded-full hover:border-blue-600 transition-all">
                                    Login Portal
                                </a>
                            </div>
                        </div>
                        <div class="hidden lg:flex justify-center items-center">
                            <img src="<?= BASE_URL ?>/assets/images/circuit-hero.png" alt="ICLABS Tech"
                                class="relative z-10 w-full max-w-md animate-float"
                                onerror="this.src='https://cdn-icons-png.flaticon.com/512/2083/2083213.png'">
                        </div>
                    </div>
                </div>

                <?php foreach ($labSlides as $index => $slide): ?>
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <div class="h-full flex flex-col pt-4 px-2 md:px-8">

                            <div class="text-center mb-6">
                                <h2 class="text-xl font-bold text-slate-400 tracking-widest uppercase">JADWAL HARI INI</h2>
                                <div class="flex items-center justify-center gap-2 mt-1">
                                    <span class="text-3xl md:text-5xl font-black text-slate-800 uppercase">
                                        <?= e($slide['lab_info']['lab_name']) ?>
                                    </span>
                                </div>
                                <div
                                    class="mt-2 inline-block bg-sky-50 text-sky-600 px-4 py-1 rounded-full text-sm font-bold border border-sky-100">
                                    <?= $currentDayName ?>, <?= $currentDate ?>
                                </div>
                            </div>

                            <div
                                class="w-full max-w-5xl mx-auto bg-white/40 backdrop-blur-md rounded-xl border border-white/60 shadow-sm overflow-hidden flex-1 mb-16 relative">
                                <div class="overflow-y-auto h-full absolute inset-0">
                                    <table class="w-full text-sm text-left">
                                        <thead
                                            class="bg-white/60 text-slate-700 font-bold uppercase text-xs sticky top-0 z-10 backdrop-blur-md border-b border-white/50">
                                            <tr>
                                                <th class="px-6 py-4 text-center w-32">Waktu</th>
                                                <th class="px-6 py-4">Mata Kuliah & Kelas</th>
                                                <th class="px-6 py-4">Dosen Pengampu</th>
                                                <th class="px-6 py-4 text-center w-32">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100/50">
                                            <?php if (empty($slide['schedules'])): ?>
                                                <tr>
                                                    <td colspan="4" class="px-6 py-24 text-center text-slate-500">
                                                        <div
                                                            class="inline-flex items-center justify-center w-16 h-16 bg-white/50 rounded-full mb-3 shadow-sm">
                                                            <i class="bi bi-calendar-x text-2xl"></i>
                                                        </div>
                                                        <p class="font-medium">Tidak ada jadwal praktikum di ruangan ini.</p>
                                                    </td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($slide['schedules'] as $sch): ?>
                                                    <tr class="transition-colors hover:bg-white/30 schedule-row"
                                                        data-start="<?= $sch['start_time'] ?>" data-end="<?= $sch['end_time'] ?>">

                                                        <td
                                                            class="px-6 py-4 text-center whitespace-nowrap font-mono font-bold text-slate-600 bg-white/20">
                                                            <?= formatTime($sch['start_time']) ?><br>
                                                            <span class="text-slate-400 text-xs">s/d</span><br>
                                                            <?= formatTime($sch['end_time']) ?>
                                                        </td>

                                                        <td class="px-6 py-4">
                                                            <div class="font-bold text-slate-900 text-lg mb-1">
                                                                <?= e($sch['course_name']) ?></div>
                                                            <span
                                                                class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-xs font-bold bg-sky-100/80 text-sky-700">
                                                                <i class="bi bi-people-fill"></i> Kelas <?= e($sch['class_code']) ?>
                                                            </span>
                                                        </td>

                                                        <td class="px-6 py-4">
                                                            <div class="flex items-center gap-3">
                                                                <?php if (!empty($sch['lecturer_photo'])): ?>
                                                                    <img src="<?= e($sch['lecturer_photo']) ?>"
                                                                        class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                                                                <?php else: ?>
                                                                    <div
                                                                        class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-500">
                                                                        DS</div>
                                                                <?php endif; ?>
                                                                <div>
                                                                    <div class="font-bold text-slate-800">
                                                                        <?= e($sch['lecturer_name']) ?></div>
                                                                    <div class="text-xs text-slate-500">Dosen Pengampu</div>
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td class="px-6 py-4 text-center align-middle">
                                                            <span
                                                                class="status-badge px-3 py-1.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200/50">
                                                                Menunggu
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <button type="button"
                class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-prev>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-100/50 hover:bg-white text-slate-400 hover:text-sky-600 shadow-sm backdrop-blur-sm transition-all">
                    <i class="bi bi-chevron-left text-xl"></i>
                </span>
            </button>
            <button type="button"
                class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                data-carousel-next>
                <span
                    class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-slate-100/50 hover:bg-white text-slate-400 hover:text-sky-600 shadow-sm backdrop-blur-sm transition-all">
                    <i class="bi bi-chevron-right text-xl"></i>
                </span>
            </button>

            <div class="absolute z-30 flex space-x-2 -translate-x-1/2 bottom-5 left-1/2">
                <button type="button" class="w-2.5 h-2.5 rounded-full bg-slate-300 hover:bg-sky-600 transition-colors"
                    aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                <?php foreach ($labSlides as $i => $slide): ?>
                    <button type="button" class="w-2.5 h-2.5 rounded-full bg-slate-300 hover:bg-sky-600 transition-colors"
                        aria-current="false" aria-label="Slide <?= $i + 2 ?>"
                        data-carousel-slide-to="<?= $i + 1 ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-center text-sky-500 font-bold tracking-widest text-sm uppercase mb-10">SUMBER DAYA</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="group">
                <div
                    class="w-16 h-16 mx-auto bg-white rounded-2xl border-2 border-slate-100 shadow-sm flex items-center justify-center text-sky-500 mb-4 group-hover:border-sky-200 group-hover:scale-110 transition-all">
                    <i class="bi bi-motherboard text-3xl"></i>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= $stats['labs_count'] ?></h3>
                <p class="text-xs text-slate-500 font-bold uppercase mt-1 tracking-wide">Laboratorium</p>
            </div>
            <div class="group">
                <div
                    class="w-16 h-16 mx-auto bg-white rounded-2xl border-2 border-slate-100 shadow-sm flex items-center justify-center text-blue-500 mb-4 group-hover:border-blue-200 group-hover:scale-110 transition-all">
                    <i class="bi bi-mortarboard text-3xl"></i>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= $stats['lecturers_count'] ?></h3>
                <p class="text-xs text-slate-500 font-bold uppercase mt-1 tracking-wide">Dosen</p>
            </div>
            <div class="group">
                <div
                    class="w-16 h-16 mx-auto bg-white rounded-2xl border-2 border-slate-100 shadow-sm flex items-center justify-center text-indigo-500 mb-4 group-hover:border-indigo-200 group-hover:scale-110 transition-all">
                    <i class="bi bi-people text-3xl"></i>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= $stats['students_count'] ?></h3>
                <p class="text-xs text-slate-500 font-bold uppercase mt-1 tracking-wide">Mahasiswa</p>
            </div>
            <div class="group">
                <div
                    class="w-16 h-16 mx-auto bg-white rounded-2xl border-2 border-slate-100 shadow-sm flex items-center justify-center text-cyan-500 mb-4 group-hover:border-cyan-200 group-hover:scale-110 transition-all">
                    <i class="bi bi-person-badge text-3xl"></i>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= $stats['assistants_count'] ?></h3>
                <p class="text-xs text-slate-500 font-bold uppercase mt-1 tracking-wide">Asisten Lab</p>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-slate-50 relative overflow-hidden">
    <div
        class="hidden lg:block absolute left-1/2 top-0 bottom-0 w-px border-l-2 border-dashed border-slate-300 -ml-[1px]">
    </div>

    <div class="max-w-6xl mx-auto px-4 relative z-10">
        <div class="text-center mb-20">
            <h2 class="text-3xl md:text-4xl font-extrabold text-blue-600">FASILITAS LABORATORIUM</h2>
            <p class="text-slate-500 mt-2">Sarana penunjang kegiatan praktikum berstandar industri</p>
        </div>

        <div class="space-y-24">
            <?php foreach ($labs as $index => $lab): ?>
                <?php
                $isEven = ($index % 2 == 0);

                // LOGIKA GAMBAR: Cek DB -> Cek Path -> Placeholder
                if (!empty($lab['image'])) {
                    if (strpos($lab['image'], 'http') === 0) {
                        $bgImage = $lab['image'];
                    } else {
                        // Pastikan path relative benar
                        $bgImage = BASE_URL . '/' . $lab['image'];
                    }
                } else {
                    $bgImage = "https://placehold.co/800x500/0ea5e9/ffffff?text=" . urlencode($lab['lab_name']);
                }

                $pcCount = $lab['pc_count'] ?? 0;
                $tvCount = $lab['tv_count'] ?? 0;
                ?>

                <div
                    class="flex flex-col lg:flex-row items-center gap-8 lg:gap-20 <?= $isEven ? '' : 'lg:flex-row-reverse' ?>">

                    <div class="w-full lg:w-1/2 relative group">
                        <div
                            class="relative overflow-hidden rounded-2xl shadow-xl border-4 border-white transform transition-transform group-hover:scale-[1.02] duration-500 bg-white">
                            <img src="<?= e($bgImage) ?>" alt="<?= e($lab['lab_name']) ?>" loading="lazy"
                                class="w-full h-auto object-cover aspect-video"
                                onerror="this.src='https://placehold.co/800x500/e2e8f0/64748b?text=No+Image';">

                            <div class="absolute bottom-4 left-4 flex gap-2">
                                <div
                                    class="bg-white/90 backdrop-blur px-3 py-2 rounded-lg shadow-sm text-center min-w-[60px]">
                                    <span class="block text-lg font-bold text-slate-800"><?= $pcCount ?></span>
                                    <span class="block text-[10px] font-bold text-slate-500 uppercase">Komputer</span>
                                </div>
                                <div
                                    class="bg-white/90 backdrop-blur px-3 py-2 rounded-lg shadow-sm text-center min-w-[60px]">
                                    <span class="block text-lg font-bold text-slate-800"><?= $tvCount ?></span>
                                    <span class="block text-[10px] font-bold text-slate-500 uppercase">TV</span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="hidden lg:block absolute top-1/2 <?= $isEven ? '-right-[50px] translate-x-1/2' : '-left-[50px] -translate-x-1/2' ?> w-6 h-6 rounded-full bg-blue-500 border-4 border-white shadow-md z-20">
                        </div>
                    </div>

                    <div class="w-full lg:w-1/2 <?= $isEven ? 'text-left lg:text-left' : 'text-left lg:text-right' ?>">
                        <h3 class="text-2xl md:text-3xl font-extrabold text-slate-800 mb-4"><?= e($lab['lab_name']) ?></h3>
                        <p class="text-slate-600 leading-relaxed text-lg mb-6">
                            <?= e($lab['description'] ?? 'Laboratorium modern yang dilengkapi dengan spesifikasi hardware tinggi untuk menunjang kegiatan praktikum mahasiswa.') ?>
                        </p>
                        <div
                            class="flex items-center gap-2 text-slate-500 font-medium <?= $isEven ? 'justify-start' : 'justify-start lg:justify-end' ?>">
                            <i class="bi bi-geo-alt-fill text-sky-500"></i> <?= e($lab['location']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-center text-3xl font-bold text-blue-600 mb-12 uppercase tracking-wide">Kegiatan Terbaru</h2>
        <div class="grid gap-8 md:grid-cols-3">
            <?php if (!empty($activities)): ?>
                <?php foreach ($activities as $news): ?>
                    <article
                        class="group bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">
                        <div class="relative h-48 overflow-hidden">
                            <img src="<?= $news['image_cover'] ?? 'https://placehold.co/600x400/e2e8f0/94a3b8?text=News' ?>"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                                loading="lazy">
                            <div class="absolute top-3 left-3">
                                <span
                                    class="bg-blue-600 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">
                                    <?= getActivityTypeLabel($news['activity_type']) ?>
                                </span>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-1">
                            <div class="text-xs font-bold text-slate-400 mb-2 uppercase tracking-wide">
                                <?= date('d F Y', strtotime($news['activity_date'])) ?>
                            </div>
                            <h3
                                class="text-lg font-bold text-slate-800 mb-3 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                <a href="#"><?= e($news['title']) ?></a>
                            </h3>
                            <p class="text-slate-500 text-sm line-clamp-3 mb-4 flex-1">
                                <?= e($news['description']) ?>
                            </p>
                            <a href="#" class="inline-flex items-center text-blue-600 font-bold text-sm hover:underline">
                                Baca Selengkapnya <i class="bi bi-arrow-right ml-1"></i>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-3 text-center py-10 text-slate-400">Belum ada kegiatan terbaru.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Real-time Schedule Status Highlight
        function updateScheduleStatus() {
            const now = new Date();
            const currentTime = now.toTimeString().split(' ')[0];

            const rows = document.querySelectorAll('.schedule-row');
            rows.forEach(row => {
                const start = row.getAttribute('data-start');
                const end = row.getAttribute('data-end');
                const badge = row.querySelector('.status-badge');

                if (currentTime >= start && currentTime <= end) {
                    // ACTIVE (Sedang Berlangsung)
                    row.classList.add('bg-blue-50', 'border-l-4', 'border-l-blue-500');
                    badge.className =
                        'status-badge px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 animate-pulse';
                    badge.innerHTML = '<i class="bi bi-record-circle-fill mr-1"></i> BERLANGSUNG';
                } else if (currentTime > end) {
                    // COMPLETED (Selesai)
                    row.classList.remove('bg-blue-50', 'border-l-4', 'border-l-blue-500');
                    row.classList.add('opacity-50', 'bg-slate-50');
                    badge.className =
                        'status-badge px-3 py-1 rounded-full text-xs font-bold bg-slate-200 text-slate-500';
                    badge.textContent = 'Selesai';
                } else {
                    // UPCOMING (Menunggu)
                    row.classList.remove('bg-blue-50', 'border-l-4', 'border-l-blue-500', 'opacity-50');
                    badge.className =
                        'status-badge px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500';
                    badge.textContent = 'Menunggu';
                }
            });
        }

        updateScheduleStatus();
        setInterval(updateScheduleStatus, 60000); // Cek tiap 1 menit
    });
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>