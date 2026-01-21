<?php $title = 'Edit Laporan Masalah'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-white flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <i class="bi bi-pencil-square text-emerald-600 text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">Edit Laporan Masalah</h2>
                        <p class="text-sm text-slate-500">Perbarui detail laporan kerusakan</p>
                    </div>
                </div>
                <a href="<?= url('/asisten/problems') ?>" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="bi bi-x-lg text-lg"></i>
                </a>
            </div>

            <form method="POST" action="<?= url('/asisten/problems/' . $problem['id'] . '/edit') ?>" class="p-6 space-y-6">

                <div>
                    <label for="laboratory_id" class="block text-sm font-semibold text-slate-700 mb-2">
                        Laboratorium <span class="text-rose-500">*</span>
                    </label>
                    <select name="laboratory_id" id="laboratory_id" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all bg-white">
                        <option value="">-- Pilih Laboratorium --</option>
                        <?php foreach ($laboratories as $lab): ?>
                            <option value="<?= $lab['id'] ?>" <?= $problem['laboratory_id'] == $lab['id'] ? 'selected' : '' ?>>
                                <?= e($lab['lab_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="pc_number" class="block text-sm font-semibold text-slate-700 mb-2">
                        Nomor PC <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="pc_number" id="pc_number" required
                        value="<?= e($problem['pc_number']) ?>"
                        placeholder="Contoh: PC-01"
                        class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label for="problem_type" class="block text-sm font-semibold text-slate-700 mb-2">
                        Jenis Masalah <span class="text-rose-500">*</span>
                    </label>
                    <select name="problem_type" id="problem_type" required
                        class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all bg-white">
                        <option value="hardware" <?= $problem['problem_type'] == 'hardware' ? 'selected' : '' ?>>Hardware (Perangkat Keras)</option>
                        <option value="software" <?= $problem['problem_type'] == 'software' ? 'selected' : '' ?>>Software (Perangkat Lunak)</option>
                        <option value="network" <?= $problem['problem_type'] == 'network' ? 'selected' : '' ?>>Network (Jaringan)</option>
                        <option value="other" <?= $problem['problem_type'] == 'other' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-2">
                        Deskripsi Masalah <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="6" required
                        placeholder="Jelaskan masalah secara detail..."
                        class="w-full px-4 py-3 border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none"><?= e($problem['description']) ?></textarea>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 pt-4 border-t border-slate-100">
                    <button type="submit"
                        class="flex-1 px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-lg hover:from-emerald-700 hover:to-emerald-800 transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <i class="bi bi-check-lg"></i>
                        Simpan Perubahan
                    </button>
                    <a href="<?= url('/asisten/problems') ?>"
                        class="flex-1 px-6 py-3 bg-slate-100 text-slate-700 font-bold rounded-lg hover:bg-slate-200 transition-all text-center flex items-center justify-center gap-2">
                        <i class="bi bi-x-circle"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>