<?php $title = 'Buat Laporan Masalah'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-3xl mx-auto">

            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/problems') ?>"
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 shadow-sm transition-all">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Buat Laporan Baru</h1>
                    <p class="text-slate-500 text-sm">Input masalah teknis laboratorium secara manual.</p>
                </div>
            </div>

            <?php displayFlash(); ?>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                <form action="<?= url('/admin/problems/create') ?>" method="POST">
                    <div class="space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Laboratorium</label>
                                <select name="laboratory_id"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100"
                                    required>
                                    <option value="">-- Pilih Lab --</option>
                                    <?php foreach ($laboratories as $lab): ?>
                                    <option value="<?= $lab['id'] ?>"><?= e($lab['lab_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Nomor PC / Perangkat</label>
                                <input type="text" name="pc_number"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100"
                                    placeholder="Contoh: 05 atau Server" required>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Kategori Masalah</label>
                                <select name="problem_type"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100">
                                    <option value="hardware">Hardware (Perangkat Keras)</option>
                                    <option value="software">Software (Aplikasi/OS)</option>
                                    <option value="network">Jaringan / Internet</option>
                                    <option value="other">Lainnya</option>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Nama Pelapor
                                    (Opsional)</label>
                                <input type="text" name="reporter_name"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100"
                                    value="Admin" placeholder="Nama Mahasiswa/Dosen">
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">Deskripsi Masalah</label>
                            <textarea name="description" rows="4"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100"
                                placeholder="Jelaskan detail kerusakan..." required></textarea>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex gap-3">
                            <button type="submit"
                                class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-primary-500/30">
                                Simpan Laporan
                            </button>
                            <a href="<?= url('/admin/problems') ?>"
                                class="flex-1 bg-white border border-slate-200 text-slate-700 font-bold py-3 rounded-xl hover:bg-slate-50 text-center transition-all">
                                Batal
                            </a>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </main>
</div>

<?php include APP_PATH . '/views/admin/layouts/footer.php'; ?>