<?php $title = 'Edit Laporan Masalah'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h2 class="text-xl font-bold text-slate-800">Edit Laporan Masalah</h2>
                <a href="<?= url('/asisten/problems') ?>" class="text-slate-500 hover:text-slate-700">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>

            <div class="p-6">
                <form action="<?= url('/asisten/problems/' . $problem['id'] . '/edit') ?>" method="POST">

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-bold text-slate-700">Laboratorium</label>
                        <select name="laboratory_id" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                            <?php foreach ($laboratories as $lab): ?>
                                <option value="<?= $lab['id'] ?>" <?= $problem['laboratory_id'] == $lab['id'] ? 'selected' : '' ?>>
                                    <?= e($lab['lab_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">No. PC</label>
                            <input type="text" name="pc_number" value="<?= e($problem['pc_number']) ?>" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">Kategori</label>
                            <select name="problem_type" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5">
                                <option value="software" <?= $problem['problem_type'] == 'software' ? 'selected' : '' ?>>Software</option>
                                <option value="hardware" <?= $problem['problem_type'] == 'hardware' ? 'selected' : '' ?>>Hardware</option>
                                <option value="network" <?= $problem['problem_type'] == 'network' ? 'selected' : '' ?>>Jaringan</option>
                                <option value="other" <?= $problem['problem_type'] == 'other' ? 'selected' : '' ?>>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-bold text-slate-700">Deskripsi Masalah</label>
                        <textarea name="description" rows="4" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required><?= e($problem['description']) ?></textarea>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="<?= url('/asisten/problems') ?>" class="px-5 py-2.5 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50">Batal</a>
                        <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 rounded-lg shadow-lg shadow-amber-500/30">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>