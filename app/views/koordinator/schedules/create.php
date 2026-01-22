<?php $title = 'Tambah Jadwal Piket'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="<?= url('/koordinator/assistant-schedules') ?>" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="bi bi-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold text-slate-800">Tambah Jadwal Piket</h1>
            </div>
            <p class="text-slate-500">Buat jadwal piket baru untuk asisten laboratorium.</p>
        </div>

        <?php displayFlash(); ?>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <form method="POST" action="<?= url('/koordinator/assistant-schedules/create') ?>" class="space-y-6">

                <!-- Assistant Selection -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-slate-700 mb-2">
                        Asisten <span class="text-red-500">*</span>
                    </label>
                    <select id="user_id" name="user_id" required class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        <option value="">Pilih Asisten</option>
                        <?php foreach ($assistants as $asisten): ?>
                            <option value="<?= $asisten['id'] ?>"><?= htmlspecialchars($asisten['name']) ?> (<?= htmlspecialchars($asisten['email']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Day Selection -->
                <div>
                    <label for="day" class="block text-sm font-medium text-slate-700 mb-2">
                        Hari <span class="text-red-500">*</span>
                    </label>
                    <select id="day" name="day" required class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        <option value="">Pilih Hari</option>
                        <option value="Monday">Senin</option>
                        <option value="Tuesday">Selasa</option>
                        <option value="Wednesday">Rabu</option>
                        <option value="Thursday">Kamis</option>
                        <option value="Friday">Jumat</option>
                        <option value="Saturday">Sabtu</option>
                        <option value="Sunday">Minggu</option>
                    </select>
                </div>

                <!-- Time Range -->
                <!-- <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-slate-700 mb-2">
                            Waktu Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="start_time" name="start_time" required class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-slate-700 mb-2">
                            Waktu Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="end_time" name="end_time" required class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                </div> -->

                <!-- Task Selection -->
                <div>
                    <label for="Task" class="block text-sm font-medium text-slate-700 mb-2">
                        Tugas<span class="text-red-500">*</span>
                    </label>
                    <select id="task" name="task" required class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        <option value="">Pilih Jenis</option>
                        <option value="Domestik">Membersihkan, Memasak, dan Cuci Piring</option>
                        <option value="Logistik">Buang Sampah, Beli Lauk, dan Galon</option>
                    </select>
                </div>

                <!-- Task Description -->
                <!-- <div>
                    <label for="task_description" class="block text-sm font-medium text-slate-700 mb-2">
                        Deskripsi Tugas
                    </label>
                    <textarea id="task_description" name="task_description" rows="4" placeholder="Jelaskan tugas yang harus dikerjakan..." class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"></textarea>
                </div> -->

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    <a href="<?= url('/koordinator/assistant-schedules') ?>" class="flex-1 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg shadow-lg shadow-sky-500/30 transition-all">
                        Simpan Jadwal
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
