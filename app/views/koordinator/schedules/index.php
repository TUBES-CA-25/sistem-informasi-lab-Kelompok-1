<?php $title = 'Jadwal Piket Asisten'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Jadwal Piket Asisten</h1>
                <p class="text-slate-500 mt-1">Kelola jadwal jaga laboratorium.</p>
            </div>

            <a href="<?= url('/koordinator/assistant-schedules/create') ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg shadow-lg shadow-sky-500/30 transition-all">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Jadwal</span>
            </a>
        </div>

        <!-- View Toggle & Filter -->
        <div class="flex flex-wrap gap-4 mb-6">
            <!-- View Toggle -->
            <div class="flex gap-2">
                <a href="<?= url('/koordinator/assistant-schedules?view=grid&filter=' . $currentFilter) ?>" class="px-4 py-2 rounded-lg text-sm font-medium transition-all <?= $currentView == 'grid' ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                    <i class="bi bi-grid-3x3"></i> Grid View
                </a>
                <a href="<?= url('/koordinator/assistant-schedules?view=list&filter=' . $currentFilter) ?>" class="px-4 py-2 rounded-lg text-sm font-medium transition-all <?= $currentView == 'list' ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                    <i class="bi bi-list-ul"></i> List View
                </a>
            </div>

            <!-- Filter -->
            <div class="flex gap-2">
                <a href="<?= url('/koordinator/assistant-schedules?view=' . $currentView . '&filter=all') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $currentFilter == 'all' ? 'bg-slate-600 text-white shadow-lg' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                    Semua
                </a>
                <a href="<?= url('/koordinator/assistant-schedules?view=' . $currentView . '&filter=today') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $currentFilter == 'today' ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                    Hari Ini
                </a>
            </div>
        </div>

        <?php displayFlash(); ?>

        <?php if ($currentView == 'grid'): ?>
            <!-- Grid View (Tasks × Days) -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-slate-700 uppercase w-32">Tugas</th>
                                <?php 
                                $dayNames = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
                                foreach ($dayNames as $day => $label): 
                                ?>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-slate-700 uppercase"><?= $label ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (empty($gridData)): ?>
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <i class="bi bi-calendar-week text-4xl text-slate-300"></i>
                                        </div>
                                        <p class="text-slate-500">Belum ada jadwal piket</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($gridData as $taskKey => $taskData): ?>
                                    <tr class="hover:bg-slate-50">
                                        <td class="px-4 py-4 font-medium text-slate-900 whitespace-nowrap">
                                            <?= htmlspecialchars($taskData['time']) ?>
                                        </td>
                                        <?php foreach (array_keys($dayNames) as $day): ?>
                                            <td class="px-2 py-2 text-center">
                                                <?php if ($taskData['days'][$day]): ?>
                                                    <?php $schedule = $taskData['days'][$day]; ?>
                                                    <div class="bg-sky-50 border border-sky-200 rounded-lg p-2 relative group">
                                                        <div class="font-medium text-sky-900 text-xs mb-1">
                                                            <?= htmlspecialchars($schedule['assistant_name']) ?>
                                                        </div>
                                                        <?php if (!empty($schedule['task_description'])): ?>
                                                            <div class="text-[10px] text-sky-700 line-clamp-1">
                                                                <?= htmlspecialchars($schedule['task_description']) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity flex gap-1">
                                                            <a href="<?= url('/koordinator/assistant-schedules/' . $schedule['id'] . '/edit') ?>" class="text-blue-600 hover:text-blue-800" title="Edit">
                                                                <i class="bi bi-pencil text-xs"></i>
                                                            </a>
                                                            <button onclick="confirmDelete(<?= $schedule['id'] ?>)" class="text-red-600 hover:text-red-800" title="Hapus">
                                                                <i class="bi bi-trash text-xs"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="text-slate-300">-</div>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        <?php else: ?>
            <!-- List View -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <?php if (empty($schedules)): ?>
                    <div class="p-12 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-calendar-week text-4xl text-slate-300"></i>
                        </div>
                        <p class="text-slate-500">Belum ada jadwal piket</p>
                    </div>
                <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-slate-500">
                            <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b">
                                <tr>
                                    <th class="px-6 py-3">Tugas</th>
                                    <th class="px-6 py-3">Hari</th>
                                    <!-- <th class="px-6 py-3">Waktu</th> -->
                                    <th class="px-6 py-3">Asisten</th>
                                    <th class="px-6 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php foreach ($schedules as $schedule): ?>
                                    <tr class="bg-white hover:bg-slate-50">
                                        <td class="px-6 py-4 text-slate-900">
                                            <?= htmlspecialchars($schedule['start_time']) ?> - <?= htmlspecialchars($schedule['end_time']) ?>
                                        </td>
                                        <td class="px-6 py-4 font-medium text-slate-900">
                                            <?php
                                            $dayLabels = [
                                                'Monday' => 'Senin',
                                                'Tuesday' => 'Selasa',
                                                'Wednesday' => 'Rabu',
                                                'Thursday' => 'Kamis',
                                                'Friday' => 'Jumat',
                                                'Saturday' => 'Sabtu',
                                                'Sunday' => 'Minggu'
                                            ];
                                            echo $dayLabels[$schedule['day']] ?? $schedule['day'];
                                            ?>
                                        </td>
                                        <!-- <td class="px-6 py-4 text-slate-900">
                                            <?= htmlspecialchars($schedule['start_time']) ?> - <?= htmlspecialchars($schedule['end_time']) ?>
                                        </td> -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 bg-sky-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-bold text-sky-700"><?= strtoupper(substr($schedule['assistant_name'], 0, 1)) ?></span>
                                                </div>
                                                <span class="text-slate-900"><?= htmlspecialchars($schedule['assistant_name']) ?></span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-slate-600">
                                            <?= htmlspecialchars($schedule['task_description'] ?? '-') ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="<?= url('/koordinator/assistant-schedules/' . $schedule['id'] . '/edit') ?>" class="text-blue-600 hover:text-blue-800 font-medium" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button onclick="confirmDelete(<?= $schedule['id'] ?>)" class="text-red-600 hover:text-red-800 font-medium" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-slate-900/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-2xl text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-900 mb-2">Hapus Jadwal?</h3>
                <p class="text-slate-600 text-sm">
                    Apakah Anda yakin ingin menghapus jadwal ini?
                </p>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg font-medium transition-colors">
                Batal
            </button>
            <form id="deleteForm" method="POST" class="flex-1">
                <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(scheduleId) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = '<?= url('/koordinator/assistant-schedules/') ?>' + scheduleId + '/delete';
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

document.getElementById('deleteModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
