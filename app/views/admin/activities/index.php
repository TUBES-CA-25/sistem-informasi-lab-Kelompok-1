<?php $title = 'Manajemen Kegiatan'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>

<div class="antialiased bg-slate-50 min-h-screen">
    <?php include APP_PATH . '/views/layouts/sidebar.php'; ?>

    <main class="p-4 sm:ml-64 pt-8 transition-all duration-300">
        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Kegiatan & Berita</h1>
                    <p class="text-slate-500 text-sm mt-1">Kelola publikasi kegiatan laboratorium dan berita terkini.</p>
                </div>
                
                <a href="<?= url('/admin/activities/create') ?>" 
                   class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium px-5 py-2.5 rounded-xl shadow-lg shadow-primary-500/30 transition-all transform hover:-translate-y-0.5 focus:ring-4 focus:ring-primary-100">
                    <i class="bi bi-plus-lg text-lg"></i>
                    <span>Tambah Kegiatan</span>
                </a>
            </div>

            <?php displayFlash(); ?>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden min-h-[600px] flex flex-col">
                
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-sm text-left text-slate-600">
                        <thead class="text-xs text-slate-500 uppercase bg-slate-50/80 border-b border-slate-100">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold w-[40%]">Cover & Informasi</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Tautan</th>
                                <th scope="col" class="px-6 py-4 font-semibold">Tanggal Posting</th>
                                <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($activities)): ?>
                                <?php foreach ($activities as $activity): ?>
                                    <tr class="group hover:bg-slate-50/80 transition-colors duration-200">
                                        
                                        <td class="px-6 py-4">
                                            <div class="flex items-start gap-4">
                                                <div class="w-20 h-14 rounded-lg overflow-hidden bg-slate-100 shrink-0 border border-slate-200 relative group-hover:shadow-sm transition-all">
                                                    <?php if (!empty($activity['image_cover'])): ?>
                                                        <img src="<?= e($activity['image_cover']) ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                                    <?php else: ?>
                                                        <div class="w-full h-full flex items-center justify-center text-slate-400">
                                                            <i class="bi bi-image text-xl"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <div class="flex-1 min-w-0">
                                                    <div class="font-bold text-slate-800 line-clamp-2 leading-snug mb-1.5">
                                                        <?= e($activity['title']) ?>
                                                    </div>
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-primary-50 text-primary-700 border border-primary-100/50">
                                                        <?= e($activity['activity_type']) ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <a href="<?= e($activity['link_url']) ?>" target="_blank" 
                                               class="group/link flex items-center gap-2 max-w-[200px] text-slate-500 hover:text-primary-600 transition-colors p-1.5 rounded-lg hover:bg-white">
                                                <div class="w-8 h-8 rounded bg-slate-100 flex items-center justify-center text-slate-500 group-hover/link:bg-primary-50 group-hover/link:text-primary-600 transition-colors shrink-0">
                                                    <i class="bi bi-link-45deg text-lg"></i>
                                                </div>
                                                <span class="truncate text-xs font-mono"><?= e($activity['link_url']) ?></span>
                                            </a>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2 text-slate-500">
                                                <i class="bi bi-calendar4-week text-slate-400"></i>
                                                <span><?= formatDate($activity['activity_date']) ?></span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-200">
                                                
                                                <a href="<?= url('/admin/activities/' . $activity['id'] . '/edit') ?>" 
                                                   class="w-9 h-9 flex items-center justify-center rounded-full text-amber-600 bg-amber-50 hover:bg-amber-100 hover:scale-105 hover:shadow-sm transition-all border border-transparent hover:border-amber-200" 
                                                   title="Edit Data">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>

                                                <form method="POST" action="<?= url('/admin/activities/' . $activity['id'] . '/delete') ?>" onsubmit="return confirm('Apakah anda yakin ingin menghapus kegiatan ini? Tindakan ini tidak dapat dibatalkan.')" class="inline">
                                                    <button type="submit" 
                                                            class="w-9 h-9 flex items-center justify-center rounded-full text-rose-600 bg-rose-50 hover:bg-rose-100 hover:scale-105 hover:shadow-sm transition-all border border-transparent hover:border-rose-200" 
                                                            title="Hapus Data">
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
                                        <div class="flex flex-col items-center justify-center py-20 text-center">
                                            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center text-slate-300 mb-4 animate-pulse">
                                                <i class="bi bi-postcard text-4xl"></i>
                                            </div>
                                            <h3 class="text-lg font-semibold text-slate-900">Belum ada kegiatan</h3>
                                            <p class="text-slate-500 max-w-sm mt-1 mb-6">Mulai tambahkan kegiatan atau berita untuk menampilkannya di halaman depan website.</p>
                                            <a href="<?= url('/admin/activities/create') ?>" class="text-primary-600 hover:text-primary-700 font-medium hover:underline">
                                                + Tambah Kegiatan Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if (!empty($activities) && count($activities) > 10): ?>
                <div class="border-t border-slate-100 px-6 py-4 bg-slate-50">
                    <span class="text-xs text-slate-500">Menampilkan semua data</span>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </main>
</div>