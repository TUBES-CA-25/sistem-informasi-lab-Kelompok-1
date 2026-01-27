<?php $title = 'Permasalahan Lab'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Permasalahan Laboratorium</h1>
                <p class="text-slate-500 mt-1">Laporkan dan pantau kerusakan hardware/software di laboratorium.</p>
            </div>

            <a href="<?= url('/asisten/problems/create') ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg shadow-lg shadow-sky-500/30 transition-all">
                <i class="bi bi-plus-lg"></i>
                <span>Buat Laporan</span>
            </a>
        </div>

        <?php displayFlash(); ?>

        <div class="flex flex-wrap gap-2 mb-6">
            <?php $currentStatus = $filters['status'] ?? 'active'; ?>
            
            <a href="<?= url('/asisten/problems?status=active') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $currentStatus == 'active' ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                Aktif
            </a>
            <a href="<?= url('/asisten/problems?status=all') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $currentStatus == 'all' ? 'bg-slate-600 text-white shadow-lg' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                Semua
            </a>
            <a href="<?= url('/asisten/problems?status=reported') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $currentStatus == 'reported' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                Pending
            </a>
            <a href="<?= url('/asisten/problems?status=in_progress') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $currentStatus == 'in_progress' ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                Diproses
            </a>
            <a href="<?= url('/asisten/problems?status=resolved') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $currentStatus == 'resolved' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                Selesai
            </a>
        </div>

        <div class="mb-6">
            <form method="GET" action="<?= url('/asisten/problems') ?>" class="flex gap-2">
                <input type="hidden" name="status" value="<?= htmlspecialchars($currentStatus) ?>">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="bi bi-search text-slate-400"></i>
                        </div>
                        <input type="text" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>" placeholder="Cari lab, PC, atau deskripsi masalah..." class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm">
                    </div>
                </div>
                <button type="submit" class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium transition-colors">
                    Cari
                </button>
                <?php if (!empty($filters['search'])): ?>
                    <a href="<?= url('/asisten/problems?status=' . $currentStatus) ?>" class="px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-medium transition-colors">
                        Reset
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            
            <?php if (empty($problems)): ?>
                <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 animate-blob">
                        <i class="bi bi-clipboard-check text-4xl text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 mb-1">Tidak ada masalah ditemukan</h3>
                    <p class="text-slate-500 text-sm">
                        Belum ada laporan permasalahan yang sesuai dengan filter atau pencarian Anda.
                    </p>
                </div>
            <?php else: ?>
                
                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b">
                            <tr>
                                <th class="px-6 py-3">Lokasi & PC</th>
                                <th class="px-6 py-3">Pelapor</th>
                                <th class="px-6 py-3 w-1/3">Detail Masalah</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($problems as $problem): ?>
                                <tr class="bg-white hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-900"><?= e($problem['lab_name']) ?></div>
                                        <?php if ($problem['pc_number']): ?>
                                            <div class="text-xs text-slate-500">PC <?= e($problem['pc_number']) ?></div>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-slate-900"><?= e($problem['reporter_name']) ?></div>
                                        <div class="text-xs text-slate-500"><?= date('d M Y', strtotime($problem['reported_at'])) ?></div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 mb-1">
                                            <?= ucfirst($problem['problem_type']) ?>
                                        </div>
                                        <div class="text-slate-600 line-clamp-2 leading-relaxed">
                                            <?= e($problem['description']) ?>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <?php
                                        $statusConfig = [
                                            'reported' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'label' => 'Pending', 'icon' => 'bi-hourglass-split'],
                                            'in_progress' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'label' => 'Diproses', 'icon' => 'bi-gear-wide-connected'],
                                            'resolved' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'label' => 'Selesai', 'icon' => 'bi-check-circle-fill']
                                        ];
                                        $s = $statusConfig[$problem['status']] ?? $statusConfig['reported'];
                                        ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 border rounded-full text-xs font-medium <?= $s['bg'] ?> <?= $s['text'] ?> <?= $s['border'] ?>">
                                            <i class="bi <?= $s['icon'] ?>"></i> <?= $s['label'] ?>
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <?php if ($problem['reported_by'] == getUserId()): ?>
                                            <a href="<?= url('/asisten/problems/' . $problem['id'] . '/edit') ?>" class="text-amber-600 hover:text-amber-700 mr-2" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form method="POST" action="<?= url('/asisten/delete-problem/' . $problem['id']) ?>" onsubmit="return confirm('Hapus laporan?')" class="inline">
                                                <button type="submit" class="text-rose-600 hover:text-rose-700" title="Hapus">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <span class="text-xs text-slate-400">View</span>
                                        <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="md:hidden divide-y divide-slate-100">
                    <?php foreach ($problems as $problem): ?>
                        <?php
                        $s = $statusConfig[$problem['status']] ?? $statusConfig['reported'];
                        ?>
                        <div class="p-5 hover:bg-slate-50 transition-colors">
                            <div class="flex justify-between items-start mb-3">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-bold border <?= $s['bg'] ?> <?= $s['text'] ?> <?= $s['border'] ?>">
                                    <i class="bi <?= $s['icon'] ?>"></i> <?= strtoupper($s['label']) ?>
                                </span>
                                <span class="text-xs text-slate-400">
                                    <?= date('d M, H:i', strtotime($problem['reported_at'])) ?>
                                </span>
                            </div>

                            <div class="mb-4">
                                <h3 class="text-slate-900 font-medium mb-1 line-clamp-2 leading-snug">
                                    <?= e($problem['description']) ?>
                                </h3>
                                <div class="flex items-center gap-2 text-xs text-slate-500 mt-2">
                                    <span class="flex items-center gap-1 bg-slate-100 px-2 py-1 rounded">
                                        <i class="bi bi-geo-alt"></i> <?= e($problem['lab_name']) ?>
                                    </span>
                                    <span class="flex items-center gap-1 bg-slate-100 px-2 py-1 rounded font-mono">
                                        <i class="bi bi-pc"></i> <?= e($problem['pc_number'] ?: '-') ?>
                                    </span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-slate-200 text-[10px] flex items-center justify-center font-bold text-slate-600">
                                        <?= strtoupper(substr($problem['reporter_name'], 0, 1)) ?>
                                    </div>
                                    <span class="text-xs font-medium text-slate-600 truncate max-w-[150px]">
                                        <?= e($problem['reporter_name']) ?>
                                    </span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <?php if ($problem['reported_by'] == getUserId()): ?>
                                        <a href="<?= url('/asisten/problems/' . $problem['id'] . '/edit') ?>" 
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Edit
                                        </a>
                                        <button onclick="confirmDelete(<?= $problem['id'] ?>)" 
                                                class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            Hapus
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($pagination['total'] > 1): ?>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-sm text-slate-600">
                                Menampilkan halaman <span class="font-medium"><?= $pagination['current'] ?></span> dari <span class="font-medium"><?= $pagination['total'] ?></span>
                            </div>
                            <div class="flex gap-2">
                                <?php if ($pagination['current'] > 1): ?>
                                    <a href="<?= url('/asisten/problems?status=' . $currentStatus . '&search=' . urlencode($filters['search']) . '&page=' . ($pagination['current'] - 1)) ?>" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 font-medium">
                                        <i class="bi bi-chevron-left"></i> Sebelumnya
                                    </a>
                                <?php endif; ?>

                                <?php if ($pagination['current'] < $pagination['total']): ?>
                                    <a href="<?= url('/asisten/problems?status=' . $currentStatus . '&search=' . urlencode($filters['search']) . '&page=' . ($pagination['current'] + 1)) ?>" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 font-medium">
                                        Selanjutnya <i class="bi bi-chevron-right"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            <?php endif; ?>
        </div>

    </div>
</div>

<div id="deleteModal" class="hidden fixed inset-0 bg-slate-900/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-2xl text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-slate-900 mb-2">Hapus Laporan?</h3>
                <p class="text-slate-600 text-sm">
                    Apakah Anda yakin ingin menghapus laporan ini? Tindakan ini tidak dapat dibatalkan.
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

<?php include APP_PATH . '/views/layouts/footer.php'; ?>