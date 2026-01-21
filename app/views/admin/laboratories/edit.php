<?php $title = 'Edit Laboratory';
$adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/laboratories') ?>"
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Laboratory</h1>
                    <p class="text-slate-500 text-sm mt-1">Update laboratory facilities information.</p>
                </div>
            </div>

            <?php displayFlash(); ?>

            <form method="POST" action="<?= url('/admin/laboratories/' . $laboratory['id'] . '/edit') ?>"
                enctype="multipart/form-data">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                            <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                                <i class="bi bi-info-circle text-primary-600"></i> Informasi Umum
                            </h2>

                            <div class="space-y-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Nama Laboratorium
                                        <span class="text-rose-500">*</span></label>
                                    <input type="text" name="lab_name" value="<?= e($laboratory['lab_name']) ?>"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block"
                                        required>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Lokasi <span
                                            class="text-rose-500">*</span></label>
                                    <input type="text" name="location" value="<?= e($laboratory['location']) ?>"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block"
                                        required>
                                </div>

                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <label class="block mb-2 text-sm font-semibold text-slate-700">Jumlah PC</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-slate-400">
                                                <i class="bi bi-pc-display"></i>
                                            </div>
                                            <input type="number" name="pc_count"
                                                value="<?= e($laboratory['pc_count']) ?>"
                                                class="w-full ps-11 p-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block mb-2 text-sm font-semibold text-slate-700">Jumlah TV</label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none text-slate-400">
                                                <i class="bi bi-tv"></i>
                                            </div>
                                            <input type="number" name="tv_count"
                                                value="<?= e($laboratory['tv_count']) ?>"
                                                class="w-full ps-11 p-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block">
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Deskripsi</label>
                                    <textarea name="description" rows="4"
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block resize-none"><?= e($laboratory['description']) ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 sticky top-6">
                            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                                <i class="bi bi-image text-primary-600"></i> Foto Lab
                            </h2>

                            <div
                                class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:bg-slate-50 transition-colors group cursor-pointer relative">
                                <input type="file" name="image_file" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    onchange="previewImage(event)">

                                <div id="preview-container"
                                    class="<?= empty($laboratory['image']) ? 'hidden' : '' ?> mb-3">
                                    <img id="preview-img"
                                        src="<?= !empty($laboratory['image']) ? BASE_URL . '/' . $laboratory['image'] : '#' ?>"
                                        class="w-full h-40 object-cover rounded-lg shadow-sm">
                                </div>

                                <div id="upload-placeholder"
                                    class="<?= !empty($laboratory['image']) ? 'hidden' : '' ?>">
                                    <i
                                        class="bi bi-cloud-arrow-up text-4xl text-slate-300 group-hover:text-primary-500 transition-colors"></i>
                                    <p class="text-sm text-slate-500 mt-2 font-medium">Klik untuk ganti foto</p>
                                    <p class="text-xs text-slate-400 mt-1">JPG, PNG (Max 2MB)</p>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full mt-6 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-semibold rounded-xl text-sm px-5 py-3 transition-all shadow-lg shadow-primary-500/30 flex justify-center items-center gap-2">
                                <i class="bi bi-check-lg"></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </main>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        const output = document.getElementById('preview-img');
        const container = document.getElementById('preview-container');
        const placeholder = document.getElementById('upload-placeholder');

        output.src = reader.result;
        container.classList.remove('hidden');
        placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>