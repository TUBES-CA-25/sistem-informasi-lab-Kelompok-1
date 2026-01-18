<?php $title = 'Tambah Laboratorium'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="<?= url('/koordinator/laboratories') ?>" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <i class="bi bi-arrow-left text-xl"></i>
                </a>
                <h1 class="text-3xl font-bold text-slate-800">Tambah Laboratorium</h1>
            </div>
            <p class="text-slate-500">Tambahkan data laboratorium baru.</p>
        </div>

        <?php displayFlash(); ?>

        <!-- Form Card -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <form method="POST" action="<?= url('/koordinator/laboratories/create') ?>" class="space-y-6">

                <!-- Lab Name -->
                <div>
                    <label for="lab_name" class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Laboratorium <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="lab_name" name="lab_name" required placeholder="Contoh: Lab Komputer 1" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="description" name="description" rows="3" placeholder="Deskripsi singkat laboratorium..." class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500"></textarea>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="pc_count" class="block text-sm font-medium text-slate-700 mb-2">
                            Jumlah PC
                        </label>
                        <input type="number" id="pc_count" name="pc_count" min="0" value="0" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-slate-700 mb-2">
                            Kapasitas Mahasiswa
                        </label>
                        <input type="number" id="capacity" name="capacity" min="0" value="0" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                    </div>
                </div>

                <!-- Location Section -->
                <div class="border-t border-slate-200 pt-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Lokasi</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="location" class="block text-sm font-medium text-slate-700 mb-2">
                                Lokasi Umum
                            </label>
                            <input type="text" id="location" name="location" placeholder="Contoh: Gedung Teknik" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="building" class="block text-sm font-medium text-slate-700 mb-2">
                                    Gedung
                                </label>
                                <input type="text" id="building" name="building" placeholder="Gedung A" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            </div>
                            <div>
                                <label for="floor" class="block text-sm font-medium text-slate-700 mb-2">
                                    Lantai
                                </label>
                                <input type="text" id="floor" name="floor" placeholder="1, 2, 3" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            </div>
                            <div>
                                <label for="room_number" class="block text-sm font-medium text-slate-700 mb-2">
                                    Nomor Ruang
                                </label>
                                <input type="text" id="room_number" name="room_number" placeholder="101, 102" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                        Status
                    </label>
                    <select id="status" name="status" class="block w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        <option value="active">Aktif</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4 border-t border-slate-200">
                    <a href="<?= url('/koordinator/laboratories') ?>" class="flex-1 px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-lg transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-medium rounded-lg shadow-lg shadow-sky-500/30 transition-all">
                        Simpan Laboratorium
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
