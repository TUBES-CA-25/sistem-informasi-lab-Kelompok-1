<?php $title = 'Edit Sesi Pertemuan'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-3xl mx-auto">

            <div class="flex items-center gap-4 mb-8">
                <a href="<?= url('/admin/schedules/' . $session['course_plan_id'] . '/sessions') ?>"
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 shadow-sm transition-all">
                    <i class="bi bi-arrow-left text-lg"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Reschedule Sesi</h1>
                    <p class="text-sm text-slate-500">
                        Pertemuan Ke-<?= $session['meeting_number'] ?> &bull; <?= e($session['course_name']) ?>
                    </p>
                </div>
            </div>

            <?php displayFlash(); ?>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-1 space-y-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                        <h3 class="text-xs font-bold text-slate-400 uppercase mb-3">Info Awal</h3>

                        <div class="mb-4">
                            <span class="block text-xs text-slate-500">Laboratorium</span>
                            <span class="font-bold text-slate-800"><?= e($session['lab_name']) ?></span>
                        </div>

                        <div class="mb-4">
                            <span class="block text-xs text-slate-500">Jadwal Asli</span>
                            <div class="font-medium text-slate-700">
                                <?= date('d M Y', strtotime($session['session_date'])) ?>
                            </div>
                            <div class="font-mono text-xs text-slate-500">
                                <?= date('H:i', strtotime($session['start_time'])) ?> -
                                <?= date('H:i', strtotime($session['end_time'])) ?>
                            </div>
                        </div>

                        <div
                            class="p-3 bg-blue-50 rounded-lg border border-blue-100 text-xs text-blue-700 leading-relaxed">
                            <i class="bi bi-info-circle-fill mr-1"></i>
                            Mengubah tanggal di sini <strong>tidak</strong> mengubah sesi lain secara otomatis.
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <form action="<?= url('/admin/sessions/' . $session['id'] . '/edit') ?>" method="POST"
                        class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">

                        <div class="space-y-6">

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Tanggal Baru</label>
                                <input type="date" name="session_date" value="<?= $session['session_date'] ?>" required
                                    class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500">
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-slate-700">Jam Mulai</label>
                                    <input type="time" name="start_time" value="<?= $session['start_time'] ?>" required
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500">
                                </div>
                                <div>
                                    <label class="block mb-2 text-sm font-bold text-slate-700">Jam Selesai</label>
                                    <input type="time" name="end_time" value="<?= $session['end_time'] ?>" required
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 focus:border-primary-500">
                                </div>
                            </div>

                            <div>
                                <label class="block mb-2 text-sm font-bold text-slate-700">Status Sesi</label>
                                <div class="relative">
                                    <select name="status"
                                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-100 appearance-none">
                                        <option value="scheduled"
                                            <?= $session['status'] == 'scheduled' ? 'selected' : '' ?>>Scheduled
                                            (Terjadwal)</option>
                                        <option value="completed"
                                            <?= $session['status'] == 'completed' ? 'selected' : '' ?>>Completed
                                            (Selesai)</option>
                                        <option value="cancelled"
                                            <?= $session['status'] == 'cancelled' ? 'selected' : '' ?>>Cancelled
                                            (Dibatalkan)</option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                        <i class="bi bi-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-100 flex gap-3">
                                <button type="submit"
                                    class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-primary-500/30 transition-all">
                                    Simpan Perubahan
                                </button>
                                <a href="<?= url('/admin/schedules/' . $session['course_plan_id'] . '/sessions') ?>"
                                    class="flex-1 bg-white border border-slate-200 text-slate-700 font-bold py-3 rounded-xl hover:bg-slate-50 text-center transition-all">
                                    Batal
                                </a>
                            </div>

                        </div>
                    </form>
                </div>

            </div>

        </div>
    </main>
</div>
<?php include APP_PATH . '/views/layouts/footer.php'; ?>