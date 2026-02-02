<?php $title = 'Tambah Laboratorium'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen pt-24 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-4 mb-8">
            <a href="<?= url('/koordinator/laboratories') ?>"
                class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all">
                <i class="bi bi-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Tambah Laboratorium</h1>
                <p class="text-slate-500 text-sm mt-1">Tambahkan data fasilitas laboratorium baru.</p>
            </div>
        </div>

        <?php displayFlash(); ?>

        <form method="POST" action="<?= url('/koordinator/laboratories/create') ?>" enctype="multipart/form-data">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 h-full">
                        <label class="block text-sm font-bold text-slate-700 mb-4">Foto Laboratorium</label>

                        <div
                            class="relative w-full aspect-[4/3] bg-slate-50 rounded-xl border-2 border-dashed border-slate-300 hover:border-primary-500 hover:bg-primary-50 transition-all group overflow-hidden cursor-pointer">
                            <input type="file" name="image" id="image"
                                class="absolute inset-0 w-full h-full opacity-0 z-10 cursor-pointer"
                                onchange="previewImage(event)" accept="image/*">

                            <div id="upload-placeholder"
                                class="absolute inset-0 flex flex-col items-center justify-center text-center p-4">
                                <div
                                    class="w-12 h-12 bg-white rounded-full shadow-sm flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                    <i class="bi bi-cloud-arrow-up text-2xl text-primary-500"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-700">Upload Foto</p>
                                <p class="text-xs text-slate-400 mt-1">Klik atau drag file ke sini</p>
                                <p class="text-[10px] text-slate-400 mt-2">JPG, PNG (Max 2MB)</p>
                            </div>

                            <div id="preview-container" class="absolute inset-0 hidden bg-white">
                                <img id="preview-img" src="" class="w-full h-full object-cover">
                                <div
                                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <p class="text-white text-sm font-bold"><i class="bi bi-pencil me-1"></i> Ganti Foto
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                        <div class="space-y-6">

                            <div>
                                <label for="lab_name" class="block text-sm font-bold text-slate-700 mb-2">Nama
                                    Laboratorium <span class="text-rose-500">*</span></label>
                                <input type="text" id="lab_name" name="lab_name" required
                                    placeholder="Contoh: Lab Komputer 1"
                                    class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 transition-all">
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-bold text-slate-700 mb-2">Lokasi</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <input type="text" id="location" name="location"
                                        placeholder="Contoh: Gedung A Lantai 2"
                                        class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-3 transition-all">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="pc_count" class="block text-sm font-bold text-slate-700 mb-2">Jumlah
                                        PC</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                            <i class="bi bi-pc-display"></i>
                                        </div>
                                        <input type="number" id="pc_count" name="pc_count" value="0" min="0"
                                            class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-3 transition-all">
                                    </div>
                                </div>
                                <div>
                                    <label for="tv_count" class="block text-sm font-bold text-slate-700 mb-2">Jumlah
                                        TV</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                            <i class="bi bi-tv"></i>
                                        </div>
                                        <input type="number" id="tv_count" name="tv_count" value="0" min="0"
                                            class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-3 transition-all">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="description"
                                    class="block text-sm font-bold text-slate-700 mb-2">Deskripsi</label>
                                <textarea id="description" name="description" rows="4"
                                    placeholder="Deskripsi fasilitas dan kegunaan laboratorium..."
                                    class="bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-primary-500 focus:border-primary-500 block w-full p-3 transition-all"></textarea>
                            </div>

                            <div class="pt-4">
                                <button type="submit"
                                    class="w-full flex justify-center items-center gap-2 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-bold rounded-xl text-sm px-5 py-3.5 shadow-lg shadow-primary-500/30 transition-all">
                                    <i class="bi bi-save"></i> Simpan Laboratorium
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>

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
    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
}
</script>