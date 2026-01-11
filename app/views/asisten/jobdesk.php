<?php $title = 'Jobdesk Saya'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Jobdesk Saya</h1>
                <p class="text-slate-500 mt-1">Daftar tugas maintenance dan perbaikan yang ditanggungjawabkan kepada Anda.</p>
            </div>
        </div>

        <?php displayFlash(); ?>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b">
                        <tr>
                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">Tipe & Masalah</th>
                            <th class="px-6 py-4">Pelapor</th>
                            <th class="px-6 py-4">Penanggung Jawab</th>
                            <th class="px-6 py-4">Tanggal Pengerjaan</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (!empty($myTasks)): ?>
                            <?php foreach ($myTasks as $index => $task): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-bold"><?= $index + 1 ?></td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide <?= $task['problem_type'] == 'hardware' ? 'bg-rose-100 text-rose-600' : 'bg-indigo-100 text-indigo-600' ?>">
                                                <?= e($task['problem_type']) ?>
                                            </span>
                                            <span class="text-xs font-mono bg-slate-100 px-1 rounded">PC-<?= e($task['pc_number']) ?></span>
                                        </div>
                                        <div class="font-bold text-slate-800"><?= e($task['lab_name']) ?></div>
                                        <p class="text-slate-600 text-xs mt-1 italic">"<?= e($task['description']) ?>"</p>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-900"><?= e($task['reporter_name']) ?></div>
                                        <div class="text-xs text-slate-400"><?= formatDate($task['reported_at']) ?></div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="bg-emerald-100 text-emerald-700 px-2 py-1 rounded text-xs font-bold">
                                            <i class="bi bi-person-check-fill mr-1"></i> <?= e($task['pj_name']) ?>
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-xs">
                                        <div class="mb-1">
                                            <span class="font-semibold text-slate-700">Mulai:</span>
                                            <?= !empty($task['started_at']) ? formatDate($task['started_at']) : '<span class="text-slate-400">-</span>' ?>
                                        </div>
                                        <div>
                                            <span class="font-semibold text-slate-700">Selesai:</span>
                                            <?= !empty($task['completed_at']) ? formatDate($task['completed_at']) : '<span class="text-slate-400">-</span>' ?>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <?= getStatusBadge($task['status']) ?>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <button data-modal-target="updateModal-<?= $task['id'] ?>" data-modal-toggle="updateModal-<?= $task['id'] ?>" class="text-white bg-sky-600 hover:bg-sky-700 font-medium rounded-lg text-xs px-3 py-2 shadow transition-colors">
                                            <i class="bi bi-pencil-square mr-1"></i> Update Status
                                        </button>

                                        <div id="updateModal-<?= $task['id'] ?>" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                            <div class="relative w-full max-w-md max-h-full">
                                                <div class="relative bg-white rounded-lg shadow-xl">
                                                    <div class="flex items-start justify-between p-4 border-b rounded-t bg-slate-50">
                                                        <h3 class="text-lg font-bold text-slate-800">Update Progress Pekerjaan</h3>
                                                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="updateModal-<?= $task['id'] ?>">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                    </div>
                                                    <div class="p-6 text-left">
                                                        <form action="<?= url('/asisten/update-task-status/' . $task['id']) ?>" method="POST">
                                                            <div class="mb-4">
                                                                <label class="block mb-2 text-sm font-medium text-gray-900">Ubah Status</label>
                                                                <select name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                                    <option value="in_progress" <?= $task['status'] == 'in_progress' ? 'selected' : '' ?>>Sedang Dikerjakan (Start)</option>
                                                                    <option value="resolved" <?= $task['status'] == 'resolved' ? 'selected' : '' ?>>Selesai (Completed)</option>
                                                                    <option value="reported" <?= $task['status'] == 'reported' ? 'selected' : '' ?>>Pending / Belum Dikerjakan</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-4">
                                                                <label class="block mb-2 text-sm font-medium text-gray-900">Keterangan / Catatan</label>
                                                                <textarea name="note" rows="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300" placeholder="Contoh: Sudah mengganti kabel VGA, monitor kembali normal."></textarea>
                                                            </div>
                                                            <button type="submit" class="w-full text-white bg-emerald-600 hover:bg-emerald-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-lg shadow-emerald-500/30">Simpan Update</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <i class="bi bi-clipboard-check text-2xl text-slate-400"></i>
                                    </div>
                                    <p class="font-medium text-slate-600">Tidak ada pekerjaan yang ditugaskan.</p>
                                    <p class="text-xs text-slate-400 mt-1">Anda bisa bersantai atau mengecek jadwal piket.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include APP_PATH . '/views/layouts/footer.php'; ?>