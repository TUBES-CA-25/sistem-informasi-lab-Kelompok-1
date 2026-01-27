<?php $title = 'Jobdesk Saya'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900">Jobdesk Saya</h1>
            <p class="text-slate-500 mt-2 text-lg">Daftar tugas maintenance dan perbaikan yang harus Anda selesaikan.</p>
        </div>

        <?php displayFlash(); ?>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-slate-500">
                    <thead class="bg-slate-50 text-slate-700 uppercase text-xs font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-4 w-10">No</th>
                            <th class="px-6 py-4">Tugas & Masalah</th>
                            <th class="px-6 py-4">Detail Pengerjaan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Update</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (!empty($myTasks)): ?>
                            <?php foreach ($myTasks as $index => $task): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-bold"><?= $index + 1 ?></td>

                                    <td class="px-6 py-4 align-top">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-bold font-mono">
                                                PC-<?= e($task['pc_number']) ?>
                                            </span>
                                            <span class="text-xs font-bold uppercase tracking-wide text-slate-400">
                                                <?= e($task['problem_type']) ?>
                                            </span>
                                        </div>
                                        <div class="font-bold text-slate-800 text-base"><?= e($task['lab_name']) ?></div>
                                        <p class="text-slate-600 text-sm mt-1 italic">"<?= e($task['description']) ?>"</p>
                                    </td>

                                    <td class="px-6 py-4 align-top text-sm">
                                        <div class="mb-2">
                                            <span class="text-slate-400 text-xs uppercase font-bold">Pelapor</span><br>
                                            <span class="text-slate-800 font-medium"><?= e($task['reporter_name']) ?></span>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 text-xs uppercase font-bold">Waktu</span><br>
                                            <span class="text-slate-600">
                                                Mulai: <?= !empty($task['started_at']) ? formatDate($task['started_at']) : '-' ?><br>
                                                Selesai: <?= !empty($task['completed_at']) ? formatDate($task['completed_at']) : '-' ?>
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 align-top">
                                        <?= getStatusBadge($task['status']) ?>
                                    </td>

                                    <td class="px-6 py-4 align-top text-center">
                                        <a href="<?= url('/asisten/jobdesk/' . $task['id'] . '/edit') ?>" class="inline-block text-sky-600 hover:text-white border border-sky-600 hover:bg-sky-600 focus:ring-4 focus:outline-none focus:ring-sky-300 font-medium rounded-full text-sm px-5 py-2.5 text-center transition-all">
                                            <i class="bi bi-pencil-square mr-1"></i> Update
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="bi bi-emoji-smile text-4xl text-sky-400"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-slate-900">Tidak Ada Tugas</h3>
                                    <p class="text-slate-500 mt-1">Anda tidak memiliki tanggungan pekerjaan saat ini.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function toggleCompletionFields(taskId) {
    const statusSelect = document.getElementById('status-' + taskId);
    const completionFields = document.getElementById('completion-fields-' + taskId);
    
    if (statusSelect.value === 'resolved') {
        completionFields.classList.remove('hidden');
    } else {
        completionFields.classList.add('hidden');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[id^=\"status-\"]').forEach(function(select) {
        const taskId = select.id.replace('status-', '');
        toggleCompletionFields(taskId);
    });
});
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>