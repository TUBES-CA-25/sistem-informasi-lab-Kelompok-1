<?php $title = 'Jadwal Piket Asisten'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Jadwal Piket Asisten</h1>
                <p class="text-slate-500 mt-1">Klik kolom "Tugas" untuk mengedit rincian pekerjaan.</p>
            </div>
            <a href="<?= url('/koordinator/assistant-schedules/create') ?>"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-bold rounded-xl shadow-lg shadow-sky-500/30 transition-all">
                <i class="bi bi-plus-lg"></i> Tambah Jadwal
            </a>
        </div>

        <?php displayFlash(); ?>

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-center border-collapse">
                    <thead class="bg-slate-100 text-slate-700 border-b-2 border-slate-200 uppercase text-xs font-bold">
                        <tr>
                            <th class="px-4 py-4 w-1/6 border-r border-slate-200 bg-slate-200">Tugas / Role</th>
                            <?php foreach ($days as $day): ?>
                            <?php $dayNames = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu']; ?>
                            <th class="px-2 py-3 border-r border-slate-200 min-w-[120px]"><?= $dayNames[$day] ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                        <?php foreach (['Putri', 'Putra'] as $role): ?>
                        <?php
                            $theme = ($role == 'Putri') ? 'bg-rose-50 border-rose-100 text-rose-900' : 'bg-emerald-50 border-emerald-100 text-emerald-900';
                            $hover = ($role == 'Putri') ? 'hover:bg-rose-100' : 'hover:bg-emerald-100';
                            $jobText = $masterJob[$role];
                            ?>
                        <tr>
                            <td
                                class="p-0 border-r border-slate-200 border-b border-slate-100 align-middle relative group">
                                <button onclick="openJobModal('<?= $role ?>', `<?= e($jobText) ?>`)"
                                    class="w-full h-full min-h-[150px] p-4 text-left flex flex-col justify-center <?= $theme ?> <?= $hover ?> transition-colors">
                                    <span
                                        class="font-bold text-sm uppercase tracking-wider mb-2 border-b border-black/10 pb-1 w-fit">Tugas
                                        <?= $role ?></span>
                                    <p class="text-xs font-medium leading-relaxed whitespace-pre-line">
                                        <?= e($jobText) ?></p>
                                    <div
                                        class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="bi bi-pencil-square text-lg"></i></div>
                                </button>
                            </td>
                            <?php foreach ($days as $day): ?>
                            <td class="p-2 align-top border-r border-slate-100 border-b border-slate-100 h-full">
                                <div class="flex flex-col gap-2">
                                    <?php if (!empty($matrix[$role][$day])): ?>
                                    <?php foreach ($matrix[$role][$day] as $sched): ?>
                                    <div
                                        class="group/item relative bg-white border border-slate-200 rounded-lg p-2 shadow-sm hover:shadow-md hover:border-sky-400 text-left">
                                        <div class="flex items-center gap-2">
                                            <div
                                                class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-500">
                                                <?= substr($sched['assistant_name'], 0, 1) ?></div>
                                            <span
                                                class="text-xs font-semibold text-slate-700 truncate"><?= explode(' ', $sched['assistant_name'])[0] ?></span>
                                        </div>
                                        <div class="absolute -top-2 -right-2 hidden group-hover/item:flex gap-1">
                                            <a href="<?= url('/koordinator/assistant-schedules/' . $sched['id'] . '/edit') ?>"
                                                class="w-5 h-5 bg-amber-400 text-white rounded-full flex items-center justify-center text-[10px] shadow-sm"><i
                                                    class="bi bi-pencil"></i></a>
                                            <button type="button"
                                                onclick="confirmDeleteSchedule(<?= $sched['id'] ?>, '<?= htmlspecialchars($sched['assistant_name'], ENT_QUOTES) ?>')"
                                                class="w-5 h-5 bg-rose-500 text-white rounded-full flex items-center justify-center text-[10px] shadow-sm"><i
                                                    class="bi bi-x"></i></button>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="jobModal"
    class="hidden fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="font-bold text-lg text-slate-800">Edit Jobdesk <span id="modalRoleName"></span></h3>
            <button onclick="closeJobModal()" class="text-slate-400 hover:text-rose-500"><i
                    class="bi bi-x-lg text-xl"></i></button>
        </div>
        <form action="<?= url('/koordinator/assistant-schedules/update-job') ?>" method="POST">
            <div class="p-6">
                <input type="hidden" name="role" id="modalRoleInput">
                <label class="block text-sm font-bold text-slate-700 mb-2">Rincian Tugas:</label>
                <textarea name="content" id="modalContentInput" rows="6"
                    class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-sky-500 text-sm"></textarea>
            </div>
            <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" onclick="closeJobModal()"
                    class="px-5 py-2.5 text-slate-600 font-bold hover:bg-slate-200 rounded-xl">Batal</button>
                <button type="submit"
                    class="px-5 py-2.5 bg-sky-600 text-white font-bold rounded-xl hover:bg-sky-700 shadow-lg">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Schedule Modal -->
<div id="deleteScheduleModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-2xl text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-900 mb-2">Hapus Jadwal?</h3>
                <p class="text-slate-600 text-sm" id="deleteScheduleMessage">
                    Apakah Anda yakin ingin menghapus jadwal ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button onclick="closeDeleteScheduleModal()" class="flex-1 px-4 py-2 bg-slate-100 text-slate-700 font-medium rounded-lg hover:bg-slate-200 transition-colors">Batal</button>
            <form id="deleteScheduleForm" method="POST" class="flex-1">
                <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors shadow-lg shadow-red-500/30">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function openJobModal(role, content) {
    document.getElementById('jobModal').classList.remove('hidden');
    document.getElementById('modalRoleName').innerText = role;
    document.getElementById('modalRoleInput').value = role;
    document.getElementById('modalContentInput').value = content;
}

function closeJobModal() {
    document.getElementById('jobModal').classList.add('hidden');
}

function confirmDeleteSchedule(scheduleId, assistantName) {
    const modal = document.getElementById('deleteScheduleModal');
    const form = document.getElementById('deleteScheduleForm');
    const message = document.getElementById('deleteScheduleMessage');
    
    const deleteUrl = '<?= url('/koordinator/assistant-schedules/') ?>' + scheduleId + '/delete';
    form.action = deleteUrl;
    message.textContent = `Apakah Anda yakin ingin menghapus jadwal untuk "${assistantName}"? Tindakan ini tidak dapat dibatalkan.`;
    
    modal.classList.remove('hidden');
}

function closeDeleteScheduleModal() {
    const modal = document.getElementById('deleteScheduleModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('deleteScheduleModal');
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteScheduleModal();
            }
        });
    }
});
</script>
<?php include APP_PATH . '/views/layouts/footer.php'; ?>