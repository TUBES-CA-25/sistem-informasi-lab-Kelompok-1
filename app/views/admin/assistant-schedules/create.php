<?php $title = 'Tambah Jadwal Piket';
$adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-2xl mx-auto">

            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/assistant-schedules') ?>"
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                    title="Kembali">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Tambah Piket Baru</h1>
                    <p class="text-slate-500 text-sm mt-1">Tugaskan asisten untuk piket harian.</p>
                </div>
            </div>

            <?php displayFlash(); ?>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">

                <form method="POST" action="<?= url('/admin/assistant-schedules/create') ?>">

                    <div class="space-y-6">

                        <div>
                            <label for="user_id" class="block mb-2 text-sm font-semibold text-slate-700">
                                <i class="bi bi-person mr-1 text-slate-400"></i> Nama Asisten <span
                                    class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="user_id" id="user_id"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none transition-all cursor-pointer"
                                    required>
                                    <option value="">-- Pilih Asisten --</option>
                                    <?php foreach ($assistants as $assistant): ?>
                                    <option value="<?= $assistant['id'] ?>"><?= e($assistant['name']) ?>
                                        (<?= e($assistant['email']) ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                    <i class="bi bi-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="day" class="block mb-2 text-sm font-semibold text-slate-700">
                                <i class="bi bi-calendar-event mr-1 text-slate-400"></i> Hari Piket <span
                                    class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="day" id="day"
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none transition-all cursor-pointer"
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
                                    <i class="bi bi-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 my-2"></div>

                        <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
                            <label for="status" class="block mb-2 text-sm font-semibold text-slate-700">Status
                                Awal</label>
                            <div class="relative">
                                <select name="status" id="status"
                                    class="w-full px-4 py-3 bg-white border border-slate-300 text-slate-900 text-sm rounded-lg focus:ring-2 focus:ring-primary-100 focus:border-primary-500 block appearance-none transition-all cursor-pointer"
                                    required>
                                    <option value="scheduled" selected>Scheduled (Aktif)</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                    <i class="bi bi-chevron-down text-xs"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="flex items-center gap-4 mt-8 pt-6 border-t border-slate-100">
                        <button type="submit"
                            class="flex-1 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-semibold rounded-xl text-sm px-5 py-3 transition-all shadow-lg shadow-primary-500/30 flex justify-center items-center gap-2">
                            <i class="bi bi-plus-lg"></i>
                            Simpan Jadwal
                        </button>

                        <a href="<?= url('/admin/assistant-schedules') ?>"
                            class="flex-1 text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 hover:text-slate-900 focus:ring-4 focus:ring-slate-100 font-medium rounded-xl text-sm px-5 py-3 text-center transition-all">
                            Batal
                        </a>
                    </div>

                </form>
            </div>

        </div>
    </main>
</div>