<?php $title = 'Manajemen Jadwal'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Jadwal Praktikum</h1>
                    <p class="text-slate-500 text-sm mt-1">Kelola jadwal laboratorium akademik semester ini.</p>
                </div>

                <a href="<?= url('/admin/schedules/create') ?>"
                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl shadow-lg shadow-primary-500/30 transition-all transform hover:-translate-y-0.5 focus:ring-4 focus:ring-primary-100">
                    <i class="bi bi-plus-lg text-lg"></i>
                    <span>Buat Jadwal Baru</span>
                </a>
            </div>

            <?php displayFlash(); ?>

            <div
                class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden min-h-[600px] flex flex-col">

                <div class="px-6 py-3 border-b border-slate-100 bg-slate-50/50 flex gap-2 overflow-x-auto">
                    <?php $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']; ?>
                    <?php foreach ($days as $d): ?>
                    <span
                        class="px-3 py-1 rounded-full bg-white border border-slate-200 text-xs font-medium text-slate-600 shadow-sm">
                        <?= getDayName($d) ?>
                    </span>
                    <?php endforeach; ?>
                </div>

                <div class="overflow-x-auto w-full">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50/80 border-b border-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold w-[20%]">Waktu & Tempat</th>
                                <th scope="col" class="px-6 py-4 font-semibold w-[30%]">Mata Kuliah & Kelas</th>
                                <th scope="col" class="px-6 py-4 font-semibold w-[20%]">Dosen Pengampu</th>
                                <th scope="col" class="px-6 py-4 font-semibold w-[20%]">Tim Asisten</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right w-[10%]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($schedules)): ?>
                            <?php foreach ($schedules as $schedule): ?>
                            <tr class="group hover:bg-slate-50/80 transition-colors duration-200">

                                <td class="px-6 py-4 align-top">
                                    <div class="flex flex-col gap-2">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary-50 text-primary-600 font-bold text-xs uppercase shadow-sm border border-primary-100">
                                                <?= substr(getDayName($schedule['day']), 0, 3) ?>
                                            </span>
                                            <div class="flex flex-col">
                                                <span class="text-xs font-bold text-slate-700 uppercase tracking-wide">
                                                    <?= getDayName($schedule['day']) ?>
                                                </span>
                                                <span class="text-xs font-mono text-slate-500">
                                                    <?= formatTime($schedule['start_time']) ?> -
                                                    <?= formatTime($schedule['end_time']) ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200 w-fit">
                                            <i class="bi bi-geo-alt-fill text-slate-400"></i>
                                            <?= e($schedule['lab_name']) ?>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <div class="flex flex-col h-full">
                                        <h3 class="font-bold text-slate-900 text-base leading-tight mb-1.5">
                                            <?= e($schedule['course_name']) ?>
                                        </h3>

                                        <div class="flex flex-wrap gap-2 mt-1">
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-blue-50 text-blue-700 border border-blue-100">
                                                Kelas <?= e($schedule['class_code']) ?>
                                            </span>
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-violet-50 text-violet-700 border border-violet-100">
                                                Smst <?= e($schedule['semester']) ?>
                                            </span>
                                        </div>

                                        <div
                                            class="mt-2 pt-2 border-t border-slate-100 text-xs text-slate-500 flex items-center gap-1.5">
                                            <i class="bi bi-mortarboard"></i>
                                            <?= e($schedule['program_study']) ?>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                                            <?php if (!empty($schedule['lecturer_photo'])): ?>
                                            <img src="<?= e($schedule['lecturer_photo']) ?>"
                                                class="w-full h-full object-cover">
                                            <?php else: ?>
                                            <span class="text-xs font-bold text-slate-400">DS</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-xs text-slate-400 uppercase tracking-wide font-semibold">Dosen</span>
                                            <span class="text-sm font-medium text-slate-800 line-clamp-2"
                                                title="<?= e($schedule['lecturer_name']) ?>">
                                                <?= e($schedule['lecturer_name']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <div class="space-y-3">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-[10px] font-bold border border-emerald-200 shrink-0 overflow-hidden">
                                                <?php if (!empty($schedule['assistant_1_photo'])): ?>
                                                <img src="<?= e($schedule['assistant_1_photo']) ?>"
                                                    class="w-full h-full object-cover">
                                                <?php else: ?>
                                                A1
                                                <?php endif; ?>
                                            </div>
                                            <span class="text-sm text-slate-700 truncate max-w-[140px]"
                                                title="<?= e($schedule['assistant_1_name']) ?>">
                                                <?= e($schedule['assistant_1_name']) ?>
                                            </span>
                                        </div>

                                        <?php if (!empty($schedule['assistant_2_name'])): ?>
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center text-[10px] font-bold border border-sky-200 shrink-0 overflow-hidden">
                                                <?php if (!empty($schedule['assistant_2_photo'])): ?>
                                                <img src="<?= e($schedule['assistant_2_photo']) ?>"
                                                    class="w-full h-full object-cover">
                                                <?php else: ?>
                                                A2
                                                <?php endif; ?>
                                            </div>
                                            <span class="text-sm text-slate-700 truncate max-w-[140px]"
                                                title="<?= e($schedule['assistant_2_name']) ?>">
                                                <?= e($schedule['assistant_2_name']) ?>
                                            </span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right align-middle">
                                    <div
                                        class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-200">

                                        <a href="<?= url('/admin/schedules/' . $schedule['id']) ?>"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-primary-600 bg-primary-50 hover:bg-primary-100 hover:scale-105 transition-all border border-transparent hover:border-primary-200"
                                            title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="<?= url('/admin/schedules/' . $schedule['id'] . '/edit') ?>"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-amber-600 bg-amber-50 hover:bg-amber-100 hover:scale-105 transition-all border border-transparent hover:border-amber-200"
                                            title="Edit Jadwal">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form method="POST"
                                            action="<?= url('/admin/schedules/' . $schedule['id'] . '/delete') ?>"
                                            onsubmit="return confirm('Hapus jadwal ini? Data tidak bisa dikembalikan.')"
                                            class="inline">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-rose-600 bg-rose-50 hover:bg-rose-100 hover:scale-105 transition-all border border-transparent hover:border-rose-200"
                                                title="Hapus Jadwal">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5">
                                    <div class="flex flex-col items-center justify-center py-20 text-center">
                                        <div
                                            class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4 border border-slate-100">
                                            <i class="bi bi-calendar-range text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-slate-900">Jadwal Kosong</h3>
                                        <p class="text-slate-500 max-w-sm mt-1 mb-6 text-sm">Belum ada jadwal praktikum
                                            yang ditambahkan untuk semester ini.</p>
                                        <a href="<?= url('/admin/schedules/create') ?>"
                                            class="text-primary-600 hover:text-primary-700 font-medium hover:underline text-sm flex items-center gap-1">
                                            <i class="bi bi-plus-circle"></i> Tambah Jadwal Pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (!empty($schedules)): ?>
                <div
                    class="mt-auto border-t border-slate-100 bg-slate-50 px-6 py-3 text-xs text-slate-500 flex justify-between items-center">
                    <span>Total Kelas: <strong><?= count($schedules) ?></strong></span>
                    <span class="text-slate-400">Jadwal dapat berubah sewaktu-waktu.</span>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </main>
</div>