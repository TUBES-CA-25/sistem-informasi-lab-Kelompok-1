<?php $title = 'Manajemen Kegiatan'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Kegiatan & Berita</h1>
                    <p class="text-slate-500 text-sm mt-1">Kelola publikasi kegiatan laboratorium, berita, dan
                        pengumuman.</p>
                </div>

                <a href="<?= url('/admin/activities/create') ?>"
                    class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl shadow-lg shadow-primary-500/30 transition-all transform hover:-translate-y-0.5 focus:ring-4 focus:ring-primary-100">
                    <i class="bi bi-plus-lg text-lg"></i>
                    <span>Tambah Baru</span>
                </a>
            </div>

            <?php displayFlash(); ?>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden flex flex-col">

                <div class="overflow-x-auto w-full">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50/80 border-b border-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold w-[45%]">Informasi Kegiatan</th>
                                <th scope="col" class="px-6 py-4 font-semibold w-[20%]">Status & Kategori</th>
                                <th scope="col" class="px-6 py-4 font-semibold w-[20%]">Tautan & Tanggal</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right w-[15%]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($activities)): ?>
                            <?php foreach ($activities as $activity): ?>
                            <tr class="group hover:bg-slate-50/80 transition-colors duration-200">

                                <td class="px-6 py-4 align-top">
                                    <div class="flex gap-4">
                                        <div
                                            class="w-24 h-16 rounded-lg overflow-hidden bg-slate-100 shrink-0 border border-slate-200 relative group-hover:shadow-sm transition-all">
                                            <?php
                                                    // Logic Aman untuk Gambar
                                                    $imgSrc = 'https://placehold.co/600x400/e2e8f0/94a3b8?text=No+Img';
                                                    if (!empty($activity['image_cover'])) {
                                                        $imgSrc = (strpos($activity['image_cover'], 'http') === 0)
                                                            ? $activity['image_cover']
                                                            : BASE_URL . $activity['image_cover'];
                                                    }
                                                    ?>
                                            <img src="<?= e($imgSrc) ?>"
                                                class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <a href="<?= url('/admin/activities/' . $activity['id'] . '/edit') ?>"
                                                class="block font-bold text-slate-800 line-clamp-2 leading-snug mb-1.5 hover:text-primary-600 transition-colors">
                                                <?= e($activity['title']) ?>
                                            </a>
                                            <p class="text-xs text-slate-500 line-clamp-1">
                                                <?= e($activity['description'] ?? 'Tidak ada deskripsi singkat.') ?>
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <div class="flex flex-col gap-2 items-start">
                                        <?php
                                                $status = $activity['status'] ?? 'draft';
                                                $statusClasses = [
                                                    'published' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                    'draft'     => 'bg-slate-100 text-slate-600 border-slate-200',
                                                    'cancelled' => 'bg-rose-50 text-rose-700 border-rose-200'
                                                ];
                                                $statusLabel = [
                                                    'published' => 'Published',
                                                    'draft'     => 'Draft',
                                                    'cancelled' => 'Cancelled'
                                                ];
                                                $sClass = $statusClasses[$status] ?? $statusClasses['draft'];
                                                $sLabel = $statusLabel[$status] ?? 'Draft';
                                                ?>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider border <?= $sClass ?>">
                                            <span
                                                class="w-1.5 h-1.5 rounded-full mr-1.5 <?= str_replace(['bg-', 'text-', 'border-'], 'bg-', $sClass) ?> bg-current opacity-50"></span>
                                            <?= $sLabel ?>
                                        </span>

                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded text-[10px] font-medium bg-white text-slate-500 border border-slate-200 shadow-sm">
                                            <?= getActivityTypeLabel($activity['activity_type']) ?>
                                        </span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 align-top">
                                    <div class="flex flex-col gap-2">
                                        <div class="flex items-center gap-2 text-slate-600 text-xs font-medium">
                                            <i class="bi bi-calendar4-week text-slate-400"></i>
                                            <span><?= formatDate($activity['activity_date']) ?></span>
                                        </div>

                                        <?php
                                                $link = $activity['link_url'] ?? $activity['link'] ?? '#';
                                                $hasLink = ($link !== '#' && !empty($link));
                                                ?>
                                        <?php if ($hasLink): ?>
                                        <a href="<?= e($link) ?>" target="_blank"
                                            class="inline-flex items-center gap-1.5 text-xs text-primary-600 hover:text-primary-700 hover:underline w-fit">
                                            <i class="bi bi-link-45deg text-sm"></i>
                                            Lihat Tautan
                                        </a>
                                        <?php else: ?>
                                        <span class="text-xs text-slate-400 italic">Tanpa tautan</span>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right align-middle">
                                    <div class="flex items-center justify-end gap-2">

                                        <a href="<?= url('/admin/activities/' . $activity['id'] . '/edit') ?>"
                                            class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 bg-white border border-slate-200 hover:bg-primary-50 hover:text-primary-600 hover:border-primary-200 transition-all shadow-sm"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form method="POST"
                                            action="<?= url('/admin/activities/' . $activity['id'] . '/delete') ?>"
                                            onsubmit="return confirm('Apakah anda yakin ingin menghapus kegiatan ini?')"
                                            class="inline">
                                            <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-500 bg-white border border-slate-200 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 transition-all shadow-sm"
                                                title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4">
                                    <div class="flex flex-col items-center justify-center py-16 text-center">
                                        <div
                                            class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-3 border border-slate-100">
                                            <i class="bi bi-journal-x text-2xl"></i>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-900">Belum ada data</h3>
                                        <p class="text-xs text-slate-500 mt-1 mb-4">Silakan tambah kegiatan baru.</p>
                                        <a href="<?= url('/admin/activities/create') ?>"
                                            class="text-xs font-bold text-primary-600 hover:underline">
                                            + Buat Sekarang
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if (!empty($activities)): ?>
                <div class="border-t border-slate-100 px-6 py-4 bg-slate-50 flex justify-between items-center">
                    <span class="text-xs text-slate-500">Total: <strong><?= count($activities) ?></strong> item</span>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </main>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>