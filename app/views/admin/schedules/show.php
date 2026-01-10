<?php $title = 'Detail Schedule'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-4xl mx-auto">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <a href="<?= url('/admin/schedules') ?>" 
                   class="group inline-flex items-center gap-2 text-slate-500 hover:text-primary-600 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center shadow-sm group-hover:border-primary-200 transition-all">
                        <i class="bi bi-arrow-left text-sm"></i>
                    </div>
                    <span class="font-medium text-sm">Kembali ke Daftar</span>
                </a>
                
                <a href="<?= url('/admin/schedules/' . $schedule['id'] . '/edit') ?>" 
                   class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-sm transition-all transform hover:-translate-y-0.5">
                    <i class="bi bi-pencil-square"></i>
                    <span>Edit Jadwal</span>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

                <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 px-8 py-8 border-b border-primary-100 relative overflow-hidden">
                    <i class="bi bi-journal-bookmark absolute -right-6 -bottom-6 text-[10rem] text-primary-200/30"></i>
                    
                    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="bg-white/80 backdrop-blur text-primary-700 text-xs font-bold px-2.5 py-1 rounded-md border border-primary-200 uppercase tracking-wider">
                                    <?= e($schedule['program_study']) ?>
                                </span>
                                <span class="bg-white/80 backdrop-blur text-slate-600 text-xs font-mono px-2.5 py-1 rounded-md border border-slate-200">
                                    Code: <?= e($schedule['frequency']) ?>
                                </span>
                            </div>
                            <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                                <?= e($schedule['course']) ?>
                            </h2>
                        </div>
                        
                        <div class="bg-white/60 backdrop-blur-sm p-4 rounded-xl border border-white/50 text-center min-w-[100px] shadow-sm">
                            <div class="text-3xl font-black text-primary-600"><?= e($schedule['class_code']) ?></div>
                            <div class="text-xs font-bold text-slate-500 uppercase tracking-wide">Kelas</div>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                        <div class="space-y-6">
                            <h3 class="flex items-center gap-2 font-bold text-slate-800 text-lg border-b border-slate-100 pb-3">
                                <i class="bi bi-clock-history text-primary-500"></i> Waktu & Tempat
                            </h3>

                            <div class="space-y-4">
                                <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="w-10 h-10 rounded-lg bg-white text-primary-600 flex items-center justify-center shadow-sm shrink-0">
                                        <i class="bi bi-calendar-event text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Hari Pelaksanaan</p>
                                        <p class="text-lg font-semibold text-slate-800 mt-0.5"><?= getDayName($schedule['day']) ?></p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="w-10 h-10 rounded-lg bg-white text-primary-600 flex items-center justify-center shadow-sm shrink-0">
                                        <i class="bi bi-alarm text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jam Praktikum</p>
                                        <p class="text-lg font-semibold text-slate-800 mt-0.5 font-mono">
                                            <?= formatTime($schedule['start_time']) ?> - <?= formatTime($schedule['end_time']) ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="w-10 h-10 rounded-lg bg-white text-primary-600 flex items-center justify-center shadow-sm shrink-0">
                                        <i class="bi bi-geo-alt-fill text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Laboratorium</p>
                                        <p class="text-lg font-semibold text-slate-800 mt-0.5"><?= e($schedule['lab_name']) ?></p>
                                        <p class="text-sm text-slate-500"><?= e($schedule['location']) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <h3 class="flex items-center gap-2 font-bold text-slate-800 text-lg border-b border-slate-100 pb-3">
                                <i class="bi bi-mortarboard text-violet-500"></i> Info Akademik
                            </h3>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-4 rounded-xl bg-violet-50/50 border border-violet-100">
                                    <p class="text-xs font-bold text-violet-400 uppercase tracking-wider">Semester</p>
                                    <p class="text-2xl font-bold text-violet-700 mt-1"><?= e($schedule['semester']) ?></p>
                                </div>
                                <div class="p-4 rounded-xl bg-blue-50/50 border border-blue-100">
                                    <p class="text-xs font-bold text-blue-400 uppercase tracking-wider">Mahasiswa</p>
                                    <p class="text-2xl font-bold text-blue-700 mt-1"><?= e($schedule['participant_count']) ?></p>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Deskripsi Mata Kuliah</p>
                                <div class="bg-white p-4 rounded-xl border border-slate-200 text-slate-600 text-sm leading-relaxed shadow-sm">
                                    <?= e($schedule['description'] ?? 'Tidak ada deskripsi tambahan untuk mata kuliah ini.') ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-10 pt-8 border-t border-slate-100">
                        <h3 class="flex items-center gap-2 font-bold text-slate-800 text-lg mb-6">
                            <i class="bi bi-people-fill text-slate-400"></i> Tim Pengajar
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                            
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-primary-200 transition-all text-center group">
                                <div class="w-20 h-20 mx-auto mb-4 rounded-full p-1 border-2 border-primary-100 group-hover:border-primary-300 transition-colors">
                                    <div class="w-full h-full rounded-full overflow-hidden bg-slate-100">
                                        <?php if (!empty($schedule['lecturer_photo'])): ?>
                                            <img src="<?= e($schedule['lecturer_photo']) ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-slate-300 text-2xl font-bold bg-slate-50">DS</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <h4 class="font-bold text-slate-900 text-sm mb-1"><?= e($schedule['lecturer']) ?></h4>
                                <span class="inline-block bg-primary-50 text-primary-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">Dosen Pengampu</span>
                            </div>

                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-200 transition-all text-center group">
                                <div class="w-20 h-20 mx-auto mb-4 rounded-full p-1 border-2 border-emerald-100 group-hover:border-emerald-300 transition-colors">
                                    <div class="w-full h-full rounded-full overflow-hidden bg-slate-100">
                                        <?php if (!empty($schedule['assistant_photo'])): ?>
                                            <img src="<?= e($schedule['assistant_photo']) ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-slate-300 text-2xl font-bold bg-slate-50">A1</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <h4 class="font-bold text-slate-900 text-sm mb-1"><?= e($schedule['assistant']) ?></h4>
                                <span class="inline-block bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">Asisten Utama</span>
                            </div>

                            <?php if (!empty($schedule['assistant_2'])): ?>
                            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-violet-200 transition-all text-center group">
                                <div class="w-20 h-20 mx-auto mb-4 rounded-full p-1 border-2 border-violet-100 group-hover:border-violet-300 transition-colors">
                                    <div class="w-full h-full rounded-full overflow-hidden bg-slate-100">
                                        <?php if (!empty($schedule['assistant2_photo'])): ?>
                                            <img src="<?= e($schedule['assistant2_photo']) ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-slate-300 text-2xl font-bold bg-slate-50">A2</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <h4 class="font-bold text-slate-900 text-sm mb-1"><?= e($schedule['assistant_2']) ?></h4>
                                <span class="inline-block bg-violet-50 text-violet-700 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wide">Asisten Pendamping</span>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </main>
</div>