<?php $title = 'Edit Kegiatan'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">

            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/activities') ?>" 
                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                   title="Kembali">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Kegiatan</h1>
                    <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                        <span>Manajemen Kegiatan</span>
                        <i class="bi bi-chevron-right text-xs"></i>
                        <span class="text-primary-600 font-medium">Edit #<?= $activity['id'] ?></span>
                    </div>
                </div>
            </div>

            <?php displayFlash(); ?>

            <form method="POST" action="<?= url('/admin/activities/' . $activity['id'] . '/edit') ?>" enctype="multipart/form-data">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-800 mb-5 pb-4 border-b border-slate-100">
                                <i class="bi bi-pencil-square mr-2 text-primary-600"></i>Informasi Utama
                            </h2>

                            <div class="mb-5">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Judul Kegiatan <span class="text-rose-500">*</span></label>
                                <input type="text" name="title" value="<?= e($activity['title']) ?>" 
                                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" 
                                       placeholder="Masukkan judul kegiatan yang menarik..." required>
                            </div>

                            <div class="mb-5">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Link Eksternal (Berita/Blog) <span class="text-rose-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-slate-400">
                                        <i class="bi bi-link-45deg text-xl"></i>
                                    </div>
                                    <input type="url" name="link_url" value="<?= e($activity['link_url']) ?>" 
                                           class="w-full ps-11 p-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all font-mono text-xs sm:text-sm" 
                                           placeholder="https://..." required>
                                </div>
                                <p class="mt-2 text-xs text-slate-500">Pastikan link diawali dengan http:// atau https://</p>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Deskripsi Singkat</label>
                                <textarea name="description" rows="4" 
                                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all resize-none"
                                          placeholder="Tuliskan ringkasan singkat tentang kegiatan ini..."><?= e($activity['description']) ?></textarea>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <h2 class="text-lg font-semibold text-slate-800 mb-5 pb-4 border-b border-slate-100">
                                <i class="bi bi-calendar-event mr-2 text-primary-600"></i>Detail Waktu & Kategori
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Kategori</label>
                                    <div class="relative">
                                        <select name="activity_type" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none transition-all cursor-pointer">
                                            <option value="general" <?= $activity['activity_type'] == 'general' ? 'selected' : '' ?>>📢 Umum / Berita</option>
                                            <option value="praktikum" <?= $activity['activity_type'] == 'praktikum' ? 'selected' : '' ?>>🔬 Praktikum</option>
                                            <option value="seminar" <?= $activity['activity_type'] == 'seminar' ? 'selected' : '' ?>>🎓 Seminar / Workshop</option>
                                            <option value="lomba" <?= $activity['activity_type'] == 'lomba' ? 'selected' : '' ?>>🏆 Lomba / Kompetisi</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                            <i class="bi bi-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Tanggal Posting</label>
                                    <input type="date" name="activity_date" value="<?= e($activity['activity_date']) ?>" 
                                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" required>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="lg:col-span-1 space-y-6">
                        
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Media Gambar</h2>
                            
                            <div class="mb-4">
                                <label class="block mb-2 text-xs font-medium text-slate-500">Cover Saat Ini</label>
                                <?php if (!empty($activity['image_cover'])): ?>
                                    <div class="relative aspect-video rounded-xl overflow-hidden border border-slate-200 group shadow-sm">
                                        <img src="<?= e($activity['image_cover']) ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <p class="text-white text-xs font-mono truncate"><?= basename($activity['image_cover']) ?></p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="aspect-video rounded-xl bg-slate-100 border-2 border-dashed border-slate-300 flex flex-col items-center justify-center text-slate-400">
                                        <i class="bi bi-image-alt text-3xl mb-2"></i>
                                        <span class="text-xs">Tidak ada gambar</span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div>
                                <label class="block mb-2 text-xs font-medium text-slate-500">Ganti Gambar (Opsional)</label>
                                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-primary-100 border-dashed rounded-xl cursor-pointer bg-primary-50/30 hover:bg-primary-50 hover:border-primary-300 transition-all group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="bi bi-cloud-arrow-up text-2xl text-primary-400 group-hover:text-primary-600 mb-2 transition-colors"></i>
                                        <p class="mb-1 text-xs text-slate-500"><span class="font-semibold text-primary-600">Klik upload</span> atau drag</p>
                                        <p class="text-[10px] text-slate-400">SVG, PNG, JPG (MAX. 2MB)</p>
                                    </div>
                                    <input name="image_cover_file" type="file" class="hidden" accept="image/*" onchange="previewImage(this)" />
                                </label>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 sticky top-4">
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Aksi</h2>
                            <div class="flex flex-col gap-3">
                                <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-semibold rounded-xl text-sm px-5 py-3 transition-all shadow-lg shadow-primary-500/30 flex justify-center items-center gap-2">
                                    <i class="bi bi-check-lg"></i>
                                    Simpan Perubahan
                                </button>
                                
                                <a href="<?= url('/admin/activities') ?>" class="w-full text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 focus:ring-4 focus:ring-slate-100 font-medium rounded-xl text-sm px-5 py-3 text-center transition-all">
                                    Batal
                                </a>
                            </div>
                            <p class="text-xs text-slate-400 text-center mt-4">
                                Terakhir diupdate: <br>
                                <span class="font-mono text-slate-500"><?= date('d M Y, H:i') ?></span>
                            </p>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
function previewImage(input) {
    // Fitur tambahan: Bisa ditambahkan JS sederhana untuk preview gambar sebelum upload
    // Untuk saat ini dibiarkan standar sesuai request PHP Native
    if (input.files && input.files[0]) {
        // Logic preview bisa diletakkan di sini jika diinginkan
    }
}
</script>