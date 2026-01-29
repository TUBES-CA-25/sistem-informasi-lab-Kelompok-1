<?php $title = 'Laporan Masalah'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Laporan Masalah</h1>
                    <p class="text-slate-500 text-sm mt-1">Monitoring dan manajemen masalah teknis laboratorium.</p>
                </div>

                <a href="<?= url('/admin/problems/create') ?>"
                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl shadow-lg shadow-primary-500/30 transition-all transform hover:-translate-y-0.5">
                    <i class="bi bi-plus-lg text-lg"></i>
                    <span>Buat Laporan</span>
                </a>
            </div>

            <?php displayFlash(); ?>

            <?php if (isset($statistics)): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between hover:shadow-md transition-shadow">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Laporan</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-1"><?= $statistics['total'] ?? 0 ?></h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center">
                        <i class="bi bi-folder2-open text-xl"></i>
                    </div>
                </div>

                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute inset-0 bg-rose-50 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-rose-500 uppercase tracking-wider">Baru (Reported)</p>
                        <h3 class="text-2xl font-bold text-rose-600 mt-1"><?= $statistics['reported'] ?? 0 ?></h3>
                    </div>
                    <div
                        class="relative z-10 w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center">
                        <i class="bi bi-exclamation-circle-fill text-xl"></i>
                    </div>
                </div>

                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute inset-0 bg-amber-50 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-amber-500 uppercase tracking-wider">Diproses</p>
                        <h3 class="text-2xl font-bold text-amber-600 mt-1"><?= $statistics['in_progress'] ?? 0 ?></h3>
                    </div>
                    <div
                        class="relative z-10 w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                        <i class="bi bi-arrow-repeat text-xl"></i>
                    </div>
                </div>

                <div
                    class="bg-white p-5 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div class="absolute inset-0 bg-emerald-50 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="relative z-10">
                        <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider">Selesai</p>
                        <h3 class="text-2xl font-bold text-emerald-600 mt-1"><?= $statistics['resolved'] ?? 0 ?></h3>
                    </div>
                    <div
                        class="relative z-10 w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <i class="bi bi-check-circle-fill text-xl"></i>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div
                class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col min-h-[600px]">

                <div class="px-6 py-4 border-b border-slate-100 flex flex-wrap gap-2 items-center bg-slate-50/50">
                    <span class="text-xs font-semibold text-slate-500 uppercase mr-2">Filter Status:</span>
                    <?php
                    $currentStatus = $_GET['status'] ?? '';
                    $btnBase = "px-4 py-1.5 rounded-full text-xs font-medium border transition-all duration-200";
                    $btnInactive = "bg-white border-slate-200 text-slate-600 hover:border-primary-300 hover:text-primary-600";
                    $btnActive = "bg-primary-50 border-primary-200 text-primary-700 shadow-sm";
                    ?>

                    <a href="<?= url('/admin/problems') ?>"
                        class="<?= $btnBase ?> <?= $currentStatus == '' ? 'bg-slate-800 border-slate-800 text-white' : $btnInactive ?>">
                        Semua
                    </a>
                    <a href="<?= url('/admin/problems?status=reported') ?>"
                        class="<?= $btnBase ?> <?= $currentStatus == 'reported' ? 'bg-rose-50 border-rose-200 text-rose-700' : $btnInactive ?>">
                        Baru
                    </a>
                    <a href="<?= url('/admin/problems?status=in_progress') ?>"
                        class="<?= $btnBase ?> <?= $currentStatus == 'in_progress' ? 'bg-amber-50 border-amber-200 text-amber-700' : $btnInactive ?>">
                        Diproses
                    </a>
                    <a href="<?= url('/admin/problems?status=resolved') ?>"
                        class="<?= $btnBase ?> <?= $currentStatus == 'resolved' ? 'bg-emerald-50 border-emerald-200 text-emerald-700' : $btnInactive ?>">
                        Selesai
                    </a>
                </div>

                <div class="overflow-x-auto w-full">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold">Lokasi (Lab & PC)</th>
                                <th scope="col" class="px-6 py-4 font-semibold w-1/3">Deskripsi Masalah</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Pelapor</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($problems)): ?>
                            <?php foreach ($problems as $problem): ?>
                            <tr class="group hover:bg-slate-50/80 transition-colors duration-200">

                                <td class="px-6 py-4 align-top">
                                    <div class="flex items-start gap-3">
                                        <div
                                            class="w-9 h-9 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100 mt-1">
                                            <i class="bi bi-pc-display"></i>
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900"><?= e($problem['lab_name']) ?></div>
                                            <div
                                                class="inline-flex items-center gap-1 mt-1 text-xs font-mono bg-slate-100 px-1.5 py-0.5 rounded text-slate-600 border border-slate-200">
                                                PC-<?= e($problem['pc_number']) ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-2">
                                            <span
                                                class="text-[10px] font-bold uppercase tracking-wide px-2 py-0.5 rounded-full border 
                                                        <?= strtolower($problem['problem_type']) == 'hardware' ? 'bg-purple-50 text-purple-700 border-purple-100' : 'bg-cyan-50 text-cyan-700 border-cyan-100' ?>">
                                                <?= strtoupper($problem['problem_type']) ?>
                                            </span>
                                            <span class="text-xs text-slate-400">#<?= $problem['id'] ?></span>
                                        </div>
                                        <p class="text-slate-600 line-clamp-2 leading-relaxed text-xs sm:text-sm">
                                            <?= e($problem['description']) ?>
                                        </p>
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <?php
                                            $status = strtolower($problem['status']);
                                            $badgeClass = match ($status) {
                                                'reported' => 'bg-rose-50 text-rose-700 border-rose-100',
                                                'in_progress' => 'bg-amber-50 text-amber-700 border-amber-100',
                                                'resolved' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                                default => 'bg-slate-50 text-slate-700 border-slate-100'
                                            };
                                            $icon = match ($status) {
                                                'reported' => 'bi-exclamation-circle',
                                                'in_progress' => 'bi-hourglass-split',
                                                'resolved' => 'bi-check-circle',
                                                default => 'bi-circle'
                                            };
                                            ?>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border <?= $badgeClass ?>">
                                        <i class="bi <?= $icon ?>"></i>
                                        <?= ucfirst(str_replace('_', ' ', $status)) ?>
                                    </span>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-500">
                                            <?= strtoupper(substr($problem['reporter_name'], 0, 1)) ?>
                                        </div>
                                        <div class="flex flex-col">
                                            <span
                                                class="text-xs font-semibold text-slate-700"><?= e($problem['reporter_name']) ?></span>
                                            <span
                                                class="text-[10px] text-slate-400"><?= date('d M Y', strtotime($problem['reported_at'])) ?></span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right align-middle">
                                    <div
                                        class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-200">

                                        <a href="<?= url('/admin/problems/' . $problem['id']) ?>"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-primary-600 bg-primary-50 hover:bg-primary-100 hover:scale-105 transition-all border border-transparent hover:border-primary-200"
                                            title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <form method="POST"
                                            action="<?= url('/admin/problems/' . $problem['id'] . '/delete') ?>"
                                            onsubmit="return confirm('Hapus laporan ini? Data tidak bisa dikembalikan.')"
                                            class="inline">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-rose-600 bg-rose-50 hover:bg-rose-100 hover:scale-105 transition-all border border-transparent hover:border-rose-200"
                                                title="Hapus Laporan">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5">
                                    <div class="flex flex-col items-center justify-center py-20 text-center">
                                        <div
                                            class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4 border border-slate-100">
                                            <i class="bi bi-clipboard-check text-3xl"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-slate-900">Tidak Ada Laporan</h3>
                                        <?php if ($currentStatus): ?>
                                        <p class="text-slate-500 max-w-sm mt-1 mb-6 text-sm">Tidak ada laporan dengan
                                            status "<?= ucfirst(str_replace('_', ' ', $currentStatus)) ?>".</p>
                                        <a href="<?= url('/admin/problems') ?>"
                                            class="text-primary-600 hover:underline text-sm">Bersihkan Filter</a>
                                        <?php else: ?>
                                        <p class="text-slate-500 max-w-sm mt-1 text-sm">Bagus! Semua sistem berjalan
                                            lancar.</p>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (!empty($problems)): ?>
                <div
                    class="mt-auto border-t border-slate-100 bg-slate-50 px-6 py-3 text-xs text-slate-500 flex justify-between items-center">
                    <span>Menampilkan <strong><?= count($problems) ?></strong> laporan</span>
                    <?php if ($currentStatus): ?>
                    <span class="bg-slate-200 px-2 py-0.5 rounded text-slate-600">Filter:
                        <?= ucfirst($currentStatus) ?></span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </main>
</div>

<?php include APP_PATH . '/views/admin/layouts/footer.php'; ?>