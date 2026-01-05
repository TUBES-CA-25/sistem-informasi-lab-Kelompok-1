<?php $title = 'Create Schedule'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">

    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-10">
        <div class="max-w-4xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-slate-800">Tambah Jadwal Baru</h1>
            </div>

            <?php displayFlash(); ?>

            <form method="POST" action="<?= url('/admin/schedules/create') ?>" enctype="multipart/form-data">

                <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200 mb-6">
                    <h3 class="text-lg font-bold text-sky-600 mb-4 border-b pb-2">Waktu & Lokasi</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Laboratorium *</label>
                            <select name="laboratory_id" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="">Pilih Laboratorium</option>
                                <?php foreach ($laboratories as $lab): ?>
                                    <option value="<?= $lab['id'] ?>"><?= e($lab['lab_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Hari *</label>
                            <select name="day" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="">Pilih Hari</option>
                                <option value="Monday">Senin</option>
                                <option value="Tuesday">Selasa</option>
                                <option value="Wednesday">Rabu</option>
                                <option value="Thursday">Kamis</option>
                                <option value="Friday">Jumat</option>
                                <option value="Saturday">Sabtu</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Jam Mulai</label>
                            <input type="time" name="start_time" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Jam Selesai</label>
                            <input type="time" name="end_time" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200 mb-6">
                    <h3 class="text-lg font-bold text-sky-600 mb-4 border-b pb-2">Informasi Akademik</h3>

                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Mata Kuliah *</label>
                        <input type="text" name="course" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Prodi</label>
                            <select name="program_study" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                                <option value="Teknik Informatika">Teknik Informatika</option>
                                <option value="Sistem Informasi">Sistem Informasi</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Semester</label>
                            <input type="number" name="semester" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Kode Kelas</label>
                            <input type="text" name="class_code" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Kode Unik / Frekuensi</label>
                            <input type="text" name="frequency" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" placeholder="Contoh: TI_ALPRO-1" required>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-slate-700">Jumlah Mahasiswa</label>
                            <input type="number" name="participant_count" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" value="0">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block mb-2 text-sm font-medium text-slate-700">Deskripsi</label>
                        <textarea name="description" rows="3" class="bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5"></textarea>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200 mb-6">
                    <h3 class="text-lg font-bold text-sky-600 mb-4 border-b pb-2">Tim Pengajar</h3>

                    <div class="grid grid-cols-1 gap-6">
                        <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                            <div class="mb-3">
                                <label class="block mb-2 text-sm font-medium text-slate-700">Nama Dosen *</label>
                                <input type="text" name="lecturer" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-slate-700">Upload Foto Dosen</label>
                                <input class="block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white" type="file" name="lecturer_photo_file" accept="image/*">
                                <p class="mt-1 text-xs text-slate-500">Format: JPG, PNG. Maks 2MB.</p>
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                            <div class="mb-3">
                                <label class="block mb-2 text-sm font-medium text-slate-700">Asisten 1 (Utama) *</label>
                                <input type="text" name="assistant" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5" required>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-slate-700">Upload Foto Asisten 1</label>
                                <input class="block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white" type="file" name="assistant_photo_file" accept="image/*">
                            </div>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                            <div class="mb-3">
                                <label class="block mb-2 text-sm font-medium text-slate-700">Asisten 2 (Pendamping)</label>
                                <input type="text" name="assistant_2" class="bg-white border border-slate-300 text-slate-900 text-sm rounded-lg block w-full p-2.5">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-slate-700">Upload Foto Asisten 2</label>
                                <input class="block w-full text-sm text-slate-900 border border-slate-300 rounded-lg cursor-pointer bg-white" type="file" name="assistant2_photo_file" accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 mb-20">
                    <button type="submit" class="text-white bg-sky-600 hover:bg-sky-700 font-medium rounded-lg text-sm px-5 py-2.5">Simpan Jadwal</button>
                    <a href="<?= url('/admin/schedules') ?>" class="text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 font-medium rounded-lg text-sm px-5 py-2.5">Batal</a>
                </div>

            </form>
        </div>
        
    <?php include APP_PATH . '/views/layouts/footer.php'; ?>
    </main>
</div>