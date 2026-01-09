<?php $title = 'Manajemen Kegiatan'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-10">
        <div class="p-4 border-2 border-dashed border-slate-200 rounded-lg bg-white min-h-[80vh]">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Kegiatan & Berita</h1>
                    <p class="text-slate-500 text-sm">Kelola informasi yang tampil di halaman depan.</p>
                </div>
                <a href="<?= url('/admin/activities/create') ?>" class="text-white bg-sky-600 hover:bg-sky-700 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center shadow-lg shadow-sky-500/30">
                    <i class="bi bi-plus-lg mr-2"></i> Tambah Kegiatan
                </a>
            </div>

            <?php displayFlash(); ?>

            <div class="relative overflow-x-auto sm:rounded-lg">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b">
                        <tr>
                            <th class="px-6 py-3">Cover & Judul</th>
                            <th class="px-6 py-3">Link Tujuan</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (!empty($activities)): ?>
                            <?php foreach ($activities as $activity): ?>
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 flex items-center gap-4">
                                        <div class="w-16 h-10 rounded overflow-hidden bg-slate-200 shrink-0 border border-slate-200">
                                            <?php if (!empty($activity['image_cover'])): ?>
                                                <img src="<?= e($activity['image_cover']) ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <div class="w-full h-full flex items-center justify-center text-slate-400"><i class="bi bi-image"></i></div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800 line-clamp-1"><?= e($activity['title']) ?></div>
                                            <span class="text-xs bg-slate-100 px-2 py-0.5 rounded text-slate-500 uppercase tracking-wide">
                                                <?= e($activity['activity_type']) ?>
                                            </span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <a href="<?= e($activity['link_url']) ?>" target="_blank" class="text-sky-600 hover:underline flex items-center gap-1 max-w-[200px] truncate">
                                            <i class="bi bi-box-arrow-up-right text-xs"></i>
                                            <?= e($activity['link_url']) ?>
                                        </a>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?= formatDate($activity['activity_date']) ?>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="<?= url('/admin/activities/' . $activity['id'] . '/edit') ?>" class="p-2 text-amber-600 bg-amber-50 rounded hover:bg-amber-100" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form method="POST" action="<?= url('/admin/activities/' . $activity['id'] . '/delete') ?>" onsubmit="return confirm('Hapus kegiatan ini?')" class="inline">
                                                <button type="submit" class="p-2 text-rose-600 bg-rose-50 rounded hover:bg-rose-100" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400">Belum ada kegiatan yang diposting.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>