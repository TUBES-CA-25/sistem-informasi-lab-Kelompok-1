<?php $title = 'Edit Staff'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-10">
        <div class="max-w-3xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-slate-800">Edit Data Staff</h1>
            </div>

            <?php displayFlash(); ?>

            <form method="POST" action="<?= url('/admin/head-laboran/' . $staff['id'] . '/edit') ?>" enctype="multipart/form-data">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">

                    <div class="flex items-center gap-4 mb-6 p-4 bg-slate-50 rounded-lg border border-slate-100">
                        <div class="w-16 h-16 rounded-full bg-slate-200 overflow-hidden border-2 border-white shadow-sm flex-shrink-0">
                            <?php if (!empty($staff['photo'])): ?>
                                <img src="<?= e($staff['photo']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-400 font-bold text-xl">
                                    <?= strtoupper(substr($user_name, 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg text-slate-800"><?= e($user_name) ?></h3>
                            <p class="text-sm text-slate-500">Mengedit status dan profil.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Jabatan / Posisi *</label>
                            <input type="text" name="position" value="<?= e($staff['position']) ?>" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Ganti Foto</label>
                            <input class="block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-slate-50" name="photo_file" type="file" accept="image/*">
                        </div>
                    </div>

                    <h3 class="font-bold text-sky-600 border-b pb-2 mb-4 mt-8">Update Status Kehadiran</h3>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Status Saat Ini *</label>
                        <select name="status" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                            <option value="active" <?= $staff['status'] == 'active' ? 'selected' : '' ?>>Active (Sedang Hadir)</option>
                            <option value="inactive" <?= $staff['status'] == 'inactive' ? 'selected' : '' ?>>Inactive (Sedang Keluar)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Lokasi</label>
                            <input type="text" name="location" value="<?= e($staff['location']) ?>" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Jam Masuk</label>
                            <input type="time" name="time_in" value="<?= e($staff['time_in']) ?>" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Catatan / Keterangan</label>
                        <textarea name="notes" rows="2" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5"><?= e($staff['notes']) ?></textarea>
                    </div>

                    <div class="mb-4 p-4 bg-rose-50 rounded border border-rose-100">
                        <label class="block mb-2 text-sm font-bold text-rose-700">Estimasi Kembali (Jika Inactive)</label>
                        <input type="datetime-local" name="return_time" value="<?= !empty($staff['return_time']) ? date('Y-m-d\TH:i', strtotime($staff['return_time'])) : '' ?>" class="bg-white border border-rose-200 text-slate-900 text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button type="submit" class="text-white bg-amber-500 hover:bg-amber-600 font-medium rounded-lg text-sm px-5 py-2.5">Update Data</button>
                        <a href="<?= url('/admin/head-laboran') ?>" class="text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>