<?php $title = 'Permasalahan Lab'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        <div id="flash-data" class="hidden">
            <?php displayFlash(); ?>
        </div>

        <div class="flex flex-wrap gap-2 mb-6">
            <?php $currentStatus = $filters['status'] ?? 'active'; ?>
            <a href="<?= url('/asisten/problems?status=active') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $currentStatus == 'active' ? 'bg-sky-600 text-white shadow-lg' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">Aktif</a>
            <a href="<?= url('/asisten/problems?status=all') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $currentStatus == 'all' ? 'bg-slate-600 text-white shadow-lg' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">Semua</a>
            <a href="<?= url('/asisten/problems?status=reported') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $currentStatus == 'reported' ? 'bg-amber-500 text-white shadow-lg' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">Pending</a>
            <a href="<?= url('/asisten/problems?status=in_progress') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $currentStatus == 'in_progress' ? 'bg-blue-500 text-white shadow-lg' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">Diproses</a>
            <a href="<?= url('/asisten/problems?status=resolved') ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-all <?= $currentStatus == 'resolved' ? 'bg-emerald-500 text-white shadow-lg' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' ?>">Selesai</a>
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
                <button type="submit" class="px-6 py-2.5 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium transition-colors">Cari</button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <?php if (empty($problems)): ?>
                <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 animate-blob">
                        <i class="bi bi-clipboard-check text-4xl text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 mb-1">Tidak ada masalah ditemukan</h3>
                    <p class="text-slate-500 text-sm">Belum ada laporan permasalahan yang sesuai.</p>
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
                                        $s = [
                                            'reported' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'label' => 'Pending'],
                                            'in_progress' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'label' => 'Diproses'],
                                            'resolved' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'label' => 'Selesai']
                                        ][$problem['status']] ?? ['bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'label' => 'Unknown'];
                                        ?>
                                        <span class="inline-flex items-center px-2.5 py-1 border rounded-full text-xs font-medium <?= $s['bg'] . ' ' . $s['text'] . ' ' . $s['border'] ?>">
                                            <?= $s['label'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="<?= url('/asisten/problems/' . $problem['id']) ?>" 
                                               class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center hover:bg-sky-100 transition-colors border border-sky-200" 
                                               title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <?php if ($problem['reported_by'] == getUserId()): ?>
                                                <button onclick="confirmDelete(<?= $problem['id'] ?>)" 
                                                        class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-100 transition-colors border border-rose-200" 
                                                        title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
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

<div id="deleteModal" class="hidden fixed inset-0 bg-slate-900/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-slate-900 mb-2">Hapus Laporan?</h3>
        <p class="text-slate-600 text-sm mb-6">Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-slate-100 text-slate-700 rounded-lg">Batal</button>
            <form id="deleteForm" method="POST" class="flex-1">
                <button type="submit" class="w-full px-4 py-2 bg-rose-600 text-white rounded-lg">Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    
    // PERBAIKAN: URL sekarang mengikuti format Admin: /asisten/problems/{id}/delete
    form.action = '<?= url('/asisten/problems/') ?>' + id + '/delete';
    
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Tutup modal jika klik di luar area
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// SweetAlert Logic
document.addEventListener('DOMContentLoaded', function() {
    const flashElement = document.getElementById('flash-data');
    if (flashElement && flashElement.innerText.trim() !== '') {
        const text = flashElement.innerText.trim();
        const icon = text.toLowerCase().includes('berhasil') ? 'success' : 'error';
        const title = icon === 'success' ? 'Berhasil!' : 'Gagal!';
        
        Swal.fire({ 
            title: title, 
            text: text, 
            icon: icon, 
            confirmButtonText: 'Oke',
            confirmButtonColor: '#0ea5e9', 
            timer: 3000 
        });
    }
});
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>