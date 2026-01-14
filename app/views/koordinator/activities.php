<?php $title = 'Kegiatan Laboratorium'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800">Kegiatan Laboratorium</h1>
                <p class="text-slate-500 mt-1">Daftar kegiatan dan aktivitas laboratorium.</p>
            </div>

            <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200 flex items-center gap-3">
                <span class="text-sm font-medium text-slate-500">Total Kegiatan:</span>
                <span class="text-lg font-bold text-sky-600"><?= count($activities ?? []) ?></span>
            </div>
        </div>

        <?php displayFlash(); ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <?php if (empty($activities)): ?>
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-12 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="bi bi-calendar-event text-4xl text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-medium text-slate-900">Tidak ada kegiatan</h3>
                        <p class="text-slate-500">Belum ada kegiatan yang terdaftar.</p>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($activities as $activity): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <?php
                                        $typeColors = [
                                            'praktikum' => 'bg-sky-50 text-sky-700 border-sky-200',
                                            'workshop' => 'bg-purple-50 text-purple-700 border-purple-200',
                                            'seminar' => 'bg-amber-50 text-amber-700 border-amber-200',
                                            'maintenance' => 'bg-rose-50 text-rose-700 border-rose-200',
                                            'other' => 'bg-slate-50 text-slate-700 border-slate-200'
                                        ];
                                        $typeColor = $typeColors[$activity['activity_type']] ?? $typeColors['other'];
                                    ?>
                                    <span class="px-3 py-1 text-xs font-bold rounded-lg border <?= $typeColor ?>">
                                        <?= ucfirst($activity['activity_type']) ?>
                                    </span>
                                </div>
                                
                                <?php
                                    $statusColors = [
                                        'draft' => 'bg-slate-50 text-slate-700 border-slate-200',
                                        'published' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200'
                                    ];
                                    $statusColor = $statusColors[$activity['status']] ?? $statusColors['draft'];
                                ?>
                                <span class="px-3 py-1 text-xs font-bold rounded-lg border <?= $statusColor ?>">
                                    <?= ucfirst($activity['status']) ?>
                                </span>
                            </div>
                            
                            <h3 class="text-lg font-bold text-slate-800 mb-3"><?= e($activity['title']) ?></h3>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-sm text-slate-600">
                                    <i class="bi bi-calendar3 text-slate-400"></i>
                                    <span><?= date('d M Y', strtotime($activity['activity_date'])) ?></span>
                                </div>
                                
                                <?php if (!empty($activity['location'])): ?>
                                    <div class="flex items-center gap-2 text-sm text-slate-600">
                                        <i class="bi bi-geo-alt text-slate-400"></i>
                                        <span><?= e($activity['location']) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php if (!empty($activity['description'])): ?>
                                <p class="text-sm text-slate-600 line-clamp-3"><?= e($activity['description']) ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="px-6 py-3 bg-slate-50 border-t border-slate-100">
                            <div class="flex items-center justify-between text-xs text-slate-500">
                                <span>Created: <?= date('d M Y', strtotime($activity['created_at'])) ?></span>
                                <span>ID: #<?= $activity['id'] ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>
