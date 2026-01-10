<?php $title = 'Laporan Saya'; $adminLayout = true; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="admin-layout antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>
    
    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Laporan Saya</h1>
                    <p class="text-slate-500 text-sm mt-1">Daftar kerusakan yang telah saya laporkan.</p>
                </div>
                
                <a href="<?= url('/asisten/report-problem') ?>" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white text-sm font-semibold rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 transition-all">
                    <i class="bi bi-plus-circle-fill"></i>
                    Lapor Kerusakan Baru
                </a>
            </div>

            <?php displayFlash(); ?>

            <!-- Statistics Cards -->
            <?php 
                $total = count($reports ?? []);
                $reported = count(array_filter($reports ?? [], fn($r) => $r['status'] === 'reported'));
                $inProgress = count(array_filter($reports ?? [], fn($r) => $r['status'] === 'in_progress'));
                $resolved = count(array_filter($reports ?? [], fn($r) => $r['status'] === 'resolved'));
            ?>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-slate-500 font-medium">Total Laporan</p>
                            <p class="text-2xl font-bold text-slate-900 mt-1"><?= $total ?></p>
                        </div>
                        <div class="p-3 bg-slate-100 text-slate-600 rounded-xl">
                            <i class="bi bi-list-check text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-amber-600 font-medium">Menunggu</p>
                            <p class="text-2xl font-bold text-amber-700 mt-1"><?= $reported ?></p>
                        </div>
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                            <i class="bi bi-clock-history text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-sky-600 font-medium">Dalam Proses</p>
                            <p class="text-2xl font-bold text-sky-700 mt-1"><?= $inProgress ?></p>
                        </div>
                        <div class="p-3 bg-sky-50 text-sky-600 rounded-xl">
                            <i class="bi bi-tools text-2xl"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-emerald-600 font-medium">Selesai</p>
                            <p class="text-2xl font-bold text-emerald-700 mt-1"><?= $resolved ?></p>
                        </div>
                        <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                            <i class="bi bi-check-circle-fill text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports Table -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs font-bold text-slate-700 uppercase bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Laboratorium</th>
                                <th class="px-6 py-4">PC/Perangkat</th>
                                <th class="px-6 py-4">Jenis Masalah</th>
                                <th class="px-6 py-4">Deskripsi</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($reports)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <i class="bi bi-inbox text-5xl mb-3"></i>
                                        <p class="text-sm font-medium text-slate-500">Belum ada laporan kerusakan</p>
                                        <a href="<?= url('/asisten/report-problem') ?>" 
                                           class="mt-3 text-emerald-600 hover:text-emerald-700 text-xs font-semibold hover:underline">
                                            Buat Laporan Pertama &rarr;
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($reports as $report): ?>
                                <tr class="border-b border-slate-100 hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-600">
                                            <i class="bi bi-calendar3 text-slate-400"></i>
                                            <?= date('d M Y', strtotime($report['reported_at'])) ?>
                                        </div>
                                        <div class="text-xs text-slate-400">
                                            <?= date('H:i', strtotime($report['reported_at'])) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold text-slate-700"><?= e($report['lab_name']) ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-slate-600"><?= e($report['pc_number'] ?? '-') ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php
                                            $typeColors = [
                                                'hardware' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                'software' => 'bg-sky-50 text-sky-700 border-sky-200',
                                                'network' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                'other' => 'bg-slate-50 text-slate-700 border-slate-200'
                                            ];
                                            $typeColor = $typeColors[$report['problem_type']] ?? $typeColors['other'];
                                        ?>
                                        <span class="px-3 py-1 text-xs font-semibold rounded-lg border <?= $typeColor ?>">
                                            <?= ucfirst($report['problem_type']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="max-w-xs text-sm text-slate-600 line-clamp-2">
                                            <?= e($report['description']) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php
                                            $statusColors = [
                                                'reported' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'in_progress' => 'bg-sky-50 text-sky-700 border-sky-200',
                                                'resolved' => 'bg-emerald-50 text-emerald-700 border-emerald-200'
                                            ];
                                            $statusLabels = [
                                                'reported' => 'Menunggu',
                                                'in_progress' => 'Proses',
                                                'resolved' => 'Selesai'
                                            ];
                                            $statusColor = $statusColors[$report['status']] ?? $statusColors['reported'];
                                            $statusLabel = $statusLabels[$report['status']] ?? $report['status'];
                                        ?>
                                        <span class="px-3 py-1.5 text-xs font-bold rounded-lg border <?= $statusColor ?>">
                                            <?= $statusLabel ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
