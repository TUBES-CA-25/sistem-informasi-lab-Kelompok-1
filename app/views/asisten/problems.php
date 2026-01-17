<?php $title = 'Permasalahan Lab'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Permasalahan Laboratorium</h1>
                <p class="text-slate-500 mt-2 text-lg">Laporkan dan pantau kerusakan hardware/software di sini.</p>
            </div>

            <button data-modal-target="addProblemModal" data-modal-toggle="addProblemModal" class="text-white bg-sky-600 hover:bg-sky-700 font-bold rounded-full text-sm px-6 py-3 shadow-lg shadow-sky-500/30 transition-transform hover:-translate-y-1 flex items-center gap-2">
                <i class="bi bi-plus-lg text-lg"></i>
                Lapor Masalah Baru
            </button>
        </div>

        <?php displayFlash(); ?>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-slate-500">
                    <thead class="bg-slate-50 text-slate-700 uppercase text-xs font-bold tracking-wider">
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
                                    <td class="px-6 py-4 align-top">
                                        <div class="font-bold text-slate-900 text-base"><?= e($problem['lab_name']) ?></div>
                                        <span class="inline-flex items-center mt-1 px-2.5 py-0.5 rounded-md text-xs font-medium bg-slate-100 text-slate-800 border border-slate-200">
                                            <i class="bi bi-pc-display mr-1"></i> PC-<?= e($problem['pc_number']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 align-top max-w-md">
                                        <span class="inline-flex mb-2 px-2 py-1 text-[10px] font-bold uppercase rounded-md <?= $problem['problem_type'] == 'hardware' ? 'bg-rose-50 text-rose-700 border border-rose-100' : 'bg-indigo-50 text-indigo-700 border border-indigo-100' ?>">
                                            <?= e($problem['problem_type']) ?>
                                        </span>
                                        <p class="text-slate-600 text-sm leading-relaxed"><?= nl2br(e($problem['description'])) ?></p>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-500">
                                                <?= strtoupper(substr($problem['reporter_name'], 0, 1)) ?>
                                            </div>
                                            <div>
                                                <div class="font-medium text-slate-900 text-sm"><?= e($problem['reporter_name']) ?></div>
                                                <div class="text-xs text-slate-400"><?= formatDate($problem['reported_at']) ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <?= getStatusBadge($problem['status']) ?>
                                    </td>
                                    <td class="px-6 py-4 align-top text-center whitespace-nowrap">
                                        <?php if ($problem['reported_by'] == getUserId()): ?>

                                            <a href="<?= url('/asisten/problems/' . $problem['id'] . '/edit') ?>" class="inline-block text-amber-500 hover:text-amber-700 p-2 hover:bg-amber-50 rounded-full transition-colors mr-1" title="Edit Laporan">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form method="POST" action="<?= url('/asisten/delete-problem/' . $problem['id']) ?>" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')" class="inline-block">
                                                <button type="submit" class="text-rose-500 hover:text-rose-700 p-2 hover:bg-rose-50 rounded-full transition-colors" title="Hapus Laporan">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>

                                        <?php else: ?>
                                            <span class="text-xs text-slate-400 italic">View Only</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="bi bi-check-circle-fill text-4xl text-emerald-400"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-slate-900">Aman Terkendali!</h3>
                                    <p class="text-slate-500 mt-1">Belum ada laporan kerusakan di laboratorium.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<div id="addProblemModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm bg-slate-900/50">
    <div class="relative w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-2xl shadow-2xl">
            <div class="flex items-start justify-between p-5 border-b rounded-t">
                <h3 class="text-xl font-bold text-slate-900">Lapor Kerusakan</h3>
                <button type="button" class="text-slate-400 bg-transparent hover:bg-slate-100 hover:text-slate-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center" data-modal-hide="addProblemModal">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
            <div class="p-6">
                <form action="<?= url('/asisten/create-problem') ?>" method="POST">
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-slate-700">Laboratorium</label>
                        <select name="laboratory_id" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5" required>
                            <?php foreach ($laboratories as $lab): ?>
                                <option value="<?= $lab['id'] ?>"><?= e($lab['lab_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">No. PC</label>
                            <input type="text" name="pc_number" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5" placeholder="01" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">Kategori</label>
                            <select name="problem_type" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5">
                                <option value="software">Software</option>
                                <option value="hardware">Hardware</option>
                                <option value="network">Jaringan</option>
                                <option value="other">Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-bold text-slate-700">Deskripsi Masalah</label>
                        <textarea name="description" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 block w-full p-2.5" placeholder="Contoh: Layar monitor berkedip..." required></textarea>
                    </div>
                    <button type="submit" class="w-full text-white bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-sky-300 font-bold rounded-lg text-sm px-5 py-3 text-center transition-all">Kirim Laporan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>