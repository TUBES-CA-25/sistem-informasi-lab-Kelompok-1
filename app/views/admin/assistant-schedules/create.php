<?php $title = 'Tambah Jadwal Piket'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-2xl mx-auto">

            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/assistant-schedules') ?>"
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 shadow-sm transition-all">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Tambah Jadwal Piket</h1>
                    <p class="text-slate-500 text-sm">Input data petugas piket harian.</p>
                </div>
            </div>

            <?php displayFlash(); ?>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                <form method="POST" action="<?= url('/admin/assistant-schedules/create') ?>">
                    <div class="space-y-6">

                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">1. Nama Asisten</label>
                            <div class="relative">
                                <select name="user_id"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 cursor-pointer appearance-none"
                                    required>
                                    <option value="">-- Pilih Asisten --</option>
                                    <?php foreach ($assistants as $assistant): ?>
                                    <option value="<?= $assistant['id'] ?>"><?= e($assistant['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                    <i class="bi bi-chevron-down"></i></div>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-bold text-slate-700">2. Hari Piket</label>
                            <div class="relative">
                                <select name="day"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 cursor-pointer appearance-none"
                                    required>
                                    <option value="">-- Pilih Hari --</option>
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
                                    <i class="bi bi-chevron-down"></i></div>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-3 text-sm font-bold text-slate-700">3. Kategori Tugas (Role)</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer group">
                                    <input type="radio" name="job_role" value="Putra" class="peer sr-only" required>
                                    <div
                                        class="p-4 border-2 border-slate-100 rounded-xl peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all hover:bg-slate-50 text-center">
                                        <i class="bi bi-gender-male text-2xl text-emerald-600 mb-2 block"></i>
                                        <span class="font-bold text-slate-700 peer-checked:text-emerald-700">Putra
                                            (Ikhwan)</span>
                                    </div>
                                </label>

                                <label class="cursor-pointer group">
                                    <input type="radio" name="job_role" value="Putri" class="peer sr-only" required>
                                    <div
                                        class="p-4 border-2 border-slate-100 rounded-xl peer-checked:border-rose-500 peer-checked:bg-rose-50 transition-all hover:bg-slate-50 text-center">
                                        <i class="bi bi-gender-female text-2xl text-rose-600 mb-2 block"></i>
                                        <span class="font-bold text-slate-700 peer-checked:text-rose-700">Putri
                                            (Akhwat)</span>
                                    </div>
                                </label>
                            </div>
                            <p class="text-xs text-slate-400 mt-3">* Jobdesk akan otomatis mengikuti aturan yang ada di
                                tabel list.</p>
                        </div>

                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 flex gap-4">
                        <button type="submit"
                            class="flex-1 bg-slate-900 text-white py-3.5 rounded-xl font-bold shadow-lg hover:bg-slate-800 transition-all">
                            Simpan Jadwal
                        </button>
                        <a href="<?= url('/admin/assistant-schedules') ?>"
                            class="flex-1 bg-white border border-slate-300 text-slate-700 py-3.5 rounded-xl font-bold text-center hover:bg-slate-50 transition-all">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>