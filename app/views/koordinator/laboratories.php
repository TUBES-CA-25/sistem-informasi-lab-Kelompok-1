<?php $title = 'Data Laboratorium'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Data Laboratorium</h1>
                <p class="text-slate-500 mt-1">Informasi laboratorium yang tersedia.</p>
            </div>

            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200 flex items-center gap-3">
                <span class="text-sm font-medium text-slate-500">Total Lab:</span>
                <span class="text-lg font-bold text-sky-600"><?= count($laboratories ?? []) ?></span>
            </div>
        </div>

        <?php displayFlash(); ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (empty($laboratories)): ?>
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-pc-display text-4xl text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900">Tidak ada data laboratorium</h3>
                        <p class="text-slate-500">Belum ada laboratorium yang terdaftar.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($laboratories as $lab): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center">
                                    <i class="bi bi-pc-display text-sky-600 text-2xl"></i>
                                </div>
                            </div>
                            
                            <h3 class="text-lg font-bold text-slate-800 mb-2"><?= e($lab['lab_name']) ?></h3>
                            
                            <?php if (!empty($lab['description'])): ?>
                                <p class="text-sm text-slate-600 mb-4 line-clamp-2"><?= e($lab['description']) ?></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($lab['location'])): ?>
                                <div class="flex items-center gap-2 text-sm text-slate-500">
                                    <i class="bi bi-geo-alt"></i>
                                    <span><?= e($lab['location']) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="px-6 py-3 bg-slate-50 border-t border-slate-100">
                            <div class="flex items-center justify-between text-xs text-slate-500">
                                <span>Lab ID: #<?= $lab['id'] ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
