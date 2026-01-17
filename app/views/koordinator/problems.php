<?php $title = 'Permasalahan Lab'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Permasalahan Laboratorium</h1>
                <p class="text-slate-500 mt-1">Kelola laporan kerusakan hardware dan software.</p>
            </div>

            <a href="<?= url('/koordinator/problems/create') ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg shadow-lg shadow-sky-500/30 transition-all">
                <i class="bi bi-plus-lg"></i>
                <span>Buat Laporan</span>
            </a>
        </div>

        <!-- Filter Pills -->
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="<?= url('/koordinator/problems?status=active') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $filters['status'] == 'active' ? 'bg-sky-600 text-white shadow-lg shadow-sky-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                Aktif
            </a>
            <a href="<?= url('/koordinator/problems?status=all') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $filters['status'] == 'all' ? 'bg-slate-600 text-white shadow-lg' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                Semua
            </a>
            <a href="<?= url('/koordinator/problems?status=reported') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $filters['status'] == 'reported' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                Pending
            </a>
            <a href="<?= url('/koordinator/problems?status=in_progress') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $filters['status'] == 'in_progress' ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                Diproses
            </a>
            <a href="<?= url('/koordinator/problems?status=resolved') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $filters['status'] == 'resolved' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">
                Selesai
            </a>
        </div>

        <!-- Search Bar -->
        <div class="mb-6">
            <form method="GET" action="<?= url('/koordinator/problems') ?>" class="flex gap-2">
                <input type="hidden" name="status" value="<?= htmlspecialchars($filters['status']) ?>">
                <div class="flex-1">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="bi bi-search text-slate-400"></i>
                        </div>
                        <input type="text" name="search" value="<?= htmlspecialchars($filters['search']) ?>" placeholder="Cari lab, PC, atau deskripsi masalah..." class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm">
                    </div>
                </div>
                <button type="submit" class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium transition-colors">
                    Cari
                </button>
                <?php if (!empty($filters['search'])): ?>
                    <a href="<?= url('/koordinator/problems?status=' . $filters['status']) ?>" class="px-4 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg font-medium transition-colors">
                        Reset
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <?php displayFlash(); ?>

        <!-- Problems Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <?php if (empty($problems)): ?>
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-clipboard-check text-4xl text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900">Tidak ada masalah ditemukan</h3>
                    <p class="text-slate-500 mt-1">
                        <?php if (!empty($filters['search'])): ?>
                            Tidak ada hasil untuk pencarian "<?= htmlspecialchars($filters['search']) ?>"
                        <?php else: ?>
                            Saat ini tidak ada laporan permasalahan dengan filter ini.
                        <?php endif; ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b">
                            <tr>
                                <th scope="col" class="px-6 py-3">Lab / PC</th>
                                <th scope="col" class="px-6 py-3">Pelapor</th>
                                <th scope="col" class="px-6 py-3">Jenis / Deskripsi</th>
                                <th scope="col" class="px-6 py-3">Status</th>
                                <th scope="col" class="px-6 py-3">Ditugaskan</th>
                                <th scope="col" class="px-6 py-3">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($problems as $problem): ?>
                                <tr class="bg-white hover:bg-slate-50">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-900"><?= htmlspecialchars($problem['lab_name']) ?></div>
                                        <?php if ($problem['pc_number']): ?>
                                            <div class="text-xs text-slate-500">PC <?= htmlspecialchars($problem['pc_number']) ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-slate-900"><?= htmlspecialchars($problem['reporter_name'] ?? '-') ?></div>
                                        <div class="text-xs text-slate-500"><?= htmlspecialchars($problem['reported_by_name'] ?? 'System') ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium <?= $problem['problem_type'] == 'hardware' ? 'bg-red-50 text-red-700' : 'bg-blue-50 text-blue-700' ?>">
                                            <i class="bi bi-<?= $problem['problem_type'] == 'hardware' ? 'cpu' : 'code-slash' ?>"></i>
                                            <?= ucfirst($problem['problem_type']) ?>
                                        </div>
                                        <div class="text-slate-600 mt-1 line-clamp-1"><?= htmlspecialchars($problem['description']) ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php
                                        $statusStyles = [
                                            'reported' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'in_progress' => 'bg-blue-50 text-blue-700 border-blue-200',
                                            'resolved' => 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                        ];
                                        $statusIcons = [
                                            'reported' => 'exclamation-circle',
                                            'in_progress' => 'arrow-repeat',
                                            'resolved' => 'check-circle'
                                        ];
                                        $statusLabels = [
                                            'reported' => 'Pending',
                                            'in_progress' => 'Diproses',
                                            'resolved' => 'Selesai'
                                        ];
                                        $statusClass = $statusStyles[$problem['status']] ?? 'bg-slate-50 text-slate-700';
                                        $statusIcon = $statusIcons[$problem['status']] ?? 'circle';
                                        $statusLabel = $statusLabels[$problem['status']] ?? ucfirst($problem['status']);
                                        ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 border rounded-full text-xs font-medium <?= $statusClass ?>">
                                            <i class="bi bi-<?= $statusIcon ?>"></i>
                                            <?= $statusLabel ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if (!empty($problem['assigned_to_name'])): ?>
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 bg-sky-100 rounded-full flex items-center justify-center">
                                                    <span class="text-xs font-bold text-sky-700"><?= strtoupper(substr($problem['assigned_to_name'], 0, 1)) ?></span>
                                                </div>
                                                <span class="text-slate-900"><?= htmlspecialchars($problem['assigned_to_name']) ?></span>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-slate-400">Belum ditugaskan</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600">
                                        <?= date('d M Y', strtotime($problem['reported_at'])) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="<?= url('/koordinator/problems/' . $problem['id']) ?>" class="text-sky-600 hover:text-sky-800 font-medium" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= url('/koordinator/problems/' . $problem['id'] . '/edit') ?>" class="text-blue-600 hover:text-blue-800 font-medium" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button onclick="confirmDelete(<?= $problem['id'] ?>)" class="text-red-600 hover:text-red-800 font-medium" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <?php if ($pagination['total'] > 1): ?>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="text-sm text-slate-600">
                                Menampilkan halaman <span class="font-medium"><?= $pagination['current'] ?></span> dari <span class="font-medium"><?= $pagination['total'] ?></span>
                                <span class="text-slate-400 ml-2">(Total: <?= $pagination['totalRecords'] ?> laporan)</span>
                            </div>
                            <div class="flex gap-2">
                                <?php if ($pagination['current'] > 1): ?>
                                    <a href="<?= url('/koordinator/problems?status=' . $filters['status'] . '&search=' . urlencode($filters['search']) . '&page=' . ($pagination['current'] - 1)) ?>" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 font-medium">
                                        <i class="bi bi-chevron-left"></i> Sebelumnya
                                    </a>
                                <?php endif; ?>

                                <?php
                                $startPage = max(1, $pagination['current'] - 2);
                                $endPage = min($pagination['total'], $pagination['current'] + 2);
                                for ($i = $startPage; $i <= $endPage; $i++):
                                ?>
                                    <a href="<?= url('/koordinator/problems?status=' . $filters['status'] . '&search=' . urlencode($filters['search']) . '&page=' . $i) ?>" class="px-4 py-2 rounded-lg font-medium <?= $i == $pagination['current'] ? 'bg-sky-600 text-white' : 'bg-white border border-slate-300 text-slate-700 hover:bg-slate-50' ?>">
                                        <?= $i ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if ($pagination['current'] < $pagination['total']): ?>
                                    <a href="<?= url('/koordinator/problems?status=' . $filters['status'] . '&search=' . urlencode($filters['search']) . '&page=' . ($pagination['current'] + 1)) ?>" class="px-4 py-2 bg-white border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 font-medium">
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

<!-- Delete Confirmation Modal -->
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

<script>
function confirmDelete(problemId) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = '<?= url('/koordinator/problems/') ?>' + problemId + '/delete';
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deleteModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
