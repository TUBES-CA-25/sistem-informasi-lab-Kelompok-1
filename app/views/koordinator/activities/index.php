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
                                <?php 
                                // Jika path dimulai dengan http/https, gunakan langsung (URL eksternal)
                                // Jika path dimulai dengan /, gunakan BASE_URL (relative path)
                                $imageSrc = (strpos($activity['image_cover'], 'http') === 0) 
                                    ? $activity['image_cover'] 
                                    : BASE_URL . $activity['image_cover'];
                                ?>
                                <img src="<?= $imageSrc ?>" alt="<?= htmlspecialchars($activity['title']) ?>" class="w-full h-full object-cover">
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
                                <a href="<?= url('/koordinator/activities/' . $activity['id'] . '/edit') ?>" 
                                   class="flex-1 px-4 py-2 bg-amber-50 hover:bg-amber-100 text-amber-700 font-medium rounded-lg transition-colors text-center text-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <button type="button" 
                                        class="btn-delete flex-1 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 font-medium rounded-lg transition-colors text-sm"
                                        data-activity-id="<?= $activity['id'] ?>"
                                        data-title="<?= htmlspecialchars($activity['title']) ?>">
                                    <i class="bi bi-trash"></i> Hapus
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
<div id="deleteModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 animate-scale">
        <div class="flex items-start gap-4 mb-6">
            <div class="flex-shrink-0 w-14 h-14 bg-red-100 rounded-full flex items-center justify-center">
                <i class="bi bi-exclamation-triangle text-3xl text-red-600"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-slate-900 mb-2">Hapus Kegiatan?</h3>
                <p class="text-slate-600 text-sm leading-relaxed" id="deleteMessage">
                    Apakah Anda yakin ingin menghapus kegiatan ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="button" onclick="closeDeleteModal()" class="flex-1 px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl font-semibold transition-all duration-200">
                Batal
            </button>
            <form id="deleteForm" method="POST" class="flex-1">
                <button type="submit" class="w-full px-5 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-all duration-200 shadow-lg shadow-red-500/30">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<style>
@keyframes scaleIn {
    from { transform: scale(0.9); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
.animate-scale {
    animation: scaleIn 0.2s ease-out;
}
#deleteModal:not(.hidden) {
    display: flex !important;
}
</style>

<script>
console.log('🔧 Delete Activity script loaded - Version 1.0');

// Close modal function
function closeDeleteModal() {
    console.log('🚪 Closing modal...');
    const modal = document.getElementById('deleteModal');
    if (modal) {
        modal.classList.add('hidden');
        console.log('✅ Modal closed');
    }
}

// Setup event listeners when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('📱 DOM Content Loaded - Activities Delete');
    
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const message = document.getElementById('deleteMessage');
    
    // Verify modal elements exist
    console.log('📋 Modal elements check:');
    console.log('   - Modal:', modal ? '✅ Found' : '❌ Not found');
    console.log('   - Form:', form ? '✅ Found' : '❌ Not found');
    console.log('   - Message:', message ? '✅ Found' : '❌ Not found');
    
    if (!modal || !form || !message) {
        console.error('❌ ERROR: Modal elements missing!');
        return;
    }
    
    // Add click listener to all delete buttons using event delegation
    document.body.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.btn-delete');
        if (deleteBtn) {
            e.preventDefault();
            
            const activityId = deleteBtn.dataset.activityId;
            const title = deleteBtn.dataset.title;
            
            console.log('🗑️ Delete button clicked');
            console.log('   - Activity ID:', activityId);
            console.log('   - Title:', title);
            
            const deleteUrl = '<?= url('/koordinator/activities/') ?>' + activityId + '/delete';
            console.log('🔗 Delete URL:', deleteUrl);
            
            form.action = deleteUrl;
            message.textContent = `Apakah Anda yakin ingin menghapus kegiatan "${title}"? Tindakan ini tidak dapat dibatalkan.`;
            
            console.log('✅ Opening modal...');
            modal.classList.remove('hidden');
        }
    });
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === this) {
            console.log('🖱️ Clicked outside modal, closing...');
            closeDeleteModal();
        }
    });
    
    console.log('✅ All event listeners attached successfully');
});
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
