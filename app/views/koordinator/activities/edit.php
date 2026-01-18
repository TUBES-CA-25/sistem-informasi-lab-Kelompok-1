<?php $title = 'Edit Kegiatan'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="<?= url('/koordinator/activities') ?>" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="bi bi-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold text-slate-800">Edit Kegiatan</h1>
            </div>
            <p class="text-slate-500">Update informasi kegiatan laboratorium.</p>
        </div>

        <?php displayFlash(); ?>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <form method="POST" action="<?= url('/koordinator/activities/' . $activity['id'] . '/edit') ?>" enctype="multipart/form-data" class="space-y-6">

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 mb-2">
                        Judul Kegiatan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($activity['title']) ?>" required class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>

                <!-- Current Image Display & Upload -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Gambar Cover
                    </label>
                    
                    <!-- Current Image -->
                    <?php if ($activity['image_cover']): ?>
                        <div id="currentImage" class="mb-4">
                            <div class="relative inline-block">
                                <img src="<?= url($activity['image_cover']) ?>" alt="Current" class="w-full max-w-md h-64 object-cover rounded-lg border-2 border-slate-200">
                                <div class="mt-2 text-sm text-slate-600">
                                    <i class="bi bi-info-circle"></i> Gambar saat ini
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- New Image Preview -->
                    <div id="imagePreview" class="hidden mb-4">
                        <div class="relative inline-block">
                            <img id="previewImg" src="" alt="Preview" class="w-full max-w-md h-64 object-cover rounded-lg border-2 border-sky-200">
                            <button type="button" onclick="removeNewImage()" class="absolute top-2 right-2 p-2 bg-red-600 hover:bg-red-700 text-white rounded-full shadow-lg transition-colors">
                                <i class="bi bi-x-lg"></i>
                            </button>
                            <div class="mt-2 text-sm text-sky-600 font-medium">
                                <i class="bi bi-check-circle"></i> Gambar baru (akan mengganti gambar lama)
                            </div>
                        </div>
                    </div>

                    <!-- Upload Button -->
                    <label for="image_cover" class="inline-block cursor-pointer">
                        <div class="px-4 py-2 bg-sky-50 hover:bg-sky-100 text-sky-700 font-medium rounded-lg border border-sky-200 transition-colors">
                            <i class="bi bi-cloud-upload mr-2"></i>
                            <?= $activity['image_cover'] ? 'Ganti Gambar' : 'Upload Gambar' ?>
                        </div>
                    </label>
                    <input type="file" id="image_cover" name="image_cover" accept="image/*" class="hidden" onchange="previewImage(event)">
                    <p class="text-xs text-slate-500 mt-2">JPG, PNG, GIF (Max 5MB)</p>
                </div>

                <!-- Type and Date Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="activity_type" class="block text-sm font-medium text-slate-700 mb-2">
                            Tipe Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <select id="activity_type" name="activity_type" required class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            <option value="praktikum" <?= $activity['activity_type'] == 'praktikum' ? 'selected' : '' ?>>Praktikum</option>
                            <option value="workshop" <?= $activity['activity_type'] == 'workshop' ? 'selected' : '' ?>>Workshop</option>
                            <option value="seminar" <?= $activity['activity_type'] == 'seminar' ? 'selected' : '' ?>>Seminar</option>
                            <option value="maintenance" <?= $activity['activity_type'] == 'maintenance' ? 'selected' : '' ?>>Maintenance</option>
                            <option value="other" <?= $activity['activity_type'] == 'other' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label for="activity_date" class="block text-sm font-medium text-slate-700 mb-2">
                            Tanggal Kegiatan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="activity_date" name="activity_date" value="<?= htmlspecialchars($activity['activity_date']) ?>" required class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-slate-700 mb-2">
                        Lokasi
                    </label>
                    <input type="text" id="location" name="location" value="<?= htmlspecialchars($activity['location'] ?? '') ?>" placeholder="Contoh: Lab 1, Gedung A Lantai 2" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description" name="description" rows="4" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"><?= htmlspecialchars($activity['description'] ?? '') ?></textarea>
                </div>

                <!-- Link URL -->
                <div>
                    <label for="link_url" class="block text-sm font-medium text-slate-700 mb-2">
                        Link URL
                    </label>
                    <input type="url" id="link_url" name="link_url" value="<?= htmlspecialchars($activity['link_url'] ?? '') ?>" placeholder="https://example.com" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                        Status
                    </label>
                    <select id="status" name="status" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        <option value="draft" <?= $activity['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="published" <?= $activity['status'] == 'published' ? 'selected' : '' ?>>Published</option>
                        <option value="cancelled" <?= $activity['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    <a href="<?= url('/koordinator/activities') ?>" class="flex-1 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg shadow-lg shadow-sky-500/30 transition-all">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function removeNewImage() {
    document.getElementById('image_cover').value = '';
    document.getElementById('imagePreview').classList.add('hidden');
}
</script>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
