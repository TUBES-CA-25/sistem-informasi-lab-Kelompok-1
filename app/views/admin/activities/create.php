<?php $title = 'Tambah Kegiatan'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-10">
        <div class="max-w-3xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-slate-800">Posting Kegiatan Baru</h1>
                <a href="<?= url('/admin/activities') ?>" class="text-sm text-slate-500 hover:text-sky-600">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <?php displayFlash(); ?>

            <form method="POST" action="<?= url('/admin/activities/create') ?>" enctype="multipart/form-data">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">

                    <h3 class="font-bold text-sky-600 border-b pb-2 mb-4">Konten Utama</h3>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Judul Kegiatan *</label>
                        <input type="text" name="title" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" placeholder="Contoh: Kunjungan Industri ke Jakarta" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Link Berita / Blog (URL) *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none text-slate-500">
                                <i class="bi bi-link-45deg text-lg"></i>
                            </div>
                            <input type="url" name="link_url" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full ps-10 p-2.5" placeholder="https://fikom.umi.ac.id/berita/..." required>
                        </div>
                        <p class="mt-1 text-xs text-slate-500">Masukkan link lengkap ke halaman berita atau blog terkait.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Kategori</label>
                            <select name="activity_type" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5">
                                <option value="general">Umum / Berita</option>
                                <option value="praktikum">Praktikum</option>
                                <option value="seminar">Seminar / Workshop</option>
                                <option value="lomba">Lomba / Kompetisi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Tanggal Kegiatan</label>
                            <input type="date" name="activity_date" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Deskripsi Singkat</label>
                        <textarea name="description" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" placeholder="Tulis ringkasan singkat untuk ditampilkan di halaman depan..."></textarea>
                    </div>

                    <div class="mb-6 p-4 bg-sky-50 rounded-lg border border-sky-100">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Upload Cover Image</label>
                        <input class="block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white" name="image_cover_file" type="file" accept="image/*">
                        <p class="mt-1 text-xs text-slate-500">Gambar ini akan tampil sebagai thumbnail di halaman depan.</p>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="text-white bg-sky-600 hover:bg-sky-700 font-medium rounded-lg text-sm px-5 py-2.5">Terbitkan Kegiatan</button>
                        <a href="<?= url('/admin/activities') ?>" class="text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
<?php include APP_PATH . '/views/layouts/footer.php'; ?>