<?php $title = 'Buat Jadwal Kuliah'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-6xl mx-auto">

            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <a href="<?= url('/admin/schedules') ?>"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                        title="Kembali">
                        <i class="bi bi-arrow-left text-lg"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">Jadwal Kuliah Baru</h1>
                        <p class="text-sm text-slate-500 mt-1">Buat jadwal master dan generate sesi otomatis</p>
                    </div>
                </div>
            </div>

            <?php displayFlash(); ?>

            <form action="<?= url('/admin/schedules/create') ?>" method="POST" enctype="multipart/form-data">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 space-y-6">

                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h2
                                class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100 flex items-center gap-2">
                                <i class="bi bi-clock-history text-primary-500"></i> Waktu & Generator
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Laboratorium <span
                                            class="text-rose-500">*</span></label>
                                    <div class="relative">
                                        <select name="laboratory_id" required
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none">
                                            <option value="">-- Pilih Lab --</option>
                                            <?php foreach ($laboratories as $lab): ?>
                                                <option value="<?= $lab['id'] ?>"><?= $lab['lab_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                            <i class="bi bi-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-bold text-slate-800">Tanggal Mulai (Sesi 1)
                                        <span class="text-rose-500">*</span></label>
                                    <input type="date" name="start_date" required
                                        class="w-full px-4 py-2.5 bg-amber-50 border border-amber-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-amber-100 focus:border-amber-500 block">
                                    <p class="text-[10px] text-slate-500 mt-1 ml-1">* Sistem akan looping dari tanggal
                                        ini</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Hari</label>
                                    <div class="relative">
                                        <select name="day" required
                                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none">
                                            <option value="Monday">Senin</option>
                                            <option value="Tuesday">Selasa</option>
                                            <option value="Wednesday">Rabu</option>
                                            <option value="Thursday">Kamis</option>
                                            <option value="Friday">Jumat</option>
                                            <option value="Saturday">Sabtu</option>
                                            <option value="Sunday">Minggu</option>
                                        </select>
                                        <div
                                            class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                            <i class="bi bi-chevron-down text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Jam Mulai</label>
                                    <input type="time" name="start_time" required
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Jam Selesai</label>
                                    <input type="time" name="end_time" required
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block">
                                </div>
                            </div>

                            <div class="p-4 bg-amber-50 rounded-xl border border-amber-100 flex items-center gap-4">
                                <div
                                    class="shrink-0 w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
                                    <i class="bi bi-repeat text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <label
                                        class="block text-xs font-bold text-amber-800 uppercase tracking-wider mb-1">Total
                                        Pertemuan</label>
                                    <div class="flex items-center gap-2">
                                        <input type="number" name="total_meetings" value="14" min="1" max="20" required
                                            class="w-20 px-3 py-1.5 bg-white border border-amber-200 rounded-lg text-center font-bold text-slate-800 focus:ring-amber-500 focus:border-amber-500">
                                        <span class="text-sm text-amber-700 font-medium">Sesi Minggu</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                            <h2
                                class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100 flex items-center gap-2">
                                <i class="bi bi-book text-violet-500"></i> Informasi Akademik
                            </h2>

                            <div class="mb-6">
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Mata Kuliah <span
                                        class="text-rose-500">*</span></label>
                                <input type="text" name="course" required placeholder="Contoh: Algoritma Pemrograman"
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Program Studi</label>
                                    <input type="text" name="program_study" placeholder="Teknik Informatika"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Kode Kelas</label>
                                    <input type="text" name="class_code" required placeholder="A1 / B2"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-slate-700">Semester</label>
                                    <input type="number" name="semester" placeholder="1-8"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block">
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-semibold text-slate-700">Deskripsi
                                    Tambahan</label>
                                <textarea name="description" rows="2"
                                    class="w-full p-4 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block resize-none"
                                    placeholder="Catatan..."></textarea>
                            </div>
                        </div>

                    </div>

                    <div class="lg:col-span-1 space-y-6">

                        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sticky top-6">
                            <h2
                                class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-6 pb-2 border-b border-slate-100 flex items-center gap-2">
                                <i class="bi bi-people-fill text-emerald-500"></i> Tim Pengajar
                            </h2>

                            <div
                                class="mb-6 p-4 bg-primary-50/50 rounded-xl border border-primary-100 group hover:border-primary-300 transition-colors">
                                <label class="block mb-2 text-xs font-bold text-primary-700 uppercase">Dosen Pengampu
                                    *</label>
                                <input type="text" name="lecturer" required placeholder="Nama Lengkap & Gelar"
                                    class="w-full px-3 py-2 bg-white border border-slate-200 text-slate-900 text-sm rounded-lg mb-3 focus:ring-2 focus:ring-primary-100 block">

                                <label class="flex items-center gap-3 cursor-pointer">
                                    <div
                                        class="w-10 h-10 rounded-full bg-white border border-dashed border-primary-300 flex items-center justify-center text-primary-400 group-hover:text-primary-600 group-hover:border-primary-500 transition-all">
                                        <i class="bi bi-camera"></i>
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-xs font-medium text-slate-600 block">Upload Foto Dosen</span>
                                        <input type="file" name="lecturer_photo_file" accept="image/*"
                                            class="text-[10px] text-slate-400 file:hidden">
                                    </div>
                                </label>
                            </div>

                            <div
                                class="mb-6 p-4 bg-emerald-50/50 rounded-xl border border-emerald-100 group hover:border-emerald-300 transition-colors">
                                <label class="block mb-2 text-xs font-bold text-emerald-700 uppercase">Asisten 1
                                    (Utama)</label>
                                <input type="text" name="assistant" placeholder="Nama Asisten 1"
                                    class="w-full px-3 py-2 bg-white border border-slate-200 text-slate-900 text-sm rounded-lg mb-3 focus:ring-2 focus:ring-emerald-100 block">

                                <label class="flex items-center gap-3 cursor-pointer">
                                    <div
                                        class="w-10 h-10 rounded-full bg-white border border-dashed border-emerald-300 flex items-center justify-center text-emerald-400 group-hover:text-emerald-600 group-hover:border-emerald-500 transition-all">
                                        <i class="bi bi-camera"></i>
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-xs font-medium text-slate-600 block">Upload Foto Asisten
                                            1</span>
                                        <input type="file" name="assistant_photo_file" accept="image/*"
                                            class="text-[10px] text-slate-400 file:hidden">
                                    </div>
                                </label>
                            </div>

                            <div
                                class="mb-8 p-4 bg-violet-50/50 rounded-xl border border-violet-100 group hover:border-violet-300 transition-colors">
                                <label class="block mb-2 text-xs font-bold text-violet-700 uppercase">Asisten 2
                                    (Opsional)</label>
                                <input type="text" name="assistant_2" placeholder="Nama Asisten 2"
                                    class="w-full px-3 py-2 bg-white border border-slate-200 text-slate-900 text-sm rounded-lg mb-3 focus:ring-2 focus:ring-violet-100 block">

                                <label class="flex items-center gap-3 cursor-pointer">
                                    <div
                                        class="w-10 h-10 rounded-full bg-white border border-dashed border-violet-300 flex items-center justify-center text-violet-400 group-hover:text-violet-600 group-hover:border-violet-500 transition-all">
                                        <i class="bi bi-camera"></i>
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-xs font-medium text-slate-600 block">Upload Foto Asisten
                                            2</span>
                                        <input type="file" name="assistant2_photo_file" accept="image/*"
                                            class="text-[10px] text-slate-400 file:hidden">
                                    </div>
                                </label>
                            </div>

                            <button type="submit"
                                class="w-full py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-lg shadow-primary-500/30 transition-all flex items-center justify-center gap-2 transform active:scale-95">
                                <i class="bi bi-magic"></i>
                                Generate Jadwal
                            </button>

                        </div>
                    </div>

                </div>
            </form>
        </div>
    </main>
</div>