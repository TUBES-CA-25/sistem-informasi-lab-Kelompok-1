<?php $title = 'Permasalahan Lab'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Permasalahan Laboratorium</h1>
                <p class="text-slate-500 mt-1">Kelola laporan kerusakan hardware dan software.</p>
            </div>

            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200 flex items-center gap-3">
                <span class="text-sm font-medium text-slate-500">Total Masalah:</span>
                <span class="text-lg font-bold text-sky-600"><?= count($problems) ?></span>
            </div>
        </div>

        <div class="flex flex-wrap gap-2 mb-6">
            <a href="<?= url('/koordinator/problems') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= !isset($currentStatus) ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                Semua
            </a>
            <a href="<?= url('/koordinator/problems?status=reported') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= ($currentStatus ?? '') == 'reported' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                Reported
            </a>
            <a href="<?= url('/koordinator/problems?status=in_progress') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= ($currentStatus ?? '') == 'in_progress' ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                In Progress
            </a>
            <a href="<?= url('/koordinator/problems?status=resolved') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= ($currentStatus ?? '') == 'resolved' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                Resolved
            </a>
        </div>

        <?php displayFlash(); ?>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <?php if (empty($problems)): ?>
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-clipboard-check text-4xl text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900">Tidak ada masalah ditemukan</h3>
                    <p class="text-slate-500">Saat ini tidak ada laporan permasalahan dengan filter ini.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Lokasi / Lab</th>
                                <th class="px-6 py-4">Masalah</th>
                                <th class="px-6 py-4">Pelapor</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($problems as $problem): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 font-bold text-slate-700">#<?= $problem['id'] ?></td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800"><?= e($problem['lab_name']) ?></div>
                                        <div class="text-xs text-slate-500 mt-1">
                                            PC: <span class="font-mono bg-slate-100 px-1 rounded"><?= e($problem['pc_number']) ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide <?= $problem['problem_type'] == 'hardware' ? 'bg-rose-100 text-rose-600' : 'bg-indigo-100 text-indigo-600' ?>">
                                                <?= e($problem['problem_type']) ?>
                                            </span>
                                            <span class="text-xs text-slate-400"><?= formatDate($problem['reported_at']) ?></span>
                                        </div>
                                        <p class="text-slate-600 line-clamp-1"><?= e($problem['description']) ?></p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">
                                                <?= strtoupper(substr($problem['reporter_name'], 0, 1)) ?>
                                            </div>
                                            <span class="text-slate-700"><?= e($problem['reporter_name']) ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?= getStatusBadge($problem['status']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="<?= url('/koordinator/problems/' . $problem['id']) ?>" class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-sky-700 bg-sky-50 border border-sky-100 rounded-lg hover:bg-sky-100 transition-colors">
                                            Detail & Update
                                        </a>
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

<?php include APP_PATH . '/views/layouts/footer.php'; ?>