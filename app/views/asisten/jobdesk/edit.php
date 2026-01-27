<?php $title = 'Update Progress Jobdesk'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="<?= url('/asisten/jobdesk') ?>" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="bi bi-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold text-slate-800">Update Progress Jobdesk</h1>
            </div>
            <p class="text-slate-500">Update status dan progress pengerjaan tugas Anda.</p>
        </div>

        <?php displayFlash(); ?>

        <!-- Task Info Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Tugas</h3>
            <div class="space-y-3">
                <div class="flex gap-3">
                    <span class="text-slate-500 w-32">Laboratorium:</span>
                    <span class="font-medium text-slate-800"><?= htmlspecialchars($task['lab_name']) ?></span>
                </div>
                <div class="flex gap-3">
                    <span class="text-slate-500 w-32">PC:</span>
                    <span class="font-medium text-slate-800"><?= htmlspecialchars($task['pc_number'] ?: '-') ?></span>
                </div>
                <div class="flex gap-3">
                    <span class="text-slate-500 w-32">Jenis Masalah:</span>
                    <span class="font-medium text-slate-800 capitalize"><?= htmlspecialchars($task['problem_type']) ?></span>
                </div>
                <div class="flex gap-3">
                    <span class="text-slate-500 w-32">Deskripsi:</span>
                    <span class="text-slate-800"><?= htmlspecialchars($task['description']) ?></span>
                </div>
            </div>
        </div>

        <!-- Update Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <form method="POST" action="<?= url('/asisten/jobdesk/' . $task['id'] . '/edit') ?>" class="space-y-6">

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                        Status Pengerjaan <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status" required class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="in_progress" <?= $task['status'] == 'in_progress' ? 'selected' : '' ?>>Sedang Dikerjakan</option>
                        <option value="resolved" <?= $task['status'] == 'resolved' ? 'selected' : '' ?>>Selesai</option>
                        <option value="reported" <?= $task['status'] == 'reported' ? 'selected' : '' ?>>Pending</option>
                    </select>
                </div>

                <!-- Catatan Pengerjaan -->
                <div>
                    <label for="note" class="block text-sm font-medium text-slate-700 mb-2">
                        Catatan Pengerjaan
                    </label>
                    <textarea id="note" name="note" rows="4" placeholder="Apa yang sudah Anda lakukan? Kendala apa yang dihadapi?" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                    <p class="mt-1 text-sm text-slate-500">Catatan ini akan disimpan dalam riwayat perubahan</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    <a href="<?= url('/asisten/jobdesk') ?>" class="flex-1 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg shadow-lg shadow-emerald-500/30 transition-all">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
