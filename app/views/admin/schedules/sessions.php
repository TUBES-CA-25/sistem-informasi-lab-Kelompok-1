<?php $title = 'Daftar Sesi - ' . e($plan['course_name']); ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <a href="<?= url('/admin/schedules') ?>"
                        class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-500 hover:text-primary-600 hover:border-primary-200 shadow-sm transition-all"
                        title="Kembali ke Daftar Matkul">
                        <i class="bi bi-arrow-left text-lg"></i>
                    </a>
                    <div>
                        <div class="flex items-center gap-2">
                            <span
                                class="bg-primary-100 text-primary-700 text-[10px] font-bold px-2 py-0.5 rounded border border-primary-200 uppercase tracking-wider">
                                Kelas <?= e($plan['class_code']) ?>
                            </span>
                            <span class="text-slate-400 text-xs">•</span>
                            <span
                                class="text-slate-500 text-xs font-bold uppercase tracking-wider"><?= e($plan['lab_name']) ?></span>
                        </div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900 mt-1">
                            <?= e($plan['course_name']) ?>
                        </h1>
                    </div>
                </div>

                <div class="flex gap-3">
                    <div class="bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm text-center">
                        <span class="block text-xs text-slate-400 font-bold uppercase">Total Sesi</span>
                        <span class="block text-lg font-bold text-slate-800"><?= count($sessions) ?></span>
                    </div>
                    <div class="bg-white px-4 py-2 rounded-xl border border-slate-200 shadow-sm text-center">
                        <span class="block text-xs text-slate-400 font-bold uppercase">Dosen</span>
                        <span
                            class="block text-lg font-bold text-slate-800 text-ellipsis overflow-hidden w-24 whitespace-nowrap"
                            title="<?= e($plan['lecturer_name']) ?>">
                            <?= explode(' ', e($plan['lecturer_name']))[0] ?>
                        </span>
                    </div>
                </div>
            </div>

            <?php displayFlash(); ?>

            <?php if (!empty($sessions)): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">

                <?php foreach ($sessions as $session): ?>
                <?php
                        $dateObj = new DateTime($session['session_date']);
                        $dayName = $dateObj->format('l');
                        $daysID = ['Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu', 'Sunday' => 'Minggu'];
                        $dayIndo = $daysID[$dayName] ?? $dayName;

                        // Cek status waktu (Selesai/Terjadwal)
                        $isPast = $dateObj < new DateTime('today');
                        $cardOpacity = $isPast ? 'opacity-70 hover:opacity-100' : 'opacity-100';
                        $statusBadge = $isPast
                            ? '<span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded border border-slate-200 font-bold">Selesai</span>'
                            : '<span class="text-[10px] bg-emerald-50 text-emerald-600 px-2 py-0.5 rounded border border-emerald-100 font-bold">Terjadwal</span>';
                        ?>

                <div
                    class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-primary-300 transition-all duration-300 relative overflow-hidden <?= $cardOpacity ?>">

                    <div class="px-5 py-4 border-b border-slate-50 flex justify-between items-start bg-slate-50/30">
                        <div>
                            <span class="text-xs font-bold text-primary-600 uppercase tracking-wider block mb-1">
                                Pertemuan #<?= $session['meeting_number'] ?>
                            </span>
                            <?= $statusBadge ?>
                        </div>

                        <form method="POST" action="<?= url('/admin/sessions/' . $session['id'] . '/delete') ?>"
                            onsubmit="return confirm('Hapus HANYA sesi tanggal <?= $dateObj->format('d M Y') ?> ini?');">
                            <button type="submit"
                                class="w-8 h-8 rounded-lg flex items-center justify-center text-slate-300 hover:text-rose-500 hover:bg-rose-50 transition-colors"
                                title="Hapus Sesi Ini">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>

                    <div class="p-5">
                        <div class="flex items-center gap-4 mb-4">
                            <div
                                class="flex flex-col items-center justify-center w-14 h-14 bg-slate-50 rounded-xl border border-slate-100 text-slate-700 group-hover:bg-primary-50 group-hover:text-primary-700 group-hover:border-primary-100 transition-colors">
                                <span class="text-xl font-bold leading-none"><?= $dateObj->format('d') ?></span>
                                <span class="text-[10px] font-bold uppercase mt-0.5"><?= $dateObj->format('M') ?></span>
                            </div>

                            <div>
                                <h3 class="font-bold text-slate-900 text-lg leading-tight"><?= $dayIndo ?></h3>
                                <p class="text-sm font-mono text-slate-500 mt-0.5 flex items-center gap-1">
                                    <i class="bi bi-clock text-[10px]"></i>
                                    <?= date('H:i', strtotime($session['start_time'])) ?> -
                                    <?= date('H:i', strtotime($session['end_time'])) ?>
                                </p>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="<?= url('/admin/sessions/' . $session['id']) ?>"
                                class="flex-1 py-2.5 text-center text-sm font-bold text-slate-600 bg-slate-50 rounded-xl border border-transparent hover:bg-white hover:border-slate-200 hover:shadow-sm transition-all">
                                Detail
                            </a>

                            <a href="<?= url('/admin/sessions/' . $session['id'] . '/edit') ?>"
                                class="w-10 flex items-center justify-center text-amber-500 bg-amber-50 rounded-xl border border-transparent hover:bg-amber-100 hover:border-amber-200 transition-all"
                                title="Reschedule">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </div>

                    </div>
                </div>

                <?php endforeach; ?>
            </div>

            <?php else: ?>
            <div
                class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl border border-dashed border-slate-300">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4">
                    <i class="bi bi-calendar-x text-4xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Tidak ada sesi ditemukan</h3>
                <p class="text-slate-500 text-sm mt-1 max-w-sm text-center">
                    Mungkin sesi telah dihapus atau terjadi kesalahan saat generate jadwal.
                </p>
                <div class="mt-6">
                    <a href="<?= url('/admin/schedules/' . $plan['id'] . '/edit') ?>"
                        class="text-primary-600 font-bold hover:underline">
                        Edit Master Plan
                    </a>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </main>
</div>

<?php include APP_PATH . '/views/admin/layouts/footer.php'; ?>