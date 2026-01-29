<?php $title = 'Edit Masalah'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-3xl mx-auto">

            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/problems/' . $problem['id']) ?>"
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 shadow-sm transition-all">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Edit Laporan #<?= $problem['id'] ?></h1>
                    <p class="text-slate-500 text-sm">Perbarui informasi detail masalah.</p>
                </div>
            </div>

            <?php displayFlash(); ?>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                <form action="<?= url('/admin/problems/' . $problem['id'] . '/edit') ?>" method="POST">
                    <div class="space-y-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Laboratorium</label>
                                <select name="laboratory_id"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100"
                                    required>
                                    <?php foreach ($laboratories as $lab): ?>
                                    <option value="<?= $lab['id'] ?>"
                                        <?= $problem['laboratory_id'] == $lab['id'] ? 'selected' : '' ?>>
                                        <?= e($lab['lab_name']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Nomor PC</label>
                                <input type="text" name="pc_number" value="<?= e($problem['pc_number']) ?>"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100"
                                    required>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">Kategori Masalah</label>
                            <select name="problem_type"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100">
                                <option value="hardware"
                                    <?= $problem['problem_type'] == 'hardware' ? 'selected' : '' ?>>Hardware</option>
                                <option value="software"
                                    <?= $problem['problem_type'] == 'software' ? 'selected' : '' ?>>Software</option>
                                <option value="network" <?= $problem['problem_type'] == 'network' ? 'selected' : '' ?>>
                                    Network</option>
                                <option value="other" <?= $problem['problem_type'] == 'other' ? 'selected' : '' ?>>Other
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">Deskripsi Masalah</label>
                            <textarea name="description" rows="4"
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100"
                                required><?= e($problem['description']) ?></textarea>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex gap-3">
                            <button type="submit"
                                class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-amber-500/30">
                                Update Data
                            </button>
                            <a href="<?= url('/admin/problems/' . $problem['id']) ?>"
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