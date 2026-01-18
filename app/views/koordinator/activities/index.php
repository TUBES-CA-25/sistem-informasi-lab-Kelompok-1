<?php $title = 'Kegiatan Lab'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800">Kegiatan Laboratorium</h1>
                    <p class="text-slate-500 mt-1">Kelola kegiatan, workshop, dan seminar lab.</p>
                </div>
                <a href="<?= url('/koordinator/activities/create') ?>" class="px-6 py-3 bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white font-medium rounded-lg shadow-lg shadow-sky-500/30 transition-all">
                    <i class="bi bi-plus-circle mr-2"></i>Tambah Kegiatan
                </a>
            </div>
        </div>

        <?php displayFlash(); ?>

        <!-- Activities Grid -->
        <?php if (empty($activities)): ?>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bi bi-calendar-event text-4xl text-slate-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-slate-700 mb-2">Belum Ada Kegiatan</h3>
                <p class="text-slate-500 mb-6">Mulai tambahkan kegiatan laboratorium Anda.</p>
                <a href="<?= url('/koordinator/activities/create') ?>" class="inline-block px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg transition-colors">
                    Tambah Kegiatan Pertama
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($activities as $activity): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-lg transition-shadow">
                        <!-- Image Cover -->
                        <?php if ($activity['image_cover']): ?>
                            <div class="relative h-48 bg-gradient-to-br from-slate-100 to-slate-200">
                                <img src="<?= url($activity['image_cover']) ?>" alt="<?= htmlspecialchars($activity['title']) ?>" class="w-full h-full object-cover">
                                <!-- Status Badge on Image -->
                                <div class="absolute top-3 right-3">
                                    <?php
                                    $statusColors = [
                                        'draft' => 'bg-slate-500',
                                        'published' => 'bg-green-500',
                                        'cancelled' => 'bg-red-500'
                                    ];
                                    $statusColor = $statusColors[$activity['status']] ?? 'bg-slate-500';
                                    $statusText = ucfirst($activity['status']);
                                    ?>
                                    <span class="<?= $statusColor ?> text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                        <?= $statusText ?>
                                    </span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="relative h-48 bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                                <i class="bi bi-image text-6xl text-slate-300"></i>
                                <!-- Status Badge -->
                                <div class="absolute top-3 right-3">
                                    <?php
                                    $statusColors = [
                                        'draft' => 'bg-slate-500',
                                        'published' => 'bg-green-500',
                                        'cancelled' => 'bg-red-500'
                                    ];
                                    $statusColor = $statusColors[$activity['status']] ?? 'bg-slate-500';
                                    $statusText = ucfirst($activity['status']);
                                    ?>
                                    <span class="<?= $statusColor ?> text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                        <?= $statusText ?>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Content -->
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-slate-800 mb-2 line-clamp-2">
                                <?= htmlspecialchars($activity['title']) ?>
                            </h3>

                            <!-- Meta Info -->
                            <div class="space-y-2 mb-4">
                                <!-- Type Badge -->
                                <div class="flex items-center gap-2">
                                    <?php
                                    $typeColors = [
                                        'praktikum' => 'bg-blue-100 text-blue-700',
                                        'workshop' => 'bg-purple-100 text-purple-700',
                                        'seminar' => 'bg-amber-100 text-amber-700',
                                        'maintenance' => 'bg-orange-100 text-orange-700',
                                        'other' => 'bg-slate-100 text-slate-700'
                                    ];
                                    $typeColor = $typeColors[$activity['activity_type']] ?? 'bg-slate-100 text-slate-700';
                                    ?>
                                    <span class="<?= $typeColor ?> text-xs font-medium px-2.5 py-1 rounded">
                                        <?= ucfirst($activity['activity_type']) ?>
                                    </span>
                                </div>

                                <!-- Date -->
                                <div class="flex items-center text-sm text-slate-600">
                                    <i class="bi bi-calendar3 mr-2"></i>
                                    <?= date('d M Y', strtotime($activity['activity_date'])) ?>
                                </div>

                                <!-- Location -->
                                <?php if ($activity['location']): ?>
                                    <div class="flex items-center text-sm text-slate-600">
                                        <i class="bi bi-geo-alt mr-2"></i>
                                        <?= htmlspecialchars($activity['location']) ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Link -->
                                <?php if ($activity['link_url']): ?>
                                    <div class="flex items-center text-sm">
                                        <i class="bi bi-link-45deg mr-2 text-sky-600"></i>
                                        <a href="<?= htmlspecialchars($activity['link_url']) ?>" target="_blank" class="text-sky-600 hover:text-sky-700 hover:underline truncate">
                                            Link
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Description Preview -->
                            <?php if ($activity['description']): ?>
                                <p class="text-sm text-slate-600 mb-4 line-clamp-2">
                                    <?= htmlspecialchars($activity['description']) ?>
                                </p>
                            <?php endif; ?>

                            <!-- Actions -->
                            <div class="flex gap-2 pt-4 border-t border-slate-100">
                                <a href="<?= url('/koordinator/activities/' . $activity['id'] . '/edit') ?>" class="flex-1 px-4 py-2 bg-sky-50 hover:bg-sky-100 text-sky-700 font-medium rounded-lg transition-colors text-center text-sm">
                                    <i class="bi bi-pencil mr-1"></i> Edit
                                </a>
                                <button onclick="confirmDelete(<?= $activity['id'] ?>, '<?= htmlspecialchars(addslashes($activity['title'])) ?>')" class="flex-1 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 font-medium rounded-lg transition-colors text-sm">
                                    <i class="bi bi-trash mr-1"></i> Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-2xl text-red-600"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-slate-800">Hapus Kegiatan</h3>
                <p class="text-sm text-slate-600">Tindakan ini tidak dapat dibatalkan</p>
            </div>
        </div>
        
        <p class="text-slate-700 mb-6">
            Yakin ingin menghapus kegiatan <strong id="activityTitle"></strong>?
        </p>
        
        <form id="deleteForm" method="POST" class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors">
                Batal
            </button>
            <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

<script>
function confirmDelete(id, title) {
    document.getElementById('activityTitle').textContent = title;
    document.getElementById('deleteForm').action = '<?= url('/koordinator/activities/') ?>' + id + '/delete';
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close modal on outside click
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
