<?php
// LOGIKA PENGELOMPOKAN DATA (VIEW LOGIC)
// Kita lakukan grouping data jadwal berdasarkan parameter 'view' dari URL
$view = $_GET['view'] ?? 'all'; // Default: Tampilkan Semua
$groupedSchedules = [];

if (empty($schedules)) {
    $schedules = [];
}

// Helper untuk sorting hari
$dayOrder = ['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7];

if ($view == 'lab') {
    // Grouping by Laboratory
    foreach ($schedules as $s) {
        $groupedSchedules[$s['lab_name']][] = $s;
    }
    ksort($groupedSchedules); // Urutkan nama lab A-Z
} elseif ($view == 'day') {
    // Grouping by Day
    foreach ($schedules as $s) {
        $groupedSchedules[$s['day']][] = $s;
    }
    // Sort hari sesuai urutan Senin-Minggu
    uksort($groupedSchedules, function ($a, $b) use ($dayOrder) {
        return $dayOrder[$a] - $dayOrder[$b];
    });
} else {
    // Default: Semua Jadwal (Satu Group Besar)
    $groupedSchedules['Semua Jadwal Praktikum'] = $schedules;
}

$title = 'Jadwal Praktikum';
?>

<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen pb-12">
    <div class="bg-white border-b border-slate-200 pt-10 pb-6 mb-8">
        <div class="max-w-screen-xl mx-auto px-4">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Jadwal Praktikum</h1>
                    <p class="text-slate-500 mt-1">Informasi lengkap jadwal penggunaan laboratorium.</p>
                </div>

                <div class="relative w-full md:w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="bi bi-search text-slate-400"></i>
                    </div>
                    <input type="text" id="tableSearch" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full pl-10 p-2.5" placeholder="Cari Dosen / Matkul...">
                </div>
            </div>

            <div class="flex flex-wrap gap-2 mt-6 overflow-x-auto pb-2 scrollbar-hide">
                <a href="?view=all" class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors whitespace-nowrap <?= $view == 'all' ? 'bg-sky-500 text-white shadow-md shadow-sky-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">
                    <i class="bi bi-list-ul mr-2"></i> Menyeluruh
                </a>
                <a href="?view=lab" class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors whitespace-nowrap <?= $view == 'lab' ? 'bg-sky-500 text-white shadow-md shadow-sky-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">
                    <i class="bi bi-pc-display mr-2"></i> Per Laboratorium
                </a>
                <a href="?view=day" class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-colors whitespace-nowrap <?= $view == 'day' ? 'bg-sky-500 text-white shadow-md shadow-sky-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">
                    <i class="bi bi-calendar-week mr-2"></i> Per Hari
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-screen-xl mx-auto px-4 space-y-8">

        <?php if (empty($schedules)): ?>
            <div class="text-center py-20 bg-white rounded-2xl border border-dashed border-slate-300">
                <i class="bi bi-calendar-x text-4xl text-slate-300 mb-4 block"></i>
                <p class="text-slate-500">Belum ada jadwal yang tersedia saat ini.</p>
            </div>
        <?php else: ?>

            <?php foreach ($groupedSchedules as $groupTitle => $items): ?>
                <?php
                // Tentukan Icon & Warna Header berdasarkan View
                $headerIcon = 'bi-table';
                if ($view == 'lab') $headerIcon = 'bi-pc-display-horizontal';
                if ($view == 'day') {
                    $headerIcon = 'bi-calendar-event';
                    $groupTitle = getDayName($groupTitle); // Translate hari ke Indo
                }
                ?>

                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden schedule-group">
                    <div class="bg-slate-50/50 px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-800 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center mr-3 text-sm">
                                <i class="bi <?= $headerIcon ?>"></i>
                            </span>
                            <?= e($groupTitle) ?>
                            <span class="ml-3 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 text-xs font-medium border border-slate-200">
                                <?= count($items) ?> Sesi
                            </span>
                        </h2>
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-sm text-left text-slate-500">
                            <thead class="text-xs text-slate-700 uppercase bg-slate-50/50">
                                <tr>
                                    <th class="px-6 py-3">Waktu & Hari</th>
                                    <th class="px-6 py-3">Mata Kuliah / Kelas</th>
                                    <?php if ($view != 'lab'): ?><th class="px-6 py-3">Laboratorium</th><?php endif; ?>
                                    <th class="px-6 py-3">Dosen & Asisten</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php foreach ($items as $schedule): ?>
                                    <tr class="hover:bg-slate-50 transition-colors search-item">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-bold text-slate-900"><?= getDayName($schedule['day']) ?></div>
                                            <div class="text-sky-600 font-medium">
                                                <?= formatTime($schedule['start_time']) ?> - <?= formatTime($schedule['end_time']) ?>
                                            </div>
                                            <div class="text-xs text-slate-400 mt-1"><?= e($schedule['frequency'] ?? 'Rutin') ?></div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-slate-900 text-base"><?= e($schedule['course']) ?></div>
                                            <div class="flex items-center gap-2 mt-1">
                                                <span class="bg-sky-50 text-sky-700 text-xs px-2 py-0.5 rounded border border-sky-100 font-semibold">
                                                    Kelas <?= e($schedule['class_code']) ?>
                                                </span>
                                                <span class="text-xs text-slate-500"><?= e($schedule['program_study']) ?></span>
                                            </div>
                                        </td>

                                        <?php if ($view != 'lab'): ?>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center text-slate-700 font-medium">
                                                    <i class="bi bi-geo-alt text-sky-500 mr-2"></i>
                                                    <?= e($schedule['lab_name']) ?>
                                                </div>
                                                <div class="text-xs text-slate-400 ml-6"><?= e($schedule['location']) ?></div>
                                            </td>
                                        <?php endif; ?>

                                        <td class="px-6 py-4">
                                            <div class="text-slate-900 font-medium text-xs mb-1">
                                                <i class="bi bi-person-video3 mr-1 text-slate-400"></i> <?= e($schedule['lecturer']) ?>
                                            </div>
                                            <div class="text-slate-500 text-xs">
                                                <i class="bi bi-people mr-1 text-slate-400"></i> Asisten: <?= e($schedule['assistant']) ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <a href="<?= url('/schedule/' . $schedule['id']) ?>"
                                                class="text-sky-600 bg-sky-50 hover:bg-sky-100 focus:ring-4 focus:ring-sky-100 font-medium rounded-lg text-xs px-4 py-2 focus:outline-none transition-all">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="md:hidden divide-y divide-slate-100">
                        <?php foreach ($items as $schedule): ?>
                            <div class="p-4 hover:bg-slate-50 transition-colors search-item">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="text-xs font-bold text-sky-600 bg-sky-50 px-2 py-0.5 rounded border border-sky-100">
                                            <?= formatTime($schedule['start_time']) ?> - <?= formatTime($schedule['end_time']) ?>
                                        </span>
                                        <?php if ($view != 'day'): ?>
                                            <span class="text-xs text-slate-400 ml-2"><?= getDayName($schedule['day']) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <a href="<?= url('/schedule/' . $schedule['id']) ?>" class="text-slate-400 hover:text-sky-600">
                                        <i class="bi bi-arrow-right-circle text-xl"></i>
                                    </a>
                                </div>

                                <h3 class="font-bold text-slate-900 text-lg mb-1"><?= e($schedule['course']) ?></h3>

                                <div class="flex flex-wrap gap-y-1 text-sm text-slate-600 mb-3">
                                    <div class="w-full flex items-center">
                                        <i class="bi bi-people-fill w-5 text-slate-400"></i>
                                        <span>Kelas <?= e($schedule['class_code']) ?></span>
                                    </div>
                                    <?php if ($view != 'lab'): ?>
                                        <div class="w-full flex items-center">
                                            <i class="bi bi-geo-alt-fill w-5 text-slate-400"></i>
                                            <span><?= e($schedule['lab_name']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="w-full flex items-center">
                                        <i class="bi bi-person-badge-fill w-5 text-slate-400"></i>
                                        <span class="truncate w-10/12"><?= e($schedule['lecturer']) ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>
</div>

<script>
    document.getElementById('tableSearch').addEventListener('keyup', function() {
        let searchText = this.value.toLowerCase();
        let items = document.querySelectorAll('.search-item');

        items.forEach(item => {
            let text = item.textContent.toLowerCase();
            if (text.includes(searchText)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>