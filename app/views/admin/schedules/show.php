<?php $title = 'Detail Schedule'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">

    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-10">
        <div class="max-w-4xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <div class="flex items-center gap-2">
                    <a href="<?= url('/admin/schedules') ?>" class="text-slate-500 hover:text-sky-600">
                        <i class="bi bi-arrow-left text-xl"></i>
                    </a>
                    <h1 class="text-2xl font-bold text-slate-800">Detail Jadwal</h1>
                </div>
                <div class="flex gap-2">
                    <a href="<?= url('/admin/schedules/' . $schedule['id'] . '/edit') ?>" class="text-white bg-amber-500 hover:bg-amber-600 font-medium rounded-lg text-sm px-4 py-2">
                        <i class="bi bi-pencil-square mr-1"></i> Edit
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">

                <div class="bg-sky-50 px-6 py-6 border-b border-sky-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="bg-sky-600 text-white text-xs font-bold px-2 py-1 rounded uppercase tracking-wider mb-2 inline-block">
                                <?= e($schedule['program_study']) ?>
                            </span>
                            <h2 class="text-3xl font-bold text-slate-900 mb-1"><?= e($schedule['course']) ?></h2>
                            <p class="text-slate-600 font-medium">
                                Kode Unik: <span class="font-mono text-slate-800"><?= e($schedule['frequency']) ?></span>
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-sky-600"><?= e($schedule['class_code']) ?></div>
                            <div class="text-sm text-slate-500">Kelas</div>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <div class="space-y-4">
                            <h3 class="font-bold text-slate-800 border-b pb-2 mb-3">Waktu & Tempat</h3>

                            <div class="flex items-center text-slate-700">
                                <i class="bi bi-calendar-event w-8 text-sky-500 text-lg"></i>
                                <div>
                                    <span class="block text-xs text-slate-400">Hari</span>
                                    <span class="font-semibold"><?= getDayName($schedule['day']) ?></span>
                                </div>
                            </div>

                            <div class="flex items-center text-slate-700">
                                <i class="bi bi-clock w-8 text-sky-500 text-lg"></i>
                                <div>
                                    <span class="block text-xs text-slate-400">Jam</span>
                                    <span class="font-semibold"><?= formatTime($schedule['start_time']) ?> - <?= formatTime($schedule['end_time']) ?></span>
                                </div>
                            </div>

                            <div class="flex items-center text-slate-700">
                                <i class="bi bi-geo-alt w-8 text-sky-500 text-lg"></i>
                                <div>
                                    <span class="block text-xs text-slate-400">Laboratorium</span>
                                    <span class="font-semibold"><?= e($schedule['lab_name']) ?></span>
                                    <span class="block text-xs text-slate-500"><?= e($schedule['location']) ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="font-bold text-slate-800 border-b pb-2 mb-3">Info Akademik</h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <span class="block text-xs text-slate-400">Semester</span>
                                    <span class="font-semibold text-slate-800 text-lg"><?= e($schedule['semester']) ?></span>
                                </div>
                                <div>
                                    <span class="block text-xs text-slate-400">Mahasiswa</span>
                                    <span class="font-semibold text-slate-800 text-lg"><?= e($schedule['participant_count']) ?> Org</span>
                                </div>
                            </div>

                            <div class="bg-slate-50 p-3 rounded-lg border border-slate-100">
                                <span class="block text-xs text-slate-400 mb-1">Deskripsi</span>
                                <p class="text-sm text-slate-600 leading-relaxed">
                                    <?= e($schedule['description'] ?? 'Tidak ada deskripsi.') ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8">
                        <h3 class="font-bold text-slate-800 border-b pb-2 mb-4">Tim Pengajar</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="text-center p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                                <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden bg-slate-100 border-2 border-slate-200">
                                    <?php if (!empty($schedule['lecturer_photo'])): ?>
                                        <img src="<?= e($schedule['lecturer_photo']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-slate-300 text-3xl font-bold">DS</div>
                                    <?php endif; ?>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm"><?= e($schedule['lecturer']) ?></h4>
                                <span class="text-xs text-sky-600 bg-sky-50 px-2 py-0.5 rounded-full">Dosen Pengampu</span>
                            </div>

                            <div class="text-center p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                                <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden bg-slate-100 border-2 border-slate-200">
                                    <?php if (!empty($schedule['assistant_photo'])): ?>
                                        <img src="<?= e($schedule['assistant_photo']) ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-slate-300 text-3xl font-bold">A1</div>
                                    <?php endif; ?>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm"><?= e($schedule['assistant']) ?></h4>
                                <span class="text-xs text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">Asisten Utama</span>
                            </div>

                            <?php if (!empty($schedule['assistant_2'])): ?>
                                <div class="text-center p-4 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="w-24 h-24 mx-auto mb-3 rounded-full overflow-hidden bg-slate-100 border-2 border-slate-200">
                                        <?php if (!empty($schedule['assistant2_photo'])): ?>
                                            <img src="<?= e($schedule['assistant2_photo']) ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-slate-300 text-3xl font-bold">A2</div>
                                        <?php endif; ?>
                                    </div>
                                    <h4 class="font-bold text-slate-800 text-sm"><?= e($schedule['assistant_2']) ?></h4>
                                    <span class="text-xs text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full">Asisten Pendamping</span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</div>