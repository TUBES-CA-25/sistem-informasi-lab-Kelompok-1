<?php $title = 'Jadwal Piket ICLABS'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-[95%] mx-auto">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Jadwal Piket Laboratorium</h1>
                    <p class="text-slate-500 text-sm">Klik kolom "Tugas" untuk mengedit rincian pekerjaan.</p>
                </div>
                <a href="<?= url('/admin/assistant-schedules/create') ?>"
                    class="bg-blue-600 text-white px-5 py-2.5 rounded-xl font-bold shadow-md hover:bg-blue-700 flex items-center gap-2 transition-all">
                    <i class="bi bi-plus-lg"></i> Tambah Jadwal
                </a>
            </div>

            <?php displayFlash(); ?>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-center border-collapse">
                        <thead
                            class="bg-slate-100 text-slate-700 border-b-2 border-slate-200 uppercase text-xs font-bold">
                            <tr>
                                <th class="px-4 py-4 w-1/6 border-r border-slate-200 bg-slate-200">Tugas / Role</th>
                                <?php foreach ($days as $day): ?>
                                <th class="px-2 py-3 border-r border-slate-200 min-w-[120px]"><?= $day ?></th>
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
                                            class="font-bold text-sm uppercase tracking-wider mb-2 border-b border-black/10 pb-1 w-fit">
                                            Tugas <?= $role ?>
                                        </span>

                                        <p class="text-xs font-medium leading-relaxed whitespace-pre-line">
                                            <?= e($jobText) ?>
                                        </p>

                                        <div
                                            class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <i class="bi bi-pencil-square text-lg"></i>
                                        </div>
                                    </button>
                                </td>

                                <?php foreach ($days as $day): ?>
                                <td
                                    class="p-2 align-top border-r border-slate-100 border-b border-slate-100 h-full relative">
                                    <div class="flex flex-col gap-2 h-full">
                                        <?php if (!empty($matrix[$role][$day])): ?>
                                        <?php foreach ($matrix[$role][$day] as $sched): ?>
                                        <div
                                            class="group/item relative bg-white border border-slate-200 rounded-lg p-2 shadow-sm hover:shadow-md hover:border-blue-400 transition-all text-left">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-[10px] font-bold text-slate-500">
                                                    <?= substr($sched['assistant_name'], 0, 1) ?>
                                                </div>
                                                <span class="text-xs font-semibold text-slate-700 truncate">
                                                    <?= explode(' ', $sched['assistant_name'])[0] ?>
                                                </span>
                                            </div>

                                            <div class="absolute -top-2 -right-2 hidden group-hover/item:flex gap-1">
                                                <a href="<?= url('/admin/assistant-schedules/' . $sched['id'] . '/edit') ?>"
                                                    class="w-5 h-5 bg-amber-400 text-white rounded-full flex items-center justify-center text-[10px] shadow-sm hover:bg-amber-500">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form method="POST"
                                                    action="<?= url('/admin/assistant-schedules/' . $sched['id'] . '/delete') ?>"
                                                    onsubmit="return confirm('Hapus jadwal ini?')">
                                                    <button type="submit"
                                                        class="w-5 h-5 bg-rose-500 text-white rounded-full flex items-center justify-center text-[10px] shadow-sm hover:bg-rose-600">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <span class="text-slate-200 text-2xl font-light mt-4 block">-</span>
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
    </main>

    <div id="jobModal"
        class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 transition-opacity">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl transform scale-100 transition-transform">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50 rounded-t-2xl">
                <h3 class="font-bold text-lg text-slate-800">
                    <i class="bi bi-pencil-square mr-2 text-blue-600"></i>
                    Edit Jobdesk <span id="modalRoleName"></span>
                </h3>
                <button onclick="closeJobModal()" class="text-slate-400 hover:text-rose-500 transition-colors">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>

            <form action="<?= url('/admin/assistant-schedules/update-job') ?>" method="POST">
                <div class="p-6">
                    <input type="hidden" name="role" id="modalRoleInput">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Daftar Pekerjaan:</label>
                    <textarea name="content" id="modalContentInput" rows="6"
                        class="w-full p-4 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 text-sm leading-relaxed"
                        placeholder="Contoh: Menyapu, Mengepel, Cuci Piring..."></textarea>

                    <div class="mt-4 p-3 bg-blue-50 text-blue-700 rounded-lg text-xs flex items-start gap-2">
                        <i class="bi bi-info-circle-fill mt-0.5"></i>
                        <p>Perubahan ini akan memperbarui deskripsi tugas untuk <b>semua hari</b> pada role ini.</p>
                    </div>
                </div>
                <div class="p-4 bg-slate-50 border-t border-slate-100 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" onclick="closeJobModal()"
                        class="px-5 py-2.5 text-slate-600 font-bold hover:bg-slate-200 rounded-xl transition-colors">Batal</button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-500/30 transition-all">Simpan
                        Perubahan</button>
                </div>
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

// Close on click outside
document.getElementById('jobModal').addEventListener('click', function(e) {
    if (e.target === this) closeJobModal();
});
</script>