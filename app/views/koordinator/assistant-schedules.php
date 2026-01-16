<?php $title = 'Jadwal Piket Asisten'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Jadwal Piket Asisten</h1>
                <p class="text-slate-500 mt-1">Jadwal piket laboratorium untuk semua asisten.</p>
            </div>

            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200 flex items-center gap-3">
                <span class="text-sm font-medium text-slate-500">Total Jadwal:</span>
                <span class="text-lg font-bold text-sky-600"><?= count($schedules ?? []) ?></span>
            </div>
        </div>

        <?php displayFlash(); ?>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <?php if (empty($schedules)): ?>
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="bi bi-calendar-x text-4xl text-slate-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900">Tidak ada jadwal piket</h3>
                    <p class="text-slate-500">Belum ada jadwal piket yang tersedia.</p>
                </div>
            <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b">
                            <tr>
                                <th class="px-6 py-4">Asisten</th>
                                <th class="px-6 py-4">Hari</th>
                                <th class="px-6 py-4">Jam</th>
                                <th class="px-6 py-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($schedules as $schedule): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs">
                                                <?= strtoupper(substr($schedule['user_name'], 0, 2)) ?>
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800"><?= e($schedule['user_name']) ?></div>
                                                <div class="text-xs text-slate-500"><?= e($schedule['email'] ?? '') ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-slate-700"><?= e($schedule['day']) ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-slate-600">
                                            <i class="bi bi-clock text-slate-400"></i>
                                            <span><?= date('H:i', strtotime($schedule['start_time'])) ?> - <?= date('H:i', strtotime($schedule['end_time'])) ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <?php
                                            $statusColors = [
                                                'scheduled' => 'bg-sky-50 text-sky-700 border-sky-200',
                                                'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200'
                                            ];
                                            $statusLabels = [
                                                'scheduled' => 'Terjadwal',
                                                'completed' => 'Selesai',
                                                'cancelled' => 'Dibatalkan'
                                            ];
                                            $statusColor = $statusColors[$schedule['status']] ?? $statusColors['scheduled'];
                                            $statusLabel = $statusLabels[$schedule['status']] ?? $schedule['status'];
                                        ?>
                                        <span class="px-3 py-1.5 text-xs font-bold rounded-lg border <?= $statusColor ?>">
                                            <?= $statusLabel ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
