<?php $title = 'Permasalahan Lab'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Permasalahan Laboratorium</h1>
                <p class="text-slate-500 mt-1">Laporkan kerusakan hardware atau software di sini.</p>
            </div>

            <button data-modal-target="addProblemModal" data-modal-toggle="addProblemModal" class="text-white bg-sky-600 hover:bg-sky-700 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center shadow-lg shadow-sky-500/30 transition-all">
                <i class="bi bi-plus-lg mr-2"></i> Lapor Masalah Baru
            </button>
        </div>

        <?php displayFlash(); ?>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b">
                        <tr>
                            <th class="px-6 py-4">Lokasi & PC</th>
                            <th class="px-6 py-4">Detail Masalah</th>
                            <th class="px-6 py-4">Pelapor</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (!empty($problems)): ?>
                            <?php foreach ($problems as $problem): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800"><?= e($problem['lab_name']) ?></div>
                                        <div class="text-xs bg-slate-100 px-2 py-0.5 rounded inline-block mt-1">
                                            PC-<?= e($problem['pc_number']) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide <?= $problem['problem_type'] == 'hardware' ? 'bg-rose-100 text-rose-600' : 'bg-indigo-100 text-indigo-600' ?>">
                                            <?= e($problem['problem_type']) ?>
                                        </span>
                                        <p class="text-slate-600 mt-1 line-clamp-1"><?= e($problem['description']) ?></p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= e($problem['reporter_name']) ?>
                                        <div class="text-xs text-slate-400"><?= formatDate($problem['reported_at']) ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= getStatusBadge($problem['status']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <?php if ($problem['reported_by'] == getUserId()): ?>
                                            <form method="POST" action="<?= url('/asisten/delete-problem/' . $problem['id']) ?>" onsubmit="return confirm('Hapus laporan ini?')" class="inline">
                                                <button type="submit" class="text-rose-600 hover:text-rose-800 p-2 hover:bg-rose-50 rounded" title="Hapus Laporan">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-xs text-slate-400 italic">Read Only</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-slate-400">Belum ada laporan masalah.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="addProblemModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-xl">
            <div class="flex items-start justify-between p-4 border-b rounded-t bg-slate-50">
                <h3 class="text-lg font-bold text-slate-800">Lapor Masalah Baru</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="addProblemModal">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="p-6">
                <form action="<?= url('/asisten/create-problem') ?>" method="POST">
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Laboratorium</label>
                        <select name="laboratory_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required>
                            <?php foreach ($laboratories as $lab): ?>
                                <option value="<?= $lab['id'] ?>"><?= e($lab['lab_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Nomor PC</label>
                            <input type="text" name="pc_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Contoh: 05" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900">Jenis Masalah</label>
                            <select name="problem_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
                                <option value="software">Software</option>
                                <option value="hardware">Hardware</option>
                                <option value="network">Jaringan</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900">Deskripsi Masalah</label>
                        <textarea name="description" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" placeholder="Jelaskan detail kerusakannya..." required></textarea>
                    </div>
                    <button type="submit" class="w-full text-white bg-sky-600 hover:bg-sky-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center shadow-lg shadow-sky-500/30">Kirim Laporan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>