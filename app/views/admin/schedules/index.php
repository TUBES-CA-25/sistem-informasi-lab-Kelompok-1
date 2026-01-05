<?php $title = 'Manajemen Jadwal'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">

    <?php include APP_PATH . '/views/layouts/admin-sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-10">
        <div class="p-4 border-2 border-dashed border-slate-200 rounded-lg bg-white min-h-[80vh]">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Jadwal Praktikum</h1>
                    <p class="text-slate-500 text-sm">Kelola semua jadwal laboratorium semester ini.</p>
                </div>
                <a href="<?= url('/admin/schedules/create') ?>" class="text-white bg-sky-600 hover:bg-sky-700 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center shadow-lg shadow-sky-500/30">
                    <i class="bi bi-plus-lg mr-2"></i> Tambah Jadwal
                </a>
            </div>

            <?php displayFlash(); ?>

            <div class="relative overflow-x-auto sm:rounded-lg">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th style="width: 15%;">Waktu & Lab</th>
                            <th style="width: 25%;">Akademik (Matkul)</th>
                            <th style="width: 20%;">Dosen</th>
                            <th style="width: 25%;">Tim Asisten</th>
                            <th style="width: 15%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($schedules)): ?>
                            <?php foreach ($schedules as $schedule): ?>
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td style="vertical-align: top; padding: 1rem;">
                                        <div style="font-weight: bold; color: #0ea5e9;"><?= getDayName($schedule['day']) ?></div>
                                        <div style="font-size: 0.85rem; margin-bottom: 4px;">
                                            <?= formatTime($schedule['start_time']) ?> - <?= formatTime($schedule['end_time']) ?>
                                        </div>
                                        <div style="font-size: 0.8rem; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; display: inline-block;">
                                            <?= e($schedule['lab_name']) ?>
                                        </div>
                                    </td>

                                    <td style="vertical-align: top; padding: 1rem;">
                                        <div style="font-weight: bold; font-size: 1rem; margin-bottom: 2px;">
                                            <?= e($schedule['course']) ?>
                                        </div>
                                        <div style="font-size: 0.85rem; color: #64748b;">
                                            Kelas <?= e($schedule['class_code']) ?> • Smst <?= e($schedule['semester']) ?>
                                        </div>
                                        <div style="font-size: 0.8rem; color: #94a3b8; font-style: italic;">
                                            <?= e($schedule['program_study']) ?>
                                        </div>
                                    </td>

                                    <td style="vertical-align: top; padding: 1rem;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <?php if (!empty($schedule['lecturer_photo'])): ?>
                                                <img src="<?= e($schedule['lecturer_photo']) ?>" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                                            <?php else: ?>
                                                <div style="width: 30px; height: 30px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 10px;">DS</div>
                                            <?php endif; ?>
                                            <span style="font-size: 0.9rem;"><?= e($schedule['lecturer']) ?></span>
                                        </div>
                                    </td>

                                    <td style="vertical-align: top; padding: 1rem;">
                                        <div style="font-size: 0.85rem; margin-bottom: 4px;">
                                            <span style="color: #0ea5e9; font-weight: 500;">1.</span> <?= e($schedule['assistant']) ?>
                                        </div>
                                        <?php if (!empty($schedule['assistant_2'])): ?>
                                            <div style="font-size: 0.85rem;">
                                                <span style="color: #8b5cf6; font-weight: 500;">2.</span> <?= e($schedule['assistant_2']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="<?= url('/admin/schedules/' . $schedule['id']) ?>" class="font-medium text-sky-600 hover:underline bg-sky-50 px-2 py-1 rounded border border-sky-100" title="Lihat Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="<?= url('/admin/schedules/' . $schedule['id'] . '/edit') ?>" class="font-medium text-amber-600 hover:underline bg-amber-50 px-2 py-1 rounded border border-amber-100" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form method="POST" action="<?= url('/admin/schedules/' . $schedule['id'] . '/delete') ?>" onsubmit="return confirm('Hapus jadwal ini? Data tidak bisa dikembalikan.')" class="inline">
                                                <button type="submit" class="font-medium text-rose-600 hover:underline bg-rose-50 px-2 py-1 rounded border border-rose-100" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 3rem; color: #94a3b8;">
                                    <i class="bi bi-calendar-x" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                    Belum ada jadwal yang ditambahkan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
<?php include APP_PATH . '/views/layouts/footer.php'; ?>
    </main>
</div>
