<?php $title = 'Detail Praktikum - ' . e($schedule['course_name']); ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-gray-50 min-h-screen pb-12">
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-screen-xl mx-auto px-4 py-4">
            <a href="<?= url('/schedule') ?>"
                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-primary transition-colors">
                <i class="bi bi-arrow-left mr-2"></i> Kembali ke Jadwal
            </a>
        </div>
    </div>

    <div class="max-w-screen-xl mx-auto px-4 py-8">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-8 relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 -mr-16 -mt-16">
            </div>

            <div class="relative z-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <span
                            class="bg-blue-100 text-primary text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide mb-2 inline-block">
                            <?= e($schedule['program_study'] ?? 'Umum') ?>
                        </span>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">
                            <?= e($schedule['course_name']) ?></h1>
                        <div class="flex items-center text-gray-500 text-lg">
                            <i class="bi bi-geo-alt-fill mr-2 text-red-500"></i>
                            <?= e($schedule['lab_name']) ?> <span class="mx-2">•</span>
                            <?= e($schedule['location'] ?? '-') ?>
                        </div>
                    </div>
                    <div class="text-right hidden md:block">
                        <div class="text-4xl font-bold text-primary"><?= e($schedule['class_code']) ?></div>
                        <div class="text-sm text-gray-500 uppercase font-medium">Kode Kelas</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <i class="bi bi-info-circle text-primary mr-3"></i> Informasi Praktikum
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-sm text-gray-500 block mb-1">Hari & Waktu</span>
                            <div class="font-bold text-gray-900 text-lg">
                                <?= getDayName($schedule['day']) ?>
                            </div>
                            <div class="text-primary font-medium">
                                <?= formatTime($schedule['start_time']) ?> - <?= formatTime($schedule['end_time']) ?>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-sm text-gray-500 block mb-1">Frekuensi Pertemuan</span>
                            <div class="font-bold text-gray-900 text-lg">
                                <?= e($schedule['frequency'] ?? 'Mingguan') ?>
                            </div>
                            <div class="text-gray-400 text-sm">Rutin</div>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-sm text-gray-500 block mb-1">Semester</span>
                            <div class="font-bold text-gray-900 text-lg">
                                Semester <?= e($schedule['semester'] ?? '-') ?>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl">
                            <span class="text-sm text-gray-500 block mb-1">Jumlah Peserta</span>
                            <div class="font-bold text-gray-900 text-lg">
                                <?= e($schedule['participant_count'] ?? '-') ?> Mahasiswa
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($schedule['description'])): ?>
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <h4 class="font-bold text-gray-900 mb-2">Deskripsi Mata Kuliah</h4>
                        <p class="text-gray-600 leading-relaxed">
                            <?= nl2br(e($schedule['description'])) ?>
                        </p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Dosen Pengampu</h3>

                    <div class="relative w-32 h-32 mx-auto mb-4">
                        <img src="<?= !empty($schedule['lecturer_photo']) ? $schedule['lecturer_photo'] : 'https://ui-avatars.com/api/?name=' . urlencode($schedule['lecturer_name']) . '&background=random' ?>"
                            alt="Dosen" class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg">
                        <div
                            class="absolute bottom-1 right-1 bg-blue-500 text-white p-1 rounded-full shadow-sm border-2 border-white">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <h4 class="text-lg font-bold text-gray-900 mb-1"><?= e($schedule['lecturer_name']) ?></h4>
                    <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">Dosen</span>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6 text-center">Tim Asisten
                    </h3>

                    <div class="space-y-6">
                        <div class="flex items-center space-x-4">
                            <img src="<?= !empty($schedule['assistant_1_photo']) ? $schedule['assistant_1_photo'] : 'https://ui-avatars.com/api/?name=' . urlencode($schedule['assistant_1_name']) . '&background=random' ?>"
                                class="w-12 h-12 rounded-full object-cover shadow-sm border border-gray-200">
                            <div>
                                <h5 class="font-bold text-gray-900 text-sm"><?= e($schedule['assistant_1_name']) ?></h5>
                                <span class="text-xs text-primary font-medium">Asisten Utama (1)</span>
                            </div>
                        </div>

                        <?php if (!empty($schedule['assistant_2_name']) && $schedule['assistant_2_name'] !== '-'): ?>
                        <div class="flex items-center space-x-4 pt-4 border-t border-gray-50">
                            <img src="<?= !empty($schedule['assistant_2_photo']) ? $schedule['assistant_2_photo'] : 'https://ui-avatars.com/api/?name=' . urlencode($schedule['assistant_2_name']) . '&background=random' ?>"
                                class="w-12 h-12 rounded-full object-cover shadow-sm border border-gray-200">
                            <div>
                                <h5 class="font-bold text-gray-900 text-sm"><?= e($schedule['assistant_2_name']) ?></h5>
                                <span class="text-xs text-purple-600 font-medium">Asisten Pendamping (2)</span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-primary to-blue-700 rounded-2xl shadow-lg p-6 text-white text-center">
                    <i class="bi bi-door-open text-4xl mb-2 block opacity-80"></i>
                    <h3 class="font-bold mb-1">Status Ruangan</h3>
                    <p class="text-blue-100 text-sm">Laboratorium Digunakan</p>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>