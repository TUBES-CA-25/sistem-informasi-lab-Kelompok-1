<?php $title = 'Assistant Schedules'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Assistant Schedules</h1>
                <p class="text-slate-500 text-sm mt-1">Manage laboratory assistant shifts and working hours.</p>
            </div>

            <a href="<?= url('/koordinator/assistant-schedules/create') ?>"
               class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl shadow-lg shadow-primary-500/30 transition-all transform hover:-translate-y-0.5 focus:ring-4 focus:ring-primary-100">
                <i class="bi bi-calendar-plus text-lg"></i>
                <span>Add Schedule</span>
            </a>
        </div>

        <?php displayFlash(); ?>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col min-h-[600px]">

            <?php if (!empty($schedules)): ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50/80 border-b border-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">Assistant Name</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Day / Shift</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Working Hours</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($schedules as $schedule): ?>
                                <tr class="group hover:bg-slate-50/80 transition-colors duration-200">

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center text-primary-700 font-bold text-xs border-2 border-white shadow-sm shrink-0">
                                                <?= strtoupper(substr($schedule['assistant_name'], 0, 2)) ?>
                                            </div>
                                            <div>
                                                <div class="font-semibold text-slate-900"><?= e($schedule['assistant_name']) ?></div>
                                                <div class="text-xs text-slate-500">ID: #<?= $schedule['id'] ?></div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                            <i class="bi bi-calendar4-week"></i>
                                            <?= ucfirst($schedule['day']) ?>
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-slate-700 font-medium font-mono text-xs sm:text-sm">
                                            <i class="bi bi-clock text-slate-400"></i>
                                            <span><?= formatTime($schedule['start_time']) ?></span>
                                            <span class="text-slate-400">-</span>
                                            <span><?= formatTime($schedule['end_time']) ?></span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <?php if(strtolower($schedule['status']) == 'active'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                Active
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                                Inactive
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-200">
                                            <a href="<?= url('/koordinator/assistant-schedules/' . $schedule['id'] . '/edit') ?>"
                                               class="w-8 h-8 flex items-center justify-center rounded-lg text-amber-600 bg-amber-50 hover:bg-amber-100 hover:scale-105 transition-all border border-transparent hover:border-amber-200"
                                               title="Edit Schedule">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <button type="button"
                                                    onclick="confirmDelete(<?= $schedule['id'] ?>, '<?= htmlspecialchars($schedule['assistant_name'], ENT_QUOTES) ?>')"
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-rose-600 bg-rose-50 hover:bg-rose-100 hover:scale-105 transition-all border border-transparent hover:border-rose-200"
                                                    title="Delete Schedule">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-auto border-t border-slate-100 bg-slate-50 px-6 py-3 text-xs text-slate-500 flex justify-between">
                    <span>Showing <?= count($schedules) ?> schedules</span>
                    <span>Shift timings are in 24-hour format</span>
                </div>

            <?php else: ?>

                <div class="flex flex-col items-center justify-center flex-1 py-12 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4 border border-slate-100">
                        <i class="bi bi-calendar-x text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-900">No Schedules Found</h3>
                    <p class="text-slate-500 max-w-sm mt-1 mb-6 text-sm">There are no assistant schedules recorded yet. Start by adding a new shift.</p>
                    <a href="<?= url('/koordinator/assistant-schedules/create') ?>" class="text-primary-600 hover:text-primary-700 font-medium hover:underline text-sm flex items-center gap-1">
                        <i class="bi bi-plus-circle"></i> Create First Schedule
                    </a>
                </div>

            <?php endif; ?>
        </div>

    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-2xl text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-900 mb-2">Delete Schedule?</h3>
                <p class="text-slate-600 text-sm" id="deleteMessage">
                    Are you sure you want to delete this schedule? This action cannot be undone.
                </p>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-slate-100 text-slate-700 font-medium rounded-lg hover:bg-slate-200 transition-colors">Cancel</button>
            <form id="deleteForm" method="POST" class="flex-1">
                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors shadow-lg shadow-red-500/30">Yes, Delete</button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(scheduleId, assistantName) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const message = document.getElementById('deleteMessage');
    
    const deleteUrl = '<?= url('/koordinator/assistant-schedules/') ?>' + scheduleId + '/delete';
    form.action = deleteUrl;
    message.textContent = `Are you sure you want to delete the schedule for "${assistantName}"? This action cannot be undone.`;
    
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    }
});
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
