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
                                <img src="<?= BASE_URL . $activity['image_cover'] ?>" alt="<?= htmlspecialchars($activity['title']) ?>" class="w-full h-full object-cover">
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
                                <?php if (isset($activity['link_url']) && !empty($activity['link_url'])): ?>
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
                                <button type="button" 
                                        onclick="confirmDelete('<?= url('/koordinator/activities/' . $activity['id'] . '/delete') ?>', '<?= htmlspecialchars($activity['title'], ENT_QUOTES) ?>')" 
                                        class="flex-1 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 font-medium rounded-lg transition-colors text-sm">
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
<div id="deleteModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="bi bi-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                        <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Hapus Kegiatan</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Apakah Anda yakin ingin menghapus kegiatan <strong id="activityTitle" class="text-gray-800"></strong>? 
                                <br>Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <form id="deleteForm" method="POST" action="">
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                    <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto">
                        Ya, Hapus
                    </button>
                    <button type="button" onclick="closeDeleteModal()" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function confirmDelete(url, title) {
    document.getElementById('activityTitle').textContent = title;
    document.getElementById('deleteForm').action = url;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

window.onclick = function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target.classList.contains('bg-opacity-75')) {
        closeDeleteModal();
    }
}
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
