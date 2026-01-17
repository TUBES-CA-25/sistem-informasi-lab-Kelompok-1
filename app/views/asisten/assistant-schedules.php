<?php $title = 'Jadwal Piket Saya'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900">Jadwal Piket Saya</h1>
            <p class="text-slate-500 mt-2 text-lg">Jadwal jaga laboratorium Anda untuk semester ini.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-1">
                <div class="bg-sky-600 text-white rounded-2xl p-6 shadow-lg shadow-sky-500/20">
                    <h3 class="text-xl font-bold mb-4">Info Kehadiran</h3>
                    <p class="text-sky-100 text-sm mb-4 leading-relaxed">
                        Wajib hadir 15 menit sebelum jam piket dimulai. Scan QR Code kehadiran di meja resepsionis laboratorium.
                    </p>
                    <div class="bg-white/10 rounded-lg p-4 backdrop-blur-sm">
                        <div class="text-xs font-bold uppercase tracking-wider text-sky-200 mb-1">Status Anda</div>
                        <div class="text-lg font-bold">Active Assistant</div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <table class="w-full text-left text-slate-500">
                        <thead class="bg-slate-50 text-slate-700 uppercase text-xs font-bold tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Hari</th>
                                <th class="px-6 py-4">Jam Mulai</th>
                                <th class="px-6 py-4">Jam Selesai</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($mySchedules)): ?>
                                <?php foreach ($mySchedules as $schedule): ?>
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-slate-900">
                                            <?= getDayName($schedule['day']) ?>
                                        </td>
                                        <td class="px-6 py-4 font-mono text-slate-600 bg-slate-50/50">
                                            <?= formatTime($schedule['start_time']) ?>
                                        </td>
                                        <td class="px-6 py-4 font-mono text-slate-600 bg-slate-50/50">
                                            <?= formatTime($schedule['end_time']) ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                                Active
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                        Anda belum memiliki jadwal piket aktif.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>