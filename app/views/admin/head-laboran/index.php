<?php $title = 'Manajemen Staff & Presence'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-10">
        <div class="p-4 border-2 border-dashed border-slate-200 rounded-lg bg-white min-h-[80vh]">

            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Manajemen Presence</h1>
                    <p class="text-slate-500 text-sm">Kelola Staff, Kepala Lab, dan Status Kehadiran.</p>
                </div>
                <a href="<?= url('/admin/head-laboran/create') ?>" class="text-white bg-sky-600 hover:bg-sky-700 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center shadow-lg shadow-sky-500/30">
                    <i class="bi bi-person-plus-fill mr-2"></i> Tambah Staff
                </a>
            </div>

            <?php displayFlash(); ?>

            <div class="relative overflow-x-auto sm:rounded-lg">
                <table class="w-full text-sm text-left text-slate-500">
                    <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b">
                        <tr>
                            <th class="px-6 py-3">Nama & Jabatan</th>
                            <th class="px-6 py-3">Status Kehadiran</th>
                            <th class="px-6 py-3">Lokasi / Keterangan</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (!empty($headLaboran)): ?>
                            <?php foreach ($headLaboran as $hl): ?>
                                <tr class="bg-white hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-slate-200 flex items-center justify-center overflow-hidden border border-slate-300 text-slate-500 font-bold">
                                            <?php if (!empty($hl['photo'])): ?>
                                                <img src="<?= e($hl['photo']) ?>" class="w-full h-full object-cover">
                                            <?php else: ?>
                                                <?= strtoupper(substr($hl['name'], 0, 1)) ?>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-800"><?= e($hl['name']) ?></div>
                                            <div class="text-xs text-sky-600 font-medium bg-sky-50 px-2 py-0.5 rounded inline-block mt-1">
                                                <?= e($hl['position']) ?>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <?php if ($hl['status'] == 'active'): ?>
                                            <span class="inline-flex items-center bg-emerald-100 text-emerald-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                <span class="w-2 h-2 me-1 bg-emerald-500 rounded-full"></span>
                                                Active / Hadir
                                            </span>
                                            <div class="text-xs text-slate-500 mt-1 pl-2">
                                                Masuk: <?= formatTime($hl['time_in']) ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="inline-flex items-center bg-rose-100 text-rose-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                <span class="w-2 h-2 me-1 bg-rose-500 rounded-full"></span>
                                                Inactive / Keluar
                                            </span>
                                            <div class="text-xs text-rose-500 mt-1 pl-2">
                                                Kembali: <?= !empty($hl['return_time']) ? formatDate($hl['return_time']) : 'Unknown' ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center text-slate-700 mb-1">
                                            <i class="bi bi-geo-alt-fill text-slate-400 mr-2"></i>
                                            <?= e($hl['location']) ?>
                                        </div>
                                        <div class="text-xs text-slate-400 italic">
                                            "<?= substr(e($hl['notes']), 0, 30) ?>..."
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <a href="<?= url('/admin/head-laboran/' . $hl['id']) ?>" class="p-2 text-sky-600 bg-sky-50 rounded hover:bg-sky-100" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= url('/admin/head-laboran/' . $hl['id'] . '/edit') ?>" class="p-2 text-amber-600 bg-amber-50 rounded hover:bg-amber-100" title="Edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form method="POST" action="<?= url('/admin/head-laboran/' . $hl['id'] . '/delete') ?>" onsubmit="return confirm('Hapus staff ini?')" class="inline">
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
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400 bg-slate-50 rounded-lg border border-dashed border-slate-200">
                                    <i class="bi bi-people text-4xl mb-2 block"></i>
                                    Belum ada data staff.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>