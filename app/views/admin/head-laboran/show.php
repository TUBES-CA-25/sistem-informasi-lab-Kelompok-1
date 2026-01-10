<?php $title = 'Detail Staff'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-5xl mx-auto">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <a href="<?= url('/admin/head-laboran') ?>" 
                   class="group inline-flex items-center gap-2 text-slate-500 hover:text-primary-600 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center shadow-sm group-hover:border-primary-200 transition-all">
                        <i class="bi bi-arrow-left text-sm"></i>
                    </div>
                    <span class="font-medium text-sm">Kembali ke Daftar</span>
                </a>
                
                <a href="<?= url('/admin/head-laboran/' . $staff['id'] . '/edit') ?>" 
                   class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-sm transition-all transform hover:-translate-y-0.5">
                    <i class="bi bi-pencil-square"></i>
                    <span>Edit Data</span>
                </a>
            </div>

            <?php displayFlash(); ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden relative">
                        <div class="h-24 bg-gradient-to-br from-primary-500 to-primary-700"></div>
                        
                        <div class="px-6 pb-8 text-center relative">
                            <div class="w-24 h-24 mx-auto -mt-12 rounded-full border-4 border-white bg-white shadow-md overflow-hidden relative z-10">
                                <?php if (!empty($staff['photo'])): ?>
                                    <img src="<?= e($staff['photo']) ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400 font-bold text-3xl">
                                        <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="mt-4">
                                <h2 class="text-xl font-bold text-slate-900"><?= e($user['name']) ?></h2>
                                <p class="text-primary-600 font-medium text-sm mt-1"><?= e($staff['position']) ?></p>
                                
                                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-center text-slate-500 text-sm gap-2">
                                    <i class="bi bi-envelope"></i>
                                    <span><?= e($user['email']) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h3 class="font-bold text-slate-800 flex items-center gap-2">
                                <i class="bi bi-activity text-primary-500"></i> Status Kehadiran
                            </h3>
                            <span class="text-xs text-slate-400">Real-time update</span>
                        </div>

                        <div class="p-6">
                            <div class="mb-6">
                                <?php if ($staff['status'] == 'active'): ?>
                                    <div class="flex items-center p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800">
                                        <div class="relative flex h-3 w-3 mr-4">
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-lg">Sedang Hadir / Standby</p>
                                            <p class="text-xs text-emerald-600 mt-0.5">Staff saat ini berada di lokasi dan siap bertugas.</p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="flex items-center p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-800">
                                        <div class="w-3 h-3 rounded-full bg-rose-500 mr-4"></div>
                                        <div>
                                            <p class="font-bold text-lg">Sedang Keluar / Tidak Aktif</p>
                                            <p class="text-xs text-rose-600 mt-0.5">Staff sedang tidak berada di tempat tugas.</p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                        <i class="bi bi-geo-alt-fill text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Lokasi Terkini</p>
                                        <p class="text-slate-800 font-medium mt-1"><?= e($staff['location']) ?></p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center shrink-0">
                                        <i class="bi bi-box-arrow-in-right text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Jam Masuk</p>
                                        <p class="text-slate-800 font-mono font-medium mt-1"><?= formatTime($staff['time_in']) ?></p>
                                    </div>
                                </div>

                                <?php if ($staff['status'] != 'active'): ?>
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                                        <i class="bi bi-clock-history text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Estimasi Kembali</p>
                                        <p class="text-rose-600 font-mono font-bold mt-1">
                                            <?= !empty($staff['return_time']) ? formatDate($staff['return_time']) : 'Belum ditentukan' ?>
                                        </p>
                                    </div>
                                </div>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-3 flex items-center gap-2">
                            <i class="bi bi-sticky"></i> Catatan Status
                        </p>
                        <div class="bg-amber-50 rounded-xl p-4 border border-amber-100 relative">
                            <i class="bi bi-quote absolute top-2 left-2 text-4xl text-amber-200 -z-0 opacity-50"></i>
                            <p class="text-slate-700 italic relative z-10 pl-4">
                                "<?= e($staff['notes'] ?? 'Tidak ada catatan khusus.') ?>"
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>
</div>