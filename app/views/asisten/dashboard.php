<?php $title = 'Dashboard Asisten'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen relative text-slate-800">
    
    <main class="p-4 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-4 rounded-2xl border border-slate-200 shadow-sm">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Dashboard Asisten</h1>
                    <p class="text-slate-500 text-sm mt-1">Pantau jadwal piket dan laporkan masalah laboratorium.</p>
                </div>

                <div class="flex items-center gap-3 pl-4 md:border-l md:border-slate-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-slate-700"><?= e($userName) ?></p>
                        <p class="text-xs text-slate-500">Asisten Laboratorium</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold border-2 border-white shadow-sm ring-2 ring-emerald-50">
                        <?= strtoupper(substr($userName, 0, 2)) ?>
                    </div>
                </div>
            </div>

            <div class="admin-content space-y-6">
                <?php displayFlash(); ?>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-amber-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-2 bg-amber-100 text-amber-600 rounded-lg">
                                    <i class="bi bi-exclamation-circle text-xl"></i>
                                </div>
                                <?php if (($statistics['my_pending'] ?? 0) > 0): ?>
                                    <span class="animate-pulse w-2 h-2 rounded-full bg-amber-500"></span>
                                <?php endif; ?>
                            </div>
                            <div class="stat-value text-3xl font-bold text-slate-800"><?= $statistics['my_pending'] ?? 0 ?></div>
                            <div class="stat-label text-slate-500 text-sm font-medium mt-1">Laporan Tertunda</div>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                                    <i class="bi bi-clipboard-data text-xl"></i>
                                </div>
                            </div>
                            <div class="stat-value text-3xl font-bold text-slate-800"><?= $statistics['my_reports'] ?? 0 ?></div>
                            <div class="stat-label text-slate-500 text-sm font-medium mt-1">Laporan Saya</div>
                        </div>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-sky-50 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
                        <div class="relative z-10">
                            <div class="flex justify-between items-start mb-4">
                                <div class="p-2 bg-sky-100 text-sky-600 rounded-lg">
                                    <i class="bi bi-calendar-check text-xl"></i>
                                </div>
                            </div>
                            <div class="stat-value text-3xl font-bold text-slate-800"><?= $statistics['my_schedules'] ?? 0 ?></div>
                            <div class="stat-label text-slate-500 text-sm font-medium mt-1">Jadwal Piket</div>
                        </div>
                    </div>

                    <a href="<?= url('/asisten/problems?tab=lapor') ?>" class="bg-gradient-to-br from-emerald-600 to-emerald-700 p-5 rounded-2xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 transition-all duration-300 flex flex-col justify-center items-center text-center group cursor-pointer border border-emerald-500">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center text-white mb-3 group-hover:scale-110 transition-transform">
                            <i class="bi bi-plus-circle-fill text-2xl"></i>
                        </div>
                        <h3 class="text-white font-bold text-lg">Lapor Masalah</h3>
                        <p class="text-emerald-100 text-xs mt-1">Laporkan kerusakan perangkat</p>
                    </a>
                </div>
                
                <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-white">
                        <div class="flex items-center gap-2">
                            <div class="w-1 h-6 bg-emerald-500 rounded-full"></div>
                            <h2 class="text-lg font-bold text-slate-800">Laporan Masalah Saya</h2>
                        </div>
                        <a href="<?= url('/asisten/problems?tab=saya') ?>" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium hover:underline flex items-center gap-1">
                            Lihat Semua <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <?php if (!empty($recentProblems)): ?>
                            <table class="w-full text-sm text-left text-slate-600">
                                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 font-semibold">Laboratory</th>
                                        <th scope="col" class="px-6 py-3 font-semibold">PC No.</th>
                                        <th scope="col" class="px-6 py-3 font-semibold">Type</th>
                                        <th scope="col" class="px-6 py-3 font-semibold">Status</th>
                                        <th scope="col" class="px-6 py-3 font-semibold">Reported By</th>
                                        <th scope="col" class="px-6 py-3 font-semibold">Date</th>
                                        <th scope="col" class="px-6 py-3 font-semibold text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    <?php foreach (array_slice($recentProblems, 0, 10) as $problem): ?>
                                        <tr class="hover:bg-slate-50/80 transition-colors duration-150">
                                            <td class="px-6 py-4 font-medium text-slate-900"><?= e($problem['lab_name']) ?></td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded border border-slate-200 bg-slate-50 text-slate-600 text-xs font-medium font-mono">
                                                    <?= e($problem['pc_number']) ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-slate-700"><?= getProblemTypeLabel($problem['problem_type']) ?></td>
                                            <td class="px-6 py-4">
                                                <?= getStatusBadge($problem['status']) ?>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-6 h-6 rounded-full bg-slate-100 flex items-center justify-center text-xs text-slate-500 font-bold border border-slate-200">
                                                        <?= substr($problem['reporter_name'], 0, 1) ?>
                                                    </div>
                                                    <span class="truncate max-w-[100px]"><?= e($problem['reporter_name']) ?></span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                                                <?= formatDateTime($problem['reported_at']) ?>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-slate-600 bg-slate-100 border border-transparent rounded-lg">
                                                    <?= getStatusBadge($problem['status']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="flex flex-col items-center justify-center py-16 text-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4 border border-slate-100">
                                    <i class="bi bi-clipboard-check text-3xl"></i>
                                </div>shield-check text-3xl"></i>
                                </div>
                                <p class="text-base font-medium text-slate-600">Belum ada laporan masalah</p>
                                <p class="text-sm text-slate-400 mt-1">Klik tombol "Lapor Masalah" untuk membuat lapor
                        <?php endif; ?>
                    </div>
                </div>
                
            </div>
        </div>
    </main>
</div>