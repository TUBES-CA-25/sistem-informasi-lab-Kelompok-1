<?php $title = 'Jadwal Piket'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800">Jadwal Piket Asisten</h1>
                    <p class="text-slate-500 mt-1">Lihat jadwal piket semua asisten.</p>
                </div>
                <!-- View Toggle -->
                <div class="flex gap-2 bg-slate-100 p-1 rounded-lg">
                    <button onclick="showView('grid')" id="gridViewBtn" class="px-4 py-2 rounded-md font-medium text-sm transition-all bg-white text-slate-900 shadow-sm">
                        <i class="bi bi-grid-3x3-gap mr-1"></i> Grid View
                    </button>
                    <button onclick="showView('list')" id="listViewBtn" class="px-4 py-2 rounded-md font-medium text-sm transition-all text-slate-600 hover:text-slate-900">
                        <i class="bi bi-list-ul mr-1"></i> List View
                    </button>
                </div>
            </div>
        </div>

        <!-- Grid View -->
        <div id="gridView" class="mb-6">
            <?php if (empty($allSchedules)): ?>
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-calendar-week text-4xl text-slate-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-700 mb-2">Belum Ada Jadwal</h3>
                    <p class="text-slate-500">Jadwal piket belum tersedia.</p>
                </div>
            <?php else: ?>
                <?php
                // Group schedules by time and day
                $grid = [];
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                $dayLabels = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                
                foreach ($allSchedules as $schedule) {
                    $timeKey = date('H:i', strtotime($schedule['start_time'])) . ' - ' . date('H:i', strtotime($schedule['end_time']));
                    if (!isset($grid[$timeKey])) {
                        $grid[$timeKey] = array_fill_keys($days, []);
                    }
                    $grid[$timeKey][$schedule['day']][] = $schedule;
                }
                ?>
                
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gradient-to-r from-slate-50 to-slate-100 border-b-2 border-slate-200">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-700 uppercase tracking-wider sticky left-0 bg-slate-50">Waktu</th>
                                    <?php foreach ($dayLabels as $i => $dayLabel): ?>
                                        <th class="px-4 py-3 text-center text-xs font-bold text-slate-700 uppercase tracking-wider"><?= $dayLabel ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php foreach ($grid as $time => $daySchedules): ?>
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-4 py-3 text-sm font-semibold text-slate-700 whitespace-nowrap sticky left-0 bg-white">
                                            <i class="bi bi-clock text-slate-400 mr-1"></i>
                                            <?= $time ?>
                                        </td>
                                        <?php foreach ($days as $day): ?>
                                            <td class="px-4 py-3 text-center">
                                                <?php if (!empty($daySchedules[$day])): ?>
                                                    <div class="space-y-1">
                                                        <?php foreach ($daySchedules[$day] as $schedule): ?>
                                                            <div class="inline-block px-3 py-2 bg-gradient-to-r from-sky-50 to-blue-50 border border-sky-200 rounded-lg text-xs">
                                                                <div class="font-semibold text-sky-900">
                                                                    <?= htmlspecialchars($schedule['assistant_name']) ?>
                                                                </div>
                                                                <?php if (!empty($schedule['description'])): ?>
                                                                    <div class="text-sky-600 text-xs mt-1">
                                                                        <?= htmlspecialchars($schedule['description']) ?>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-slate-300">-</span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- List View -->
        <div id="listView" class="hidden">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <?php if (empty($allSchedules)): ?>
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-calendar-week text-4xl text-slate-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-700 mb-2">Belum Ada Jadwal</h3>
                    <p class="text-slate-500">Jadwal piket belum tersedia.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Asisten</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Hari</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Waktu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tugas</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            <?php foreach ($allSchedules as $schedule): ?>
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gradient-to-br from-sky-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold">
                                                <?= strtoupper(substr($schedule['assistant_name'], 0, 1)) ?>
                                            </div>
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-slate-900">
                                                    <?= htmlspecialchars($schedule['assistant_name']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <?= ucfirst($schedule['day']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                        <?= date('H:i', strtotime($schedule['start_time'])) ?> - <?= date('H:i', strtotime($schedule['end_time'])) ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        <?= htmlspecialchars($schedule['description'] ?? '-') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        </div>

    </div>
</div>

<script>
function showView(view) {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');
    
    if (view === 'grid') {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        gridBtn.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
        gridBtn.classList.remove('text-slate-600');
        listBtn.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
        listBtn.classList.add('text-slate-600');
    } else {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        listBtn.classList.add('bg-white', 'text-slate-900', 'shadow-sm');
        listBtn.classList.remove('text-slate-600');
        gridBtn.classList.remove('bg-white', 'text-slate-900', 'shadow-sm');
        gridBtn.classList.add('text-slate-600');
    }
}
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
