<?php $title = 'Home - ICLABS'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<section class="relative bg-white overflow-hidden pt-4 pb-12">
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-sky-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
    <div class="absolute top-0 left-0 -ml-20 -mt-20 w-[500px] h-[500px] bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <div id="hero-carousel" class="relative w-full" data-carousel="slide" data-carousel-interval="10000">

            <div class="relative h-[650px] md:h-[550px] overflow-hidden rounded-2xl">

                <div class="hidden duration-1000 ease-in-out" data-carousel-item="active">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center h-full px-12 md:px-20">
                        <div class="space-y-6 text-center lg:text-left pt-10 lg:pt-0">
                            <div>
                                <h2 class="text-sky-500 font-bold tracking-widest text-sm uppercase mb-2">SISTEM INFORMASI</h2>
                                <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 leading-tight">
                                    ICLABS <br>
                                    <span class="text-2xl md:text-3xl font-bold text-slate-600 block mt-2">Fakultas Ilmu Komputer</span>
                                    <span class="text-xl md:text-2xl font-medium text-slate-500 block">Universitas Muslim Indonesia</span>
                                </h1>
                            </div>
                            <p class="text-slate-500 text-lg leading-relaxed max-w-lg mx-auto lg:mx-0">
                                Platform monitoring sistem informasi laboratorium terpadu untuk manajemen praktikum yang efisien dan transparan.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                <a href="<?= url('/schedule') ?>" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-full shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-transform hover:-translate-y-1">
                                    Lihat Jadwal
                                </a>
                                <a href="<?= url('/login') ?>" class="px-8 py-3 bg-white text-blue-600 border-2 border-blue-100 font-bold rounded-full hover:border-blue-600 transition-all">
                                    Login Portal
                                </a>
                            </div>
                        </div>
                        <div class="hidden lg:flex justify-center items-center">
                            <img src="<?= BASE_URL ?>/assets/images/logo-iclabs.png" alt="ICLABS Tech" class="relative z-10 w-full max-w-md animate-float" onerror="this.src='https://cdn-icons-png.flaticon.com/512/2083/2083213.png'">
                        </div>
                    </div>
                </div>

                <?php foreach ($labSlides as $index => $slide): ?>
                <div class="hidden duration-1000 ease-in-out" data-carousel-item>
                    <div class="h-full flex flex-col pt-8 px-4 md:px-20">

                        <div class="text-center mb-6">
                            <h2 class="text-xl font-bold text-slate-400 tracking-widest uppercase">JADWAL HARI INI</h2>
                            <div class="flex items-center justify-center gap-2 mt-1">
                                <span class="text-3xl md:text-5xl font-black text-slate-800 uppercase">
                                    <?= e($slide['lab_info']['lab_name']) ?>
                                </span>
                            </div>
                            <div class="mt-2 inline-block bg-sky-50 text-sky-600 px-4 py-1 rounded-full text-sm font-bold border border-sky-100 shadow-sm">
                                <?= $currentDayName ?>, <?= $currentDate ?>
                            </div>
                        </div>

                        <div class="w-full max-w-5xl mx-auto bg-white/10 backdrop-blur-md rounded-2xl border border-white/40 shadow-xl overflow-hidden flex-1 mb-8 relative">
                            <div class="overflow-y-auto h-full absolute inset-0 custom-scrollbar p-2">
                                
                                <div class="grid grid-cols-12 gap-4 bg-slate-900/5 backdrop-blur-sm p-4 rounded-xl mb-3 text-xs font-bold uppercase text-slate-600 sticky top-0 z-10 hidden md:grid border border-slate-200/50">
                                    <div class="col-span-2 text-center tracking-wider">Waktu</div>
                                    <div class="col-span-3 tracking-wider pl-2">Mata Kuliah</div>
                                    <div class="col-span-5 tracking-wider pl-2">Tim Pengajar</div>
                                    <div class="col-span-2 text-center tracking-wider">Status</div>
                                </div>

                                <?php if (empty($slide['schedules'])): ?>
                                <div class="flex flex-col items-center justify-center h-64 text-slate-400">
                                    <i class="bi bi-calendar-check text-4xl mb-3 opacity-50"></i>
                                    <p class="font-medium">Tidak ada jadwal praktikum di ruangan ini.</p>
                                </div>
                                <?php else: ?>
                                <div class="space-y-3">
                                    <?php foreach ($slide['schedules'] as $sch): ?>
                                    <div class="schedule-row group bg-white/60 hover:bg-white/90 transition-all rounded-xl border border-white/60 p-4 md:p-4 grid grid-cols-1 md:grid-cols-12 gap-4 items-center shadow-sm"
                                        data-start="<?= $sch['start_time'] ?>" data-end="<?= $sch['end_time'] ?>">

                                        <div class="md:col-span-2 text-center flex md:block items-center justify-between">
                                            <div class="md:hidden text-xs font-bold text-slate-500 uppercase">Waktu</div>
                                            <div class="font-mono font-bold text-slate-700 bg-white/80 border border-slate-100 px-3 py-1.5 rounded-lg inline-block shadow-sm">
                                                <?= formatTime($sch['start_time']) ?> - <?= formatTime($sch['end_time']) ?>
                                            </div>
                                        </div>

                                        <div class="md:col-span-3 pl-2">
                                            <h3 class="font-bold text-slate-900 leading-tight text-base mb-1">
                                                <?= e($sch['course_name']) ?>
                                            </h3>
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold text-sky-700 bg-sky-50 px-2.5 py-1 rounded-md border border-sky-100">
                                                <i class="bi bi-people-fill"></i> Kelas <?= e($sch['class_code']) ?>
                                            </span>
                                        </div>

                                        <div class="md:col-span-5 pl-2 flex flex-col justify-center gap-3">
                                            <div class="flex items-center gap-3">
                                                <?php if (!empty($sch['lecturer_photo'])): ?>
                                                    <img src="<?= e($sch['lecturer_photo']) ?>" class="w-9 h-9 rounded-full object-cover border-2 border-white shadow-sm shrink-0">
                                                <?php else: ?>
                                                    <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center text-[10px] font-bold text-indigo-600 border-2 border-white shadow-sm shrink-0">DS</div>
                                                <?php endif; ?>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-bold text-slate-800 truncate leading-snug"><?= e($sch['lecturer_name']) ?></p>
                                                    <p class="text-[10px] text-slate-500 font-medium uppercase tracking-wide">Dosen Pengampu</p>
                                                </div>
                                            </div>

                                            <?php if (!empty($sch['assistant1_name'])): ?>
                                            <div class="flex items-center gap-3 relative pl-1">
                                                <div class="absolute left-4 -top-4 w-0.5 h-3 bg-slate-200"></div>
                                                <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center text-[9px] font-bold text-emerald-600 border border-emerald-200 shrink-0 ml-1">AS</div>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-bold text-slate-700 truncate leading-snug"><?= e($sch['assistant1_name']) ?></p>
                                                    <p class="text-[10px] text-slate-500 font-medium uppercase tracking-wide">Asisten 1</p>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                        </div>

                                        <div class="md:col-span-2 text-center mt-2 md:mt-0 flex justify-between md:block items-center">
                                            <span class="md:hidden text-xs font-bold text-slate-500 uppercase">Status</span>
                                            <span class="status-badge px-3 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200 shadow-sm uppercase tracking-wider block w-fit mx-auto">
                                                Menunggu
                                            </span>
                                        </div>

                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>
                <?php endforeach; ?>

            </div>

            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white text-slate-500 hover:text-sky-600 shadow-sm backdrop-blur-md transition-all">
                    <i class="bi bi-chevron-left text-xl"></i>
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 hover:bg-white text-slate-500 hover:text-sky-600 shadow-sm backdrop-blur-md transition-all">
                    <i class="bi bi-chevron-right text-xl"></i>
                </span>
            </button>
        </div>
    </div>
</section>

<section class="py-12 bg-white border-b border-slate-100">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-center text-sky-500 font-bold tracking-widest text-sm uppercase mb-10">SUMBER DAYA</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="group">
                <div class="w-16 h-16 mx-auto bg-white rounded-2xl border-2 border-slate-100 shadow-sm flex items-center justify-center text-sky-500 mb-4 group-hover:border-sky-200 group-hover:scale-110 transition-all">
                    <i class="bi bi-motherboard text-3xl"></i>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= $stats['labs_count'] ?></h3>
                <p class="text-xs text-slate-500 font-bold uppercase mt-1 tracking-wide">Laboratorium</p>
            </div>
            <div class="group">
                <div class="w-16 h-16 mx-auto bg-white rounded-2xl border-2 border-slate-100 shadow-sm flex items-center justify-center text-blue-500 mb-4 group-hover:border-blue-200 group-hover:scale-110 transition-all">
                    <i class="bi bi-mortarboard text-3xl"></i>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= $stats['lecturers_count'] ?></h3>
                <p class="text-xs text-slate-500 font-bold uppercase mt-1 tracking-wide">Dosen</p>
            </div>
            <div class="group">
                <div class="w-16 h-16 mx-auto bg-white rounded-2xl border-2 border-slate-100 shadow-sm flex items-center justify-center text-indigo-500 mb-4 group-hover:border-indigo-200 group-hover:scale-110 transition-all">
                    <i class="bi bi-people text-3xl"></i>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= $stats['students_count'] ?></h3>
                <p class="text-xs text-slate-500 font-bold uppercase mt-1 tracking-wide">Mahasiswa</p>
            </div>
            <div class="group">
                <div class="w-16 h-16 mx-auto bg-white rounded-2xl border-2 border-slate-100 shadow-sm flex items-center justify-center text-cyan-500 mb-4 group-hover:border-cyan-200 group-hover:scale-110 transition-all">
                    <i class="bi bi-person-badge text-3xl"></i>
                </div>
                <h3 class="text-3xl font-extrabold text-slate-800"><?= $stats['assistants_count'] ?></h3>
                <p class="text-xs text-slate-500 font-bold uppercase mt-1 tracking-wide">Asisten Lab</p>
            </div>
        </div>
    </div>
</section>

<section id="sarana" class="py-20 bg-slate-50 relative overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 relative z-10">
        <div class="text-center mb-16">
            <h2 class="text-sky-500 font-bold tracking-widest text-sm uppercase mb-2">FASILITAS LABORATORIUM</h2>
            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">Sarana Penunjang Praktikum</h2>
        </div>

        <div class="relative">
            <div class="absolute left-8 md:left-1/2 top-0 bottom-0 w-1 border-r-4 border-dashed border-slate-300 transform md:-translate-x-1/2 h-full z-0"></div>

            <div class="space-y-24">
                <?php foreach ($labs as $index => $lab): ?>
                <?php
                    $isEven = ($index % 2 == 0);
                    if (!empty($lab['image'])) {
                        $bgImage = (strpos($lab['image'], 'http') === 0) ? $lab['image'] : BASE_URL . '/' . $lab['image'];
                    } else {
                        $bgImage = "https://placehold.co/800x500/0ea5e9/ffffff?text=" . urlencode($lab['lab_name']);
                    }
                ?>
                <div class="relative flex flex-col md:flex-row items-center justify-between w-full z-10">
                    <div class="absolute left-8 md:left-1/2 transform -translate-x-1/2 w-8 h-8 rounded-full bg-white border-4 border-sky-500 shadow-lg z-20 flex items-center justify-center">
                        <div class="w-3 h-3 bg-sky-500 rounded-full"></div>
                    </div>
                    <div class="w-full md:w-[48%] pl-20 md:pl-0 <?= $isEven ? 'md:text-right order-2 md:order-1 pr-0 md:pr-6' : 'order-2 md:order-3 pl-0 md:pl-6' ?>">
                        <h3 class="text-2xl md:text-3xl font-extrabold text-slate-900 mb-4"><?= e($lab['lab_name']) ?></h3>
                        <p class="text-slate-600 leading-relaxed mb-6"><?= e($lab['description'] ?? 'Laboratorium dengan spesifikasi tinggi.') ?></p>
                        <div class="flex items-center gap-4 justify-start <?= $isEven ? 'md:justify-end' : '' ?>">
                            <div class="text-center group">
                                <div class="w-16 py-2 bg-slate-200 rounded-t-lg text-xl font-black text-slate-800 group-hover:bg-sky-500 group-hover:text-white transition-colors"><?= $lab['pc_count'] ?? 0 ?></div>
                                <div class="w-16 py-1 bg-slate-100 border-t border-slate-300 rounded-b-lg text-[10px] font-bold text-slate-500 uppercase">PC</div>
                            </div>
                            <div class="text-center group">
                                <div class="w-16 py-2 bg-blue-100 rounded-t-lg text-xl font-black text-slate-800 group-hover:bg-blue-600 group-hover:text-white transition-colors"><?= $lab['tv_count'] ?? 0 ?></div>
                                <div class="w-16 py-1 bg-slate-50 border-t border-slate-200 rounded-b-lg text-[10px] font-bold text-slate-500 uppercase">LCD</div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-[48%] pl-20 md:pl-0 mb-6 md:mb-0 <?= $isEven ? 'order-1 md:order-3 pl-0 md:pl-6' : 'order-1 md:order-1 pr-0 md:pr-6' ?>">
                        <div class="relative group rounded-2xl shadow-xl overflow-hidden border-4 border-white transform transition-transform duration-500 hover:scale-[1.02]">
                            <img src="<?= e($bgImage) ?>" alt="<?= e($lab['lab_name']) ?>" loading="lazy" class="w-full h-auto object-cover aspect-video">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section id="activity" class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <a href="<?= url('/activities') ?>" class="block text-center mb-12 group">
            <h2 class="text-3xl font-bold text-blue-600 uppercase tracking-wide group-hover:text-blue-700 transition-colors inline-flex items-center gap-2">
                Kegiatan Terbaru
            </h2>
        </a>

        <div class="grid gap-8 md:grid-cols-3">
            <?php
            $hasActivities = false;
            if (!empty($activities)):
                foreach ($activities as $news):
                    if (($news['status'] ?? 'published') !== 'published') continue;
                    $hasActivities = true;
            ?>
            <article class="flex flex-col bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group h-full">
                <a href="<?= url('/activity/' . $news['id']) ?>" class="relative h-56 overflow-hidden block">
                    <?php 
                    $imageSrc = 'https://placehold.co/600x400/e2e8f0/94a3b8?text=No+Image';
                    if (!empty($news['image_cover'])) {
                        $imageSrc = (strpos($news['image_cover'], 'http') === 0) ? $news['image_cover'] : BASE_URL . $news['image_cover'];
                    }
                    ?>
                    <img src="<?= e($imageSrc) ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700" alt="<?= e($news['title']) ?>" loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60"></div>
                    <div class="absolute top-4 left-4 flex gap-2">
                        <span class="bg-white/90 backdrop-blur-md text-blue-700 text-[10px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-wider shadow-sm border border-white/50">
                            <?= getActivityTypeLabel($news['activity_type']) ?>
                        </span>
                    </div>
                </a>
                <div class="p-6 flex flex-col flex-1 relative">
                    <div class="absolute -top-5 right-6 bg-blue-600 text-white text-xs font-bold px-3 py-2 rounded-lg shadow-lg flex flex-col items-center border-2 border-white">
                        <span class="text-lg leading-none"><?= date('d', strtotime($news['activity_date'])) ?></span>
                        <span class="uppercase text-[10px]"><?= date('M', strtotime($news['activity_date'])) ?></span>
                    </div>
                    <div class="mt-2 mb-3">
                        <h3 class="text-xl font-bold text-slate-900 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                            <a href="<?= url('/activity/' . $news['id']) ?>"><?= e($news['title']) ?></a>
                        </h3>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6 line-clamp-3 flex-1"><?= e($news['description']) ?></p>
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-between mt-auto">
                        <span class="text-xs text-slate-400 font-medium flex items-center gap-1">
                            <i class="bi bi-clock"></i> <?= date('Y', strtotime($news['activity_date'])) ?>
                        </span>
                        <a href="<?= url('/activity/' . $news['id']) ?>" class="inline-flex items-center text-blue-600 font-bold text-sm hover:gap-2 gap-1 transition-all group">
                            Baca Selengkapnya<i class="bi bi-arrow-right transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
            <?php endif; ?>

            <?php if (!$hasActivities): ?>
            <div class="col-span-3 text-center py-10">
                <i class="bi bi-journal-x text-4xl text-slate-300 mb-2 block"></i>
                <p class="text-slate-500">Belum ada kegiatan terbaru.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateScheduleStatus() {
        const now = new Date();
        const currentTime = now.toTimeString().split(' ')[0];
        const rows = document.querySelectorAll('.schedule-row');
        rows.forEach(row => {
            const start = row.getAttribute('data-start');
            const end = row.getAttribute('data-end');
            const badge = row.querySelector('.status-badge');
            if (currentTime >= start && currentTime <= end) {
                row.classList.add('bg-blue-50/50', 'border-l-4', 'border-l-blue-500');
                row.classList.remove('opacity-50', 'grayscale');
                if (badge) {
                    // PERBAIKAN: w-fit agar tidak terlalu lebar
                    badge.className = 'status-badge px-3 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 animate-pulse border border-blue-200 uppercase tracking-wider block w-fit mx-auto';
                    badge.innerHTML = '<i class="bi bi-record-circle-fill mr-1"></i> Berlangsung';
                }
            } else if (currentTime > end) {
                row.classList.remove('bg-blue-50/50', 'border-l-4', 'border-l-blue-500');
                row.classList.add('opacity-50', 'grayscale');
                if (badge) {
                    // PERBAIKAN: w-fit agar tidak terlalu lebar
                    badge.className = 'status-badge px-3 py-1 rounded-full text-[10px] font-bold bg-slate-200 text-slate-500 border border-slate-300 uppercase tracking-wider block w-fit mx-auto';
                    badge.textContent = 'Selesai';
                }
            } else {
                row.classList.remove('bg-blue-50/50', 'border-l-4', 'border-l-blue-500', 'opacity-50', 'grayscale');
                if (badge) {
                    // PERBAIKAN: w-fit agar tidak terlalu lebar
                    badge.className = 'status-badge px-3 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200 shadow-sm uppercase tracking-wider block w-fit mx-auto';
                    badge.textContent = 'Menunggu';
                }
            }
        });
    }
    updateScheduleStatus();
    setInterval(updateScheduleStatus, 60000);
});
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>