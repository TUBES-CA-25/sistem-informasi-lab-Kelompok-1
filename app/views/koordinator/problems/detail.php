<?php $title = 'Detail Permasalahan'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="<?= url('/koordinator/problems') ?>" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="bi bi-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold text-slate-800">Detail Permasalahan #<?= $problem['id'] ?></h1>
            </div>
        </div>

        <?php displayFlash(); ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Problem Information -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="bi bi-info-circle text-sky-600"></i>
                        Informasi Permasalahan
                    </h2>
                    <div class="space-y-3">
                        <div class="flex border-b border-slate-100 pb-3">
                            <div class="w-40 text-sm font-medium text-slate-600">Laboratorium</div>
                            <div class="flex-1 text-sm text-slate-900"><?= htmlspecialchars($problem['lab_name']) ?></div>
                        </div>
                        <?php if ($problem['pc_number']): ?>
                        <div class="flex border-b border-slate-100 pb-3">
                            <div class="w-40 text-sm font-medium text-slate-600">PC Number</div>
                            <div class="flex-1 text-sm text-slate-900">PC <?= htmlspecialchars($problem['pc_number']) ?></div>
                        </div>
                        <?php endif; ?>
                        <div class="flex border-b border-slate-100 pb-3">
                            <div class="w-40 text-sm font-medium text-slate-600">Jenis Masalah</div>
                            <div class="flex-1">
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium <?= $problem['problem_type'] == 'hardware' ? 'bg-red-50 text-red-700' : 'bg-blue-50 text-blue-700' ?>">
                                    <i class="bi bi-<?= $problem['problem_type'] == 'hardware' ? 'cpu' : 'code-slash' ?>"></i>
                                    <?= ucfirst($problem['problem_type']) ?>
                                </span>
                            </div>
                        </div>
                        <div class="flex border-b border-slate-100 pb-3">
                            <div class="w-40 text-sm font-medium text-slate-600">Deskripsi</div>
                            <div class="flex-1 text-sm text-slate-900"><?= nl2br(htmlspecialchars($problem['description'])) ?></div>
                        </div>
                        <div class="flex border-b border-slate-100 pb-3">
                            <div class="w-40 text-sm font-medium text-slate-600">Pelapor</div>
                            <div class="flex-1 text-sm text-slate-900"><?= htmlspecialchars($problem['reporter_name'] ?? '-') ?></div>
                        </div>
                        <div class="flex">
                            <div class="w-40 text-sm font-medium text-slate-600">Tanggal Laporan</div>
                            <div class="flex-1 text-sm text-slate-900"><?= date('d M Y H:i', strtotime($problem['reported_at'])) ?></div>
                        </div>
                    </div>
                </div>

                <!-- Update Status Form -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="bi bi-arrow-repeat text-sky-600"></i>
                        Update Status
                    </h2>
                    <form method="POST" action="<?= url('/koordinator/problems/' . $problem['id'] . '/update-status') ?>" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                            <select name="status" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                                <option value="reported" <?= $problem['status'] == 'reported' ? 'selected' : '' ?>>Pending</option>
                                <option value="in_progress" <?= $problem['status'] == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="resolved" <?= $problem['status'] == 'resolved' ? 'selected' : '' ?>>Resolved</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Catatan</label>
                            <textarea name="note" rows="3" placeholder="Tambahkan catatan untuk update ini..." class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"></textarea>
                        </div>
                        <button type="submit" class="w-full px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg shadow-lg shadow-sky-500/30 transition-all">
                            Update Status
                        </button>
                    </form>
                </div>

                <!-- History -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4 flex items-center gap-2">
                        <i class="bi bi-clock-history text-sky-600"></i>
                        Riwayat Update
                    </h2>
                    <?php if (!empty($histories)): ?>
                        <div class="space-y-3">
                            <?php foreach ($histories as $history): ?>
                                <div class="flex gap-4 p-3 bg-slate-50 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <?php
                                        $statusStyles = [
                                            'reported' => 'bg-amber-100 text-amber-700',
                                            'in_progress' => 'bg-blue-100 text-blue-700',
                                            'resolved' => 'bg-emerald-100 text-emerald-700'
                                        ];
                                        $statusClass = $statusStyles[$history['status']] ?? 'bg-slate-100 text-slate-700';
                                        ?>
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium <?= $statusClass ?>">
                                            <?= ucfirst($history['status']) ?>
                                        </span>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-slate-900"><?= htmlspecialchars($history['note'] ?: 'No note') ?></p>
                                        <p class="text-xs text-slate-500 mt-1">
                                            <?= date('d M Y H:i', strtotime($history['updated_at'])) ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="bi bi-clock-history text-2xl text-slate-300"></i>
                            </div>
                            <p class="text-slate-500 text-sm">Belum ada riwayat update</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-semibold text-slate-600 uppercase mb-3">Status Saat Ini</h3>
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
                    <div class="flex items-center justify-center py-4">
                        <span class="inline-flex items-center gap-2 px-4 py-2 border-2 rounded-lg text-sm font-semibold <?= $statusClass ?>">
                            <i class="bi bi-<?= $statusIcon ?> text-lg"></i>
                            <?= $statusLabel ?>
                        </span>
                    </div>
                </div>

                <!-- Assign Assistant -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-semibold text-slate-600 uppercase mb-3">Penanggung Jawab</h3>
                    
                    <?php if (!empty($problem['assigned_to_name'])): ?>
                        <div class="flex items-center gap-3 mb-4 p-3 bg-sky-50 rounded-lg">
                            <div class="w-10 h-10 bg-sky-600 rounded-full flex items-center justify-center">
                                <span class="text-sm font-bold text-white"><?= strtoupper(substr($problem['assigned_to_name'], 0, 1)) ?></span>
                            </div>
                            <div>
                                <div class="text-sm font-medium text-slate-900"><?= htmlspecialchars($problem['assigned_to_name']) ?></div>
                                <div class="text-xs text-slate-500">Asisten Teknisi</div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="<?= url('/koordinator/problems/' . $problem['id'] . '/assign') ?>" class="space-y-3">
                        <select name="assigned_to" required class="block w-full px-4 py-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500 text-sm">
                            <option value="">Pilih Asisten</option>
                            <?php foreach ($assistants as $asisten): ?>
                                <option value="<?= $asisten['id'] ?>" <?= ($problem['assigned_to'] ?? '') == $asisten['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($asisten['name']) ?> (<?= htmlspecialchars($asisten['email']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="w-full px-4 py-2.5 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg transition-colors text-sm">
                            Tugaskan
                        </button>
                    </form>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-sm font-semibold text-slate-600 uppercase mb-3">Aksi Cepat</h3>
                    <div class="space-y-2">
                        <a href="<?= url('/koordinator/problems/' . $problem['id'] . '/edit') ?>" class="block w-full px-4 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium rounded-lg transition-colors text-sm text-center">
                            <i class="bi bi-pencil"></i> Edit Laporan
                        </a>
                        <button onclick="confirmDelete(<?= $problem['id'] ?>)" class="block w-full px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 font-medium rounded-lg transition-colors text-sm">
                            <i class="bi bi-trash"></i> Hapus Laporan
                        </button>
                    </div>
                </div>

            </div>

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

document.getElementById('deleteModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
