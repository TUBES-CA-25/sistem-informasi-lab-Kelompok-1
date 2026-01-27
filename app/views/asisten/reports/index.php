<?php $title = 'Permasalahan Lab'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900">Permasalahan Laboratorium</h1>
                <p class="text-slate-500 mt-1">Laporkan dan pantau kerusakan hardware/software</p>
            </div>
            <a href="<?= url('/asisten/problems/create') ?>" class="px-6 py-3 bg-emerald-600 text-white font-bold rounded-lg hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-500/30 flex items-center gap-2">
                <i class="bi bi-plus-lg"></i> Lapor Masalah Baru
            </a>
        </div>

        <?php displayFlash(); ?>

        <!-- Filter & Search -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 mb-6">
            <form method="GET" action="<?= url('/asisten/problems') ?>" class="space-y-4">
                
                <!-- Filter Pills -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Filter Status:</label>
                    <div class="flex flex-wrap gap-2">
                        <?php
                        $statuses = [
                            'active' => ['label' => 'Aktif', 'color' => 'slate'],
                            'all' => ['label' => 'Semua', 'color' => 'slate'],
                            'reported' => ['label' => 'Pending', 'color' => 'amber'],
                            'in_progress' => ['label' => 'Diproses', 'color' => 'sky'],
                            'resolved' => ['label' => 'Selesai', 'color' => 'emerald']
                        ];
                        
                        $currentStatus = $filters['status'] ?? 'active';
                        
                        foreach ($statuses as $value => $config):
                            $isActive = ($currentStatus === $value);
                            $colorClass = $isActive 
                                ? "bg-{$config['color']}-600 text-white border-{$config['color']}-600" 
                                : "bg-white text-slate-600 border-slate-300 hover:bg-slate-50";
                        ?>
                            <button 
                                type="submit" 
                                name="status" 
                                value="<?= $value ?>"
                                class="px-4 py-2 rounded-lg border-2 font-medium text-sm transition-all <?= $colorClass ?>">
                                <?= $config['label'] ?>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Search -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Cari Masalah:</label>
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <i class="bi bi-search text-slate-400"></i>
                            </div>
                            <input 
                                type="text" 
                                name="search" 
                                value="<?= e($filters['search'] ?? '') ?>"
                                placeholder="Cari pelapor / PC / lab..." 
                                class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                        <button 
                            type="submit"
                            class="px-6 py-2.5 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700">
                            <i class="bi bi-search mr-1"></i> Cari
                        </button>
                        <?php if (!empty($filters['search'])): ?>
                            <a 
                                href="<?= url('/asisten/problems?status=' . $currentStatus) ?>"
                                class="px-4 py-2.5 bg-slate-200 text-slate-700 font-semibold rounded-lg hover:bg-slate-300">
                                <i class="bi bi-x-circle"></i> Reset
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Info -->
        <div class="mb-4 text-sm text-slate-600">
            Menampilkan <span class="font-bold"><?= count($problems) ?></span> dari <span class="font-bold"><?= $pagination['totalRecords'] ?></span> hasil
            <?php if (!empty($filters['search'])): ?>
                untuk "<span class="font-bold text-emerald-600"><?= e($filters['search']) ?></span>"
            <?php endif; ?>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <?php if (empty($problems)): ?>
                <div class="flex flex-col items-center justify-center py-16">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                        <i class="bi bi-inbox text-4xl text-slate-400"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-700">Tidak Ada Masalah Ditemukan</h3>
                    <p class="text-slate-500 text-sm">
                        <?php if (!empty($filters['search'])): ?>
                            Coba kata kunci lain atau reset filter
                        <?php else: ?>
                            Belum ada laporan dengan status ini
                        <?php endif; ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-xs font-bold border-b">
                            <tr>
                                <th class="px-6 py-4">Lab & PC</th>
                                <th class="px-6 py-4">Pelapor</th>
                                <th class="px-6 py-4">Masalah</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($problems as $problem): ?>
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-900"><?= e($problem['lab_name']) ?></div>
                                        <span class="text-xs bg-slate-100 px-2 py-1 rounded font-mono">PC-<?= e($problem['pc_number']) ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center text-xs font-bold text-emerald-700">
                                                <?= strtoupper(substr($problem['reporter_name'], 0, 2)) ?>
                                            </div>
                                            <span class="text-slate-700"><?= e($problem['reporter_name']) ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 max-w-xs">
                                        <div class="text-xs font-bold text-slate-500 uppercase mb-1"><?= e($problem['problem_type']) ?></div>
                                        <p class="text-slate-600 line-clamp-2"><?= e($problem['description']) ?></p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php
                                        $statusConfig = [
                                            'reported' => ['label' => 'Pending', 'color' => 'bg-amber-100 text-amber-700 border-amber-200'],
                                            'in_progress' => ['label' => 'Diproses', 'color' => 'bg-sky-100 text-sky-700 border-sky-200'],
                                            'resolved' => ['label' => 'Selesai', 'color' => 'bg-emerald-100 text-emerald-700 border-emerald-200']
                                        ];
                                        $status = $statusConfig[$problem['status']] ?? ['label' => 'Unknown', 'color' => 'bg-slate-100'];
                                        ?>
                                        <span class="px-3 py-1.5 text-xs font-bold rounded-lg border <?= $status['color'] ?>">
                                            <?= $status['label'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-500">
                                        <i class="bi bi-calendar3"></i>
                                        <?= date('d M Y', strtotime($problem['reported_at'])) ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
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
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($pagination['total'] > 1): ?>
                    <div class="px-6 py-4 border-t bg-slate-50 flex justify-between items-center">
                        <div class="text-sm text-slate-600">
                            Halaman <?= $pagination['current'] ?> dari <?= $pagination['total'] ?>
                        </div>
                        <div class="flex gap-1">
                            <?php if ($pagination['current'] > 1): ?>
                                <a href="<?= url('/asisten/problems?status=' . $currentStatus . '&search=' . urlencode($filters['search']) . '&page=' . ($pagination['current'] - 1)) ?>" class="px-3 py-2 bg-white border text-slate-700 rounded-lg hover:bg-slate-50 text-sm">
                                    <i class="bi bi-chevron-left"></i> Prev
                                </a>
                            <?php endif; ?>

                            <?php
                            $start = max(1, $pagination['current'] - 2);
                            $end = min($pagination['total'], $pagination['current'] + 2);
                            for ($i = $start; $i <= $end; $i++):
                            ?>
                                <a href="<?= url('/asisten/problems?status=' . $currentStatus . '&search=' . urlencode($filters['search']) . '&page=' . $i) ?>" class="px-4 py-2 rounded-lg text-sm <?= $i === $pagination['current'] ? 'bg-emerald-600 text-white' : 'bg-white border text-slate-700 hover:bg-slate-50' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($pagination['current'] < $pagination['total']): ?>
                                <a href="<?= url('/asisten/problems?status=' . $currentStatus . '&search=' . urlencode($filters['search']) . '&page=' . ($pagination['current'] + 1)) ?>" class="px-3 py-2 bg-white border text-slate-700 rounded-lg hover:bg-slate-50 text-sm">
                                    Next <i class="bi bi-chevron-right"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
