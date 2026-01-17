<?php $title = 'Laboratorium'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Laboratorium</h1>
                <p class="text-slate-500 mt-1">Kelola data laboratorium kampus.</p>
            </div>

            <a href="<?= url('/koordinator/laboratories/create') ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg shadow-lg shadow-sky-500/30 transition-all">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Laboratorium</span>
            </a>
        </div>

        <?php displayFlash(); ?>

        <?php if (empty($laboratories)): ?>
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-building text-4xl text-slate-300"></i>
                </div>
                <h3 class="text-lg font-medium text-slate-900 mb-2">Belum ada data laboratorium</h3>
                <p class="text-slate-500 mb-6">Mulai dengan menambahkan laboratorium pertama Anda.</p>
                <a href="<?= url('/koordinator/laboratories/create') ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg transition-colors">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Laboratorium
                </a>
            </div>
        <?php else: ?>
            <!-- Grid Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($laboratories as $lab): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg transition-shadow group">
                        
                        <!-- Header -->
                        <div class="bg-gradient-to-br from-sky-500 to-sky-600 p-6 text-white relative">
                            <div class="absolute top-4 right-4">
                                <?php
                                $statusColors = [
                                    'active' => 'bg-emerald-500',
                                    'maintenance' => 'bg-amber-500',
                                    'inactive' => 'bg-red-500'
                                ];
                                $statusLabels = [
                                    'active' => 'Aktif',
                                    'maintenance' => 'Maintenance',
                                    'inactive' => 'Tidak Aktif'
                                ];
                                $status = $lab['status'] ?? 'active';
                                $statusColor = $statusColors[$status] ?? 'bg-slate-500';
                                $statusLabel = $statusLabels[$status] ?? ucfirst($status);
                                ?>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold <?= $statusColor ?> text-white">
                                    <i class="bi bi-circle-fill text-[8px]"></i>
                                    <?= $statusLabel ?>
                                </span>
                            </div>
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                                    <i class="bi bi-laptop text-2xl text-white"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold"><?= htmlspecialchars($lab['lab_name']) ?></h3>
                                </div>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 space-y-4">
                            
                            <!-- Description -->
                            <?php if (!empty($lab['description'])): ?>
                                <p class="text-sm text-slate-600 line-clamp-2">
                                    <?= htmlspecialchars($lab['description']) ?>
                                </p>
                            <?php endif; ?>

                            <!-- Stats -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-sky-50 rounded-lg p-3">
                                    <div class="flex items-center gap-2 mb-1">
                                        <i class="bi bi-pc-display text-sky-600"></i>
                                        <span class="text-xs font-medium text-slate-600">PC</span>
                                    </div>
                                    <div class="text-2xl font-bold text-slate-900"><?= $lab['pc_count'] ?? 0 ?></div>
                                </div>
                                <div class="bg-emerald-50 rounded-lg p-3">
                                    <div class="flex items-center gap-2 mb-1">
                                        <i class="bi bi-people text-emerald-600"></i>
                                        <span class="text-xs font-medium text-slate-600">Kapasitas</span>
                                    </div>
                                    <div class="text-2xl font-bold text-slate-900"><?= $lab['capacity'] ?? 0 ?></div>
                                </div>
                            </div>

                            <!-- Location Info -->
                            <div class="space-y-2 pt-3 border-t border-slate-100">
                                <div class="flex items-start gap-2 text-sm">
                                    <i class="bi bi-geo-alt text-slate-400 mt-0.5"></i>
                                    <div class="flex-1">
                                        <div class="font-medium text-slate-900"><?= htmlspecialchars($lab['location'] ?? 'Lokasi belum diset') ?></div>
                                        <?php if (!empty($lab['building']) || !empty($lab['floor']) || !empty($lab['room_number'])): ?>
                                            <div class="text-xs text-slate-500 mt-0.5">
                                                <?php
                                                $locationParts = [];
                                                if (!empty($lab['building'])) $locationParts[] = $lab['building'];
                                                if (!empty($lab['floor'])) $locationParts[] = 'Lt. ' . $lab['floor'];
                                                if (!empty($lab['room_number'])) $locationParts[] = 'Ruang ' . $lab['room_number'];
                                                echo htmlspecialchars(implode(' · ', $locationParts));
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="px-6 pb-6 flex gap-2">
                            <a href="<?= url('/koordinator/laboratories/' . $lab['id'] . '/edit') ?>" class="flex-1 px-4 py-2.5 bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium rounded-lg transition-colors text-center text-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <button onclick="confirmDelete(<?= $lab['id'] ?>, '<?= htmlspecialchars($lab['lab_name']) ?>')" class="flex-1 px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 font-medium rounded-lg transition-colors text-sm">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

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
                <h3 class="text-lg font-semibold text-slate-900 mb-2">Hapus Laboratorium?</h3>
                <p class="text-slate-600 text-sm" id="deleteMessage">
                    Apakah Anda yakin ingin menghapus laboratorium ini?
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
function confirmDelete(labId, labName) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const message = document.getElementById('deleteMessage');
    
    form.action = '<?= url('/koordinator/laboratories/') ?>' + labId + '/delete';
    message.textContent = `Apakah Anda yakin ingin menghapus "${labName}"? Tindakan ini tidak dapat dibatalkan.`;
    
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
