<?php $title = 'Manajemen Jadwal'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Jadwal Praktikum</h1>
                    <p class="text-slate-500 text-sm mt-1">Total <strong><?= $pagination['total_rows'] ?></strong> sesi
                        ditemukan.</p>
                </div>

                <div class="flex flex-wrap gap-2 w-full md:w-auto">
                    <a href="<?= url('/admin/schedules/create') ?>"
                        class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl shadow-lg shadow-primary-500/30 transition-all focus:ring-4 focus:ring-primary-100 flex-1 md:flex-none justify-center">
                        <i class="bi bi-plus-lg text-lg"></i>
                        <span>Buat Jadwal</span>
                    </a>
                </div>
            </div>

            <?php displayFlash(); ?>

            <div class="bg-white p-4 rounded-2xl shadow-sm border border-slate-200 mb-6">
                <form method="GET" action="<?= url('/admin/schedules') ?>" class="flex flex-col md:flex-row gap-4">

                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="bi bi-search text-slate-400"></i>
                        </div>
                        <input type="text" name="search" value="<?= e($filters['search'] ?? '') ?>"
                            class="block w-full p-2.5 pl-10 text-sm text-slate-900 border border-slate-300 rounded-lg bg-slate-50 focus:ring-primary-500 focus:border-primary-500"
                            placeholder="Cari Mata Kuliah, Dosen, atau Kelas...">
                    </div>

                    <div class="md:w-1/4">
                        <select name="lab_id" onchange="this.form.submit()"
                            class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                            <option value="">Semua Laboratorium</option>
                            <?php foreach ($laboratories as $lab): ?>
                                <option value="<?= $lab['id'] ?>"
                                    <?= ($filters['lab_id'] == $lab['id']) ? 'selected' : '' ?>>
                                    <?= e($lab['lab_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit"
                        class="text-white bg-slate-800 hover:bg-slate-900 font-medium rounded-lg text-sm px-5 py-2.5 md:w-auto">
                        Filter
                    </button>

                    <?php if (!empty($filters['search']) || !empty($filters['lab_id'])): ?>
                        <a href="<?= url('/admin/schedules') ?>"
                            class="text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Reset
                        </a>
                    <?php endif; ?>
                </form>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50/80 border-b border-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold w-[22%]">Waktu & Tanggal</th>
                                <th scope="col" class="px-6 py-4 font-semibold w-[28%]">Mata Kuliah & Kelas</th>
                                <th scope="col" class="px-6 py-4 font-semibold w-[20%]">Dosen Pengampu</th>
                                <th scope="col" class="px-6 py-4 font-semibold w-[20%]">Tim Asisten</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right w-[10%]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($schedules)): ?>
                                <?php foreach ($schedules as $schedule): ?>
                                    <?php
                                    // Format Data
                                    $dateObj = new DateTime($schedule['session_date']);
                                    $dayNameEn = $dateObj->format('l');
                                    $daysID = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
                                    $dayNameID = $daysID[$dayNameEn] ?? $dayNameEn;

                                    // ID untuk Edit/Detail (Plan ID) vs Hapus (Session ID)
                                    $planId = $schedule['plan_id'] ?? $schedule['id'];
                                    $sessionId = $schedule['id'];
                                    ?>
                                    <tr class="group hover:bg-slate-50/80 transition-colors duration-200">

                                        <td class="px-6 py-4 align-top">
                                            <div class="flex flex-col gap-3">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="flex flex-col items-center justify-center w-12 h-12 rounded-xl bg-primary-50 text-primary-700 border border-primary-100 shadow-sm shrink-0">
                                                        <span
                                                            class="text-lg font-bold leading-none"><?= $dateObj->format('d') ?></span>
                                                        <span
                                                            class="text-[10px] font-bold uppercase leading-none mt-0.5"><?= $dateObj->format('M') ?></span>
                                                    </div>
                                                    <div class="flex flex-col">
                                                        <span class="text-sm font-bold text-slate-900"><?= $dayNameID ?></span>
                                                        <span
                                                            class="text-xs font-mono font-medium text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded w-fit mt-1">
                                                            <?= date('H:i', strtotime($schedule['start_time'])) ?> -
                                                            <?= date('H:i', strtotime($schedule['end_time'])) ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div
                                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 border border-slate-200 text-xs font-semibold w-fit">
                                                    <i class="bi bi-geo-alt-fill opacity-50"></i>
                                                    <?= e($schedule['lab_name']) ?>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 align-top">
                                            <div class="flex flex-col h-full">
                                                <h3 class="font-bold text-slate-900 text-base leading-snug mb-2">
                                                    <?= e($schedule['course_name']) ?></h3>
                                                <div class="flex flex-wrap gap-2">
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide bg-blue-50 text-blue-700 border border-blue-100">
                                                        <i class="bi bi-easel2 mr-1"></i> Frekuensi
                                                        <?= e($schedule['class_code']) ?>
                                                    </span>
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wide bg-violet-50 text-violet-700 border border-violet-100">
                                                        Smst <?= e($schedule['semester']) ?>
                                                    </span>
                                                </div>
                                                <div class="mt-2 text-xs text-slate-500 flex items-center gap-1.5">
                                                    <i class="bi bi-mortarboard text-slate-400"></i>
                                                    <?= e($schedule['program_study']) ?>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 align-top">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-white border-2 border-slate-100 p-0.5 shadow-sm overflow-hidden flex-shrink-0">
                                                    <?php if (!empty($schedule['lecturer_photo']) && file_exists(PUBLIC_PATH . $schedule['lecturer_photo'])): ?>
                                                        <img src="<?= url($schedule['lecturer_photo']) ?>"
                                                            class="w-full h-full object-cover rounded-full">
                                                    <?php else: ?>
                                                        <div
                                                            class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400 text-xs font-bold rounded-full">
                                                            DS</div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-[10px] text-slate-400 uppercase tracking-wider font-bold mb-0.5">Dosen</span>
                                                    <span class="text-sm font-medium text-slate-800 line-clamp-2 leading-tight"
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
                                                        class="w-7 h-7 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-[10px] font-bold border border-emerald-200 shrink-0 overflow-hidden">
                                                        <?php if (!empty($schedule['assistant_1_photo']) && file_exists(PUBLIC_PATH . $schedule['assistant_1_photo'])): ?>
                                                            <img src="<?= url($schedule['assistant_1_photo']) ?>"
                                                                class="w-full h-full object-cover">
                                                        <?php else: ?>
                                                            A1
                                                        <?php endif; ?>
                                                    </div>
                                                    <span class="text-xs font-medium text-slate-700 truncate max-w-[120px]"
                                                        title="<?= e($schedule['assistant_1_name']) ?>">
                                                        <?= e($schedule['assistant_1_name']) ?>
                                                    </span>
                                                </div>
                                                <?php if (!empty($schedule['assistant_2_name'])): ?>
                                                    <div class="flex items-center gap-2">
                                                        <div
                                                            class="w-7 h-7 rounded-full bg-sky-50 text-sky-600 flex items-center justify-center text-[10px] font-bold border border-sky-200 shrink-0 overflow-hidden">
                                                            <?php if (!empty($schedule['assistant_2_photo']) && file_exists(PUBLIC_PATH . $schedule['assistant_2_photo'])): ?>
                                                                <img src="<?= url($schedule['assistant_2_photo']) ?>"
                                                                    class="w-full h-full object-cover">
                                                            <?php else: ?>
                                                                A2
                                                            <?php endif; ?>
                                                        </div>
                                                        <span class="text-xs font-medium text-slate-700 truncate max-w-[120px]"
                                                            title="<?= e($schedule['assistant_2_name']) ?>">
                                                            <?= e($schedule['assistant_2_name']) ?>
                                                        </span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-right align-middle">
                                            <div
                                                class="flex flex-col gap-2 items-end opacity-100 sm:opacity-60 sm:group-hover:opacity-100 transition-opacity">

                                                <a href="<?= url('/admin/schedules/' . $planId) ?>"
                                                    class="inline-flex items-center gap-2 text-xs font-bold text-primary-600 hover:text-primary-700 bg-primary-50 hover:bg-primary-100 px-3 py-1.5 rounded-lg border border-primary-200 transition-all w-fit"
                                                    title="Lihat Detail Master">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>

                                                <a href="<?= url('/admin/schedules/' . $planId . '/edit') ?>"
                                                    class="inline-flex items-center gap-2 text-xs font-bold text-amber-600 hover:text-amber-700 bg-amber-50 hover:bg-amber-100 px-3 py-1.5 rounded-lg border border-amber-200 transition-all w-fit"
                                                    title="Edit Data Master">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>

                                                <form method="POST"
                                                    action="<?= url('/admin/schedules/' . $sessionId . '/delete') ?>"
                                                    onsubmit="return confirm('Hapus sesi tanggal <?= $dateObj->format('d M Y') ?>?');">
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-2 text-xs font-bold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded-lg border border-rose-200 transition-all w-fit">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-20">
                                        <div
                                            class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-4 border border-slate-100">
                                            <i class="bi bi-search text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-slate-900">Tidak ada data</h3>
                                        <p class="text-slate-500 text-sm mt-1">Coba ubah kata kunci pencarian atau filter.
                                        </p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($pagination['total_pages'] > 1): ?>
                    <div class="border-t border-slate-100 bg-slate-50 px-6 py-4 flex items-center justify-between">
                        <span class="text-sm text-slate-600">
                            Menampilkan <strong><?= $pagination['start_entry'] ?>-<?= $pagination['end_entry'] ?></strong>
                            dari <strong><?= $pagination['total_rows'] ?></strong> data
                        </span>

                        <nav aria-label="Page navigation">
                            <ul class="inline-flex -space-x-px text-sm h-8">
                                <li>
                                    <a href="<?= url('/admin/schedules') ?>?page=<?= max(1, $pagination['current_page'] - 1) ?>&search=<?= $filters['search'] ?>&lab_id=<?= $filters['lab_id'] ?>"
                                        class="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-slate-500 bg-white border border-slate-300 rounded-l-lg hover:bg-slate-100 hover:text-slate-700 <?= $pagination['current_page'] <= 1 ? 'pointer-events-none opacity-50' : '' ?>">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>

                                <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
                                    <?php if ($i == 1 || $i == $pagination['total_pages'] || ($i >= $pagination['current_page'] - 2 && $i <= $pagination['current_page'] + 2)): ?>
                                        <li>
                                            <a href="<?= url('/admin/schedules') ?>?page=<?= $i ?>&search=<?= $filters['search'] ?>&lab_id=<?= $filters['lab_id'] ?>"
                                                class="flex items-center justify-center px-3 h-8 leading-tight <?= $i == $pagination['current_page'] ? 'text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700' : 'text-slate-500 bg-white border border-slate-300 hover:bg-slate-100 hover:text-slate-700' ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php elseif ($i == $pagination['current_page'] - 3 || $i == $pagination['current_page'] + 3): ?>
                                        <li><span
                                                class="flex items-center justify-center px-3 h-8 leading-tight text-slate-500 bg-white border border-slate-300">...</span>
                                        </li>
                                    <?php endif; ?>
                                <?php endfor; ?>

                                <li>
                                    <a href="<?= url('/admin/schedules') ?>?page=<?= min($pagination['total_pages'], $pagination['current_page'] + 1) ?>&search=<?= $filters['search'] ?>&lab_id=<?= $filters['lab_id'] ?>"
                                        class="flex items-center justify-center px-3 h-8 leading-tight text-slate-500 bg-white border border-slate-300 rounded-r-lg hover:bg-slate-100 hover:text-slate-700 <?= $pagination['current_page'] >= $pagination['total_pages'] ? 'pointer-events-none opacity-50' : '' ?>">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </main>
</div>