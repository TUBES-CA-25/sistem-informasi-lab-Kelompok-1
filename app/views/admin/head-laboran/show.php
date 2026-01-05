<?php $title = 'Detail Staff'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-10">
        <div class="max-w-2xl mx-auto">

            <div class="flex justify-between items-center mb-6">
                <a href="<?= url('/admin/head-laboran') ?>" class="text-slate-500 hover:text-sky-600 flex items-center gap-2">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <div class="flex gap-2">
                    <a href="<?= url('/admin/head-laboran/' . $staff['id'] . '/edit') ?>" class="text-white bg-amber-500 hover:bg-amber-600 font-medium rounded-lg text-sm px-4 py-2">
                        <i class="bi bi-pencil-square mr-1"></i> Edit
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200">
                <div class="h-32 bg-gradient-to-r from-sky-500 to-blue-600"></div>

                <div class="px-8 pb-8">
                    <div class="-mt-16 mb-6">
                        <div class="w-32 h-32 rounded-full border-4 border-white bg-white shadow-md overflow-hidden mx-auto md:mx-0">
                            <?php if (!empty($staff['photo'])): ?>
                                <img src="<?= e($staff['photo']) ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-slate-200 text-slate-400 font-bold text-4xl">
                                    <?= strtoupper(substr($user['name'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="text-center md:text-left mb-6">
                        <h1 class="text-3xl font-bold text-slate-900"><?= e($user['name']) ?></h1>
                        <p class="text-sky-600 font-medium text-lg mb-2"><?= e($staff['position']) ?></p>
                        <div class="inline-flex items-center text-slate-500 text-sm">
                            <i class="bi bi-envelope mr-2"></i> <?= e($user['email']) ?>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-6 border border-slate-100">
                        <h3 class="font-bold text-slate-800 mb-4 border-b pb-2">Status Saat Ini</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <span class="block text-xs text-slate-400 mb-1">Kondisi</span>
                                <?php if ($staff['status'] == 'active'): ?>
                                    <span class="inline-flex items-center bg-emerald-100 text-emerald-800 text-sm font-bold px-3 py-1 rounded-full">
                                        Active / Hadir
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center bg-rose-100 text-rose-800 text-sm font-bold px-3 py-1 rounded-full">
                                        Inactive / Keluar
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div>
                                <span class="block text-xs text-slate-400 mb-1">Lokasi Terkini</span>
                                <div class="flex items-center font-medium text-slate-700">
                                    <i class="bi bi-geo-alt text-sky-500 mr-2"></i>
                                    <?= e($staff['location']) ?>
                                </div>
                            </div>

                            <div>
                                <span class="block text-xs text-slate-400 mb-1">Jam Masuk</span>
                                <div class="font-mono text-slate-700">
                                    <?= formatTime($staff['time_in']) ?>
                                </div>
                            </div>

                            <?php if ($staff['status'] != 'active'): ?>
                                <div>
                                    <span class="block text-xs text-slate-400 mb-1">Estimasi Kembali</span>
                                    <div class="font-mono text-rose-600 font-bold">
                                        <?= !empty($staff['return_time']) ? formatDate($staff['return_time']) : '-' ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mt-6">
                            <span class="block text-xs text-slate-400 mb-1">Catatan Status</span>
                            <div class="bg-white p-3 rounded border border-slate-200 text-slate-600 italic">
                                "<?= e($staff['notes'] ?? '-') ?>"
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        
        <?php include APP_PATH . '/views/layouts/footer.php'; ?>
    </main>
</div>