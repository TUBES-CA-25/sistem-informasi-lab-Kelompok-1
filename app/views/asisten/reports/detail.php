<?php $title = 'Detail Permasalahan'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div class="flex items-center gap-4">
                <a href="<?= url('/asisten/problems') ?>" class="w-10 h-10 bg-white border border-slate-200 rounded-xl flex items-center justify-center text-slate-500 hover:text-slate-800 hover:shadow-sm transition-all">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <div class="flex items-center gap-2 text-xs text-slate-500 font-medium mb-1">
                        <span>Reports</span>
                        <i class="bi bi-chevron-right text-[10px]"></i>
                        <span>#<?= $problem['id'] ?></span>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900">Detail Masalah</h1>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <?php if ($problem['reported_by'] == getUserId() && $problem['status'] != 'resolved'): ?>
                    <a href="<?= url('/asisten/problems/' . $problem['id'] . '/edit') ?>" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 rounded-lg text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors shadow-sm">
                        <i class="bi bi-pencil-square text-sky-600"></i>
                        Edit Data
                    </a>
                <?php endif; ?>

                <?php
                $statusConfig = [
                    'reported' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'icon' => 'bi-exclamation-circle-fill', 'label' => 'Pending'],
                    'in_progress' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'icon' => 'bi-arrow-repeat', 'label' => 'Diproses'],
                    'resolved' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'icon' => 'bi-check-circle-fill', 'label' => 'Selesai']
                ];
                $s = $statusConfig[$problem['status']] ?? $statusConfig['reported'];
                ?>
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-bold <?= $s['bg'] ?> <?= $s['text'] ?>">
                    <i class="bi <?= $s['icon'] ?>"></i>
                    <?= $s['label'] ?>
                </div>
            </div>
        </div>

        <div id="flash-data" class="hidden">
            <?php displayFlash(); ?>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 overflow-hidden">
                    <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 border-b border-slate-100 pb-4">
                        <i class="bi bi-info-circle text-sky-600"></i> Informasi Detil
                    </h2>
                    
                    <div class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="text-sm font-medium text-slate-500">Laboratorium</div>
                            <div class="sm:col-span-2 text-sm font-semibold text-slate-900"><?= e($problem['lab_name']) ?></div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="text-sm font-medium text-slate-500">PC Number</div>
                            <div class="sm:col-span-2 text-sm font-semibold text-slate-900">
                                <?= $problem['pc_number'] ? 'PC ' . e($problem['pc_number']) : '-' ?>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="text-sm font-medium text-slate-500">Jenis Masalah</div>
                            <div class="sm:col-span-2">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                    <i class="bi bi-code-slash"></i>
                                    <?= ucfirst($problem['problem_type']) ?>
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="text-sm font-medium text-slate-500">Deskripsi</div>
                            <div class="sm:col-span-2 text-sm text-slate-800 leading-relaxed bg-slate-50 p-3 rounded-lg border border-slate-100">
                                <?= nl2br(e($problem['description'])) ?>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="text-sm font-medium text-slate-500">Pelapor</div>
                            <div class="sm:col-span-2 flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-[10px] font-bold text-slate-600">
                                    <?= strtoupper(substr($problem['reporter_name'], 0, 1)) ?>
                                </div>
                                <span class="text-sm font-semibold text-slate-900"><?= e($problem['reporter_name']) ?></span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="text-sm font-medium text-slate-500">Waktu Laporan</div>
                            <div class="sm:col-span-2 text-sm text-slate-600">
                                <?= date('d M Y, H:i', strtotime($problem['reported_at'])) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2 border-b border-slate-100 pb-4">
                        <i class="bi bi-clock-history text-sky-600"></i> Riwayat Pengerjaan
                    </h2>

                    <?php if (!empty($histories)): ?>
                        <div class="relative border-l-2 border-slate-200 ml-3 space-y-8 pb-2">
                            <?php foreach ($histories as $history): ?>
                                <div class="relative pl-8">
                                    <div class="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-white border-4 border-sky-200"></div>
                                    
                                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-1 mb-1">
                                        <span class="text-sm font-bold text-slate-800">
                                            Status: <?= ucfirst(str_replace('_', ' ', $history['status'])) ?>
                                        </span>
                                        <span class="text-xs text-slate-400 font-mono">
                                            <?= date('d M Y H:i', strtotime($history['updated_at'])) ?>
                                        </span>
                                    </div>
                                    <p class="text-sm text-slate-600 bg-slate-50 p-3 rounded-lg border border-slate-100">
                                        <?= e($history['note'] ?: 'Tidak ada catatan tambahan.') ?>
                                    </p>
                                    <div class="mt-2 text-xs text-slate-400 flex items-center gap-1">
                                        <i class="bi bi-person-circle"></i>
                                        <?= e($history['updater_name'] ?? 'System') ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <i class="bi bi-hourglass-split text-slate-300 text-3xl mb-2 block"></i>
                            <p class="text-slate-500 text-sm">Belum ada riwayat aktivitas.</p>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <div class="space-y-6">
                
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Penanggung Jawab</h3>
                    
                    <?php if (!empty($problem['assigned_to_name'])): ?>
                        <div class="flex items-center gap-3 p-3 bg-sky-50 rounded-xl border border-sky-100">
                            <div class="w-10 h-10 bg-sky-600 rounded-full flex items-center justify-center shadow-sm text-white font-bold text-lg">
                                <?= strtoupper(substr($problem['assigned_to_name'], 0, 1)) ?>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-slate-900"><?= e($problem['assigned_to_name']) ?></div>
                                <div class="text-xs text-sky-700 font-medium">Asisten Laboratorium</div>
                            </div>
                        </div>
                        
                        <?php if ($problem['assigned_to'] == getUserId()): ?>
                            <div class="mt-3 text-xs text-center text-slate-500 bg-slate-50 p-3 rounded-lg border border-slate-100">
                                <i class="bi bi-info-circle mr-1 text-sky-500"></i> 
                                Anda ditugaskan menangani ini. Silakan update progress melalui menu <a href="<?= url('/asisten/jobdesk') ?>" class="text-sky-600 font-bold hover:underline">Jobdesk</a>.
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="text-center py-6 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                            <i class="bi bi-person-x text-slate-300 text-2xl mb-1 block"></i>
                            <p class="text-sm text-slate-500 italic">Belum ada teknisi yang ditugaskan.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($problem['reported_by'] == getUserId()): ?>
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Kelola Laporan</h3>
                    
                    <div class="space-y-3">
                        <?php if ($problem['status'] != 'resolved'): ?>
                            <a href="<?= url('/asisten/problems/' . $problem['id'] . '/edit') ?>" 
                               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold rounded-lg transition-colors text-sm shadow-sm">
                                <i class="bi bi-pencil-square text-sky-600"></i> Edit Data Laporan
                            </a>
                        <?php endif; ?>

                        <button onclick="confirmDelete(<?= $problem['id'] ?>)" 
                                class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-rose-50 hover:bg-rose-100 border border-rose-100 text-rose-700 font-semibold rounded-lg transition-colors text-sm">
                            <i class="bi bi-trash"></i> Hapus Laporan
                        </button>
                    </div>
                </div>
                <?php endif; ?>

            </div>

        </div>

    </div>
</div>

<div id="deleteModal" class="hidden fixed inset-0 bg-slate-900/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-rose-100 rounded-full flex items-center justify-center text-rose-600">
                <i class="bi bi-exclamation-triangle-fill text-2xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Hapus Laporan?</h3>
                <p class="text-slate-600 text-sm">Tindakan ini permanen dan tidak dapat dibatalkan.</p>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-slate-100 text-slate-700 font-medium rounded-lg hover:bg-slate-200 transition-colors">Batal</button>
            <form id="deleteForm" method="POST" class="flex-1">
                <button type="submit" class="w-full px-4 py-2 bg-rose-600 text-white font-medium rounded-lg hover:bg-rose-700 transition-colors shadow-lg shadow-rose-500/30">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
// Fungsi Modal Hapus
function confirmDelete(id) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    
    // PERBAIKAN: URL disamakan dengan format Admin
    // Format: /asisten/problems/{id}/delete
    form.action = '<?= url('/asisten/problems/') ?>' + id + '/delete';
    
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Tutup modal jika klik luar
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
});

// SweetAlert Notifikasi
document.addEventListener('DOMContentLoaded', function() {
    const flashElement = document.getElementById('flash-data');
    
    if (flashElement && flashElement.innerText.trim() !== '') {
        const text = flashElement.innerText.trim();
        let icon = 'info';
        let title = 'Informasi';

        if (flashElement.innerHTML.includes('danger') || text.toLowerCase().includes('gagal')) {
            icon = 'error';
            title = 'Gagal!';
        } else if (flashElement.innerHTML.includes('success')) {
            icon = 'success';
            title = 'Berhasil!';
        }

        Swal.fire({
            title: title,
            text: text,
            icon: icon,
            confirmButtonText: 'Oke',
            confirmButtonColor: '#0ea5e9',
            timer: 3000,
            timerProgressBar: true
        });
    }
});
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>