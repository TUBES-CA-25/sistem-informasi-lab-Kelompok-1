<?php $title = 'Edit Kegiatan'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-10">
        <div class="max-w-3xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-slate-800">Edit Kegiatan</h1>
                <a href="<?= url('/admin/activities') ?>" class="text-sm text-slate-500 hover:text-sky-600">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <?php displayFlash(); ?>

            <form method="POST" action="<?= url('/admin/activities/' . $activity['id'] . '/edit') ?>" enctype="multipart/form-data">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">

                    <?php if (!empty($activity['image_cover'])): ?>
                        <div class="mb-6 relative h-48 rounded-lg overflow-hidden group">
                            <img src="<?= e($activity['image_cover']) ?>" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-opacity">
                                <span class="text-sm">Cover Saat Ini</span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Judul Kegiatan *</label>
                        <input type="text" name="title" value="<?= e($activity['title']) ?>" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Link Berita / Blog (URL) *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-slate-500">
                                <i class="bi bi-link-45deg text-lg"></i>
                            </div>
                            <input type="url" name="link_url" value="<?= e($activity['link_url']) ?>" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full ps-10 p-2.5" placeholder="https://..." required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Kategori</label>
                            <select name="activity_type" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5">
                                <option value="general" <?= $activity['activity_type'] == 'general' ? 'selected' : '' ?>>Umum / Berita</option>
                                <option value="praktikum" <?= $activity['activity_type'] == 'praktikum' ? 'selected' : '' ?>>Praktikum</option>
                                <option value="seminar" <?= $activity['activity_type'] == 'seminar' ? 'selected' : '' ?>>Seminar / Workshop</option>
                                <option value="lomba" <?= $activity['activity_type'] == 'lomba' ? 'selected' : '' ?>>Lomba / Kompetisi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Tanggal Kegiatan</label>
                            <input type="date" name="activity_date" value="<?= e($activity['activity_date']) ?>" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Deskripsi Singkat</label>
                        <textarea name="description" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5"><?= e($activity['description']) ?></textarea>
                    </div>

                    <div class="mb-6 p-4 bg-sky-50 rounded-lg border border-sky-100">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Ganti Cover Image</label>
                        <input class="block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white" name="image_cover_file" type="file" accept="image/*">
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="text-white bg-amber-500 hover:bg-amber-600 font-medium rounded-lg text-sm px-5 py-2.5">Simpan Perubahan</button>
                        <a href="<?= url('/admin/activities') ?>" class="text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
                    </div>
                </div>
            </form>
        </div>
        <?php include APP_PATH . '/views/layouts/footer.php'; ?>
    </main>
</div>