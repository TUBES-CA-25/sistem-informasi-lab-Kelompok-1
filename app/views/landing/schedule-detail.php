<?php
$title = 'Detail Praktikum - ' . e($schedule['course_name']);

// Helper URL Foto (Tetap dipakai agar logika foto aman)
function getPhotoUrl($url, $name)
{
    if (!empty($url)) {
        if (strpos($url, 'http') === 0) return $url;
        return BASE_URL . '/' . ltrim($url, '/');
    }
    return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=f1f5f9&color=475569&size=128';
}
?>

<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen pb-12">

    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

                <div>
                    <a href="<?= url('/schedule') ?>"
                        class="text-sm font-medium text-slate-500 hover:text-blue-600 mb-2 inline-flex items-center gap-2">
                        <i class="bi bi-arrow-left"></i> Kembali ke Jadwal
                    </a>
                    <h1 class="text-2xl md:text-3xl font-bold text-slate-900 mt-1">
                        <?= e($schedule['course_name']) ?>
                    </h1>
                    <div class="flex items-center gap-3 mt-3 text-sm text-slate-600">
                        <span class="flex items-center gap-1">
                            <i class="bi bi-mortarboard text-slate-400"></i>
                            <?= e($schedule['program_study'] ?? 'Umum') ?>
                        </span>
                        <span class="text-slate-300">&bull;</span>
                        <span class="flex items-center gap-1">
                            <i class="bi bi-bookmarks text-slate-400"></i>
                            Semester <?= e($schedule['semester'] ?? '-') ?>
                        </span>
                    </div>
                </div>

                <div class="flex-shrink-0">
                    <div class="bg-blue-50 border border-blue-100 rounded-lg px-5 py-3 text-center">
                        <span class="block text-xs font-bold text-blue-600 uppercase tracking-wider">Kelas</span>
                        <span class="block text-2xl font-black text-blue-700"><?= e($schedule['class_code']) ?></span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h3 class="font-bold text-slate-800">Detail Pelaksanaan</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                    <i class="bi bi-clock text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-500">Waktu</p>
                                    <p class="text-lg font-bold text-slate-900"><?= getDayName($schedule['day']) ?></p>
                                    <p class="text-slate-700">
                                        <?= formatTime($schedule['start_time']) ?> -
                                        <?= formatTime($schedule['end_time']) ?> WITA
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div
                                    class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                    <i class="bi bi-geo-alt text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-slate-500">Laboratorium</p>
                                    <p class="text-lg font-bold text-slate-900"><?= e($schedule['lab_name']) ?></p>
                                    <?php if (!empty($schedule['location'])): ?>
                                    <p class="text-slate-600 text-sm"><?= e($schedule['location']) ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800">Catatan / Deskripsi</h3>
                    </div>
                    <div class="p-6">
                        <?php if (!empty($schedule['description'])): ?>
                        <div class="prose prose-sm max-w-none text-slate-600">
                            <?= nl2br(e($schedule['description'])) ?>
                        </div>
                        <?php else: ?>
                        <p class="text-slate-400 italic text-sm">Tidak ada catatan tambahan.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="space-y-6">

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Dosen Pengampu</h3>
                        <div class="flex items-center gap-4">
                            <img src="<?= getPhotoUrl($schedule['lecturer_photo'], $schedule['lecturer_name']) ?>"
                                alt="Dosen" class="w-14 h-14 rounded-full object-cover border border-slate-200">
                            <div>
                                <h4 class="font-bold text-slate-900 leading-tight"><?= e($schedule['lecturer_name']) ?>
                                </h4>
                                <span
                                    class="inline-block mt-1 px-2 py-0.5 bg-slate-100 text-slate-600 text-xs rounded font-medium">Lecturer</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Tim Asisten</h3>
                        <div class="space-y-4">

                            <div class="flex items-center gap-3">
                                <img src="<?= getPhotoUrl($schedule['assistant_1_photo'], $schedule['assistant_1_name']) ?>"
                                    class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                <div class="overflow-hidden">
                                    <p class="text-sm font-bold text-slate-900 truncate">
                                        <?= e($schedule['assistant_1_name']) ?></p>
                                    <p class="text-xs text-blue-600 font-medium">Asisten Utama</p>
                                </div>
                            </div>

                            <?php if (!empty($schedule['assistant_2_name']) && $schedule['assistant_2_name'] !== '-'): ?>
                            <div class="flex items-center gap-3 pt-3 border-t border-slate-50">
                                <img src="<?= getPhotoUrl($schedule['assistant_2_photo'], $schedule['assistant_2_name']) ?>"
                                    class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                <div class="overflow-hidden">
                                    <p class="text-sm font-bold text-slate-900 truncate">
                                        <?= e($schedule['assistant_2_name']) ?></p>
                                    <p class="text-xs text-purple-600 font-medium">Asisten Pendamping</p>
                                </div>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

                <div class="bg-slate-800 rounded-xl shadow-sm p-5 text-white flex items-center justify-between">
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-1">Status Lab</p>
                        <p class="font-bold text-lg">Digunakan</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center">
                        <i class="bi bi-door-open-fill text-xl text-emerald-400"></i>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>