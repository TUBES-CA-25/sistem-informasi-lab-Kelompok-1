<?php $title = 'Tambah Staff'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-10">
        <div class="max-w-3xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-slate-800">Tambah Staff Baru</h1>
                <a href="<?= url('/admin/head-laboran') ?>" class="text-sm text-slate-500 hover:text-sky-600">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>

            <?php displayFlash(); ?>

            <form method="POST" action="<?= url('/admin/head-laboran/create') ?>" enctype="multipart/form-data">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">

                    <h3 class="font-bold text-sky-600 border-b pb-2 mb-4">Informasi Personal</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Pilih User *</label>
                            <select name="user_id" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="">-- Pilih Akun --</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>"><?= e($user['name']) ?> (<?= e($user['role_name']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <p class="mt-1 text-xs text-slate-500">Hanya menampilkan user yang belum terdaftar sebagai staff.</p>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Jabatan / Posisi *</label>
                            <input type="text" name="position" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" placeholder="Contoh: Kepala Lab Multimedia" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Upload Foto Profil</label>
                        <input class="block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-slate-50" name="photo_file" type="file" accept="image/*">
                        <p class="mt-1 text-xs text-slate-500">JPG, PNG (Max 2MB). Disarankan rasio 1:1.</p>
                    </div>

                    <h3 class="font-bold text-sky-600 border-b pb-2 mb-4 mt-8">Status Kehadiran Awal</h3>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Status Saat Ini *</label>
                        <select name="status" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                            <option value="active">Active (Sedang Hadir)</option>
                            <option value="inactive">Inactive (Sedang Keluar)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Lokasi Saat Ini</label>
                            <input type="text" name="location" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" placeholder="Contoh: Lab Komputer 1">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Jam Masuk</label>
                            <input type="time" name="time_in" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Catatan / Keterangan</label>
                        <textarea name="notes" rows="2" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" placeholder="Pesan status (Contoh: Standby di ruangan)"></textarea>
                    </div>

                    <div class="mb-4 p-4 bg-rose-50 rounded border border-rose-100">
                        <label class="block mb-2 text-sm font-bold text-rose-700">Estimasi Kembali (Jika Inactive)</label>
                        <input type="datetime-local" name="return_time" class="bg-white border border-rose-200 text-slate-900 text-sm rounded-lg block w-full p-2.5">
                    </div>

                    <div class="flex gap-4 mt-8">
                        <button type="submit" class="text-white bg-sky-600 hover:bg-sky-700 font-medium rounded-lg text-sm px-5 py-2.5">Simpan Data</button>
                        <a href="<?= url('/admin/head-laboran') ?>" class="text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
<?php include APP_PATH . '/views/layouts/footer.php'; ?>