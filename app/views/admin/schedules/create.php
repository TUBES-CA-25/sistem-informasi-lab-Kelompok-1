<?php $title = 'Create Schedules'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-6xl mx-auto">

            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/schedules') ?>" 
                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                   title="Kembali">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Buat Jadwal Baru</h1>
                    <p class="text-slate-500 text-sm mt-1">Tambahkan jadwal praktikum untuk semester aktif.</p>
                </div>
            </div>

            <?php displayFlash(); ?>

            <form method="POST" action="<?= url('/admin/schedules/create') ?>" enctype="multipart/form-data">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100 flex items-center gap-2">
                                <i class="bi bi-clock-history text-primary-500"></i> Waktu & Lokasi
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Laboratorium <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <select name="laboratory_id" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none" required>
                                            <option value="">-- Pilih Laboratorium --</option>
                                            <?php foreach ($laboratories as $lab): ?>
                                                <option value="<?= $lab['id'] ?>"><?= e($lab['lab_name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                            <i class="bi bi-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Hari Pelaksanaan <span class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <select name="day" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none" required>
                                            <option value="">-- Pilih Hari --</option>
                                            <option value="Monday">Senin</option>
                                            <option value="Tuesday">Selasa</option>
                                            <option value="Wednesday">Rabu</option>
                                            <option value="Thursday">Kamis</option>
                                            <option value="Friday">Jumat</option>
                                            <option value="Saturday">Sabtu</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                            <i class="bi bi-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Jam Mulai</label>
                                    <input type="time" name="start_time" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" required>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Jam Selesai</label>
                                    <input type="time" name="end_time" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" required>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100 flex items-center gap-2">
                                <i class="bi bi-book text-violet-500"></i> Informasi Akademik
                            </h2>

                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Mata Kuliah <span class="text-rose-500">*</span></label>
                                <input type="text" name="course" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all font-medium" placeholder="Contoh: Algoritma dan Pemrograman" required>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Program Studi</label>
                                    <div class="relative">
                                        <select name="program_study" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none" required>
                                            <option value="Teknik Informatika">Teknik Informatika</option>
                                            <option value="Sistem Informasi">Sistem Informasi</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                            <i class="bi bi-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Semester</label>
                                    <input type="number" name="semester" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" placeholder="1-8" required>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Kode Kelas</label>
                                    <input type="text" name="class_code" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" placeholder="A/B/C..." required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Kode Unik / Frekuensi</label>
                                    <input type="text" name="frequency" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all font-mono" placeholder="TI-ALPRO-A1">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Jumlah Mahasiswa</label>
                                    <input type="number" name="participant_count" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all" value="0">
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Deskripsi Tambahan</label>
                                <textarea name="description" rows="3" class="w-full p-4 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block transition-all resize-none" placeholder="Catatan tambahan (Opsional)..."></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="lg:col-span-1 space-y-6">
                        
                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-6">
                            <h2 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100 flex items-center gap-2">
                                <i class="bi bi-people-fill text-emerald-500"></i> Tim Pengajar
                            </h2>

                            <div class="mb-6 p-4 bg-primary-50/50 rounded-xl border border-primary-100">
                                <label class="block mb-2 text-xs font-bold text-primary-700 uppercase">Dosen Pengampu <span class="text-rose-500">*</span></label>
                                <input type="text" name="lecturer" class="w-full px-3 py-2 bg-white border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-primary-100 block mb-3" required placeholder="Nama Lengkap Dosen">
                                
                                <label class="block text-[10px] text-slate-500 mb-1">Upload Foto (Opsional)</label>
                                <input class="block w-full text-xs text-slate-500 border border-slate-200 rounded-lg cursor-pointer bg-white focus:outline-none" type="file" name="lecturer_photo_file" accept="image/*">
                            </div>

                            <div class="mb-6 p-4 bg-emerald-50/50 rounded-xl border border-emerald-100">
                                <label class="block mb-2 text-xs font-bold text-emerald-700 uppercase">Asisten 1 (Utama) <span class="text-rose-500">*</span></label>
                                <input type="text" name="assistant" class="w-full px-3 py-2 bg-white border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-emerald-100 block mb-3" required placeholder="Nama Asisten 1">
                                
                                <label class="block text-[10px] text-slate-500 mb-1">Upload Foto (Opsional)</label>
                                <input class="block w-full text-xs text-slate-500 border border-slate-200 rounded-lg cursor-pointer bg-white focus:outline-none" type="file" name="assistant_photo_file" accept="image/*">
                            </div>

                            <div class="mb-8 p-4 bg-violet-50/50 rounded-xl border border-violet-100">
                                <label class="block mb-2 text-xs font-bold text-violet-700 uppercase">Asisten 2 (Opsional)</label>
                                <input type="text" name="assistant_2" class="w-full px-3 py-2 bg-white border border-slate-200 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-violet-100 block mb-3" placeholder="Nama Asisten 2">
                                
                                <label class="block text-[10px] text-slate-500 mb-1">Upload Foto (Opsional)</label>
                                <input class="block w-full text-xs text-slate-500 border border-slate-200 rounded-lg cursor-pointer bg-white focus:outline-none" type="file" name="assistant2_photo_file" accept="image/*">
                            </div>

                            <div class="flex flex-col gap-3">
                                <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-semibold rounded-xl text-sm px-5 py-3 transition-all shadow-lg shadow-primary-500/30 flex justify-center items-center gap-2">
                                    <i class="bi bi-plus-lg"></i>
                                    Buat Jadwal
                                </button>
                                <a href="<?= url('/admin/schedules') ?>" class="w-full text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 font-medium rounded-xl text-sm px-5 py-3 text-center transition-all">
                                    Batal
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </main>
</div>