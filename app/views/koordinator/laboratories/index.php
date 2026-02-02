<?php $title = 'Manajemen Laboratorium'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Laboratorium</h1>
                <p class="text-slate-500 mt-2 text-lg">Kelola profil dan fasilitas laboratorium.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <form action="" method="GET" class="relative w-full md:w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                    </div>
                </form>

                <a href="<?= url('/koordinator/laboratories/create') ?>"
                    class="inline-flex items-center justify-center gap-2 px-5 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-primary-500/30 transition-all hover:-translate-y-0.5">
                    <i class="bi bi-plus-lg text-lg"></i>
                    <span>Tambah</span>
                </a>
            </div>
        </div>

        <?php displayFlash(); ?>

        <?php if (!empty($laboratories)): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($laboratories as $lab): ?>
            <div
                class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col overflow-hidden">

                <div class="h-48 relative overflow-hidden bg-slate-100">
                    <?php
                            $labPhoto = !empty($lab['image']) ? $lab['image'] : (!empty($lab['image_path']) ? $lab['image_path'] : null);
                            ?>

                    <?php if ($labPhoto): ?>
                    <img src="<?= $labPhoto ?>" alt="<?= htmlspecialchars($lab['lab_name']) ?>"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-80">
                    </div>
                    <?php else: ?>
                    <div
                        class="w-full h-full bg-gradient-to-br from-primary-600 to-primary-800 flex items-center justify-center relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full blur-2xl -mr-10 -mt-10">
                        </div>
                        <i class="bi bi-pc-display text-5xl text-white/20"></i>
                    </div>
                    <?php endif; ?>

                    <div class="absolute top-4 left-4 z-10">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-white/95 backdrop-blur text-slate-700 shadow-sm">
                            <i class="bi bi-geo-alt-fill text-primary-600"></i>
                            <?= htmlspecialchars($lab['location'] ?? '-') ?>
                        </span>
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <div class="mb-4">
                        <h3
                            class="text-xl font-bold text-slate-900 mb-2 group-hover:text-primary-600 transition-colors">
                            <?= htmlspecialchars($lab['lab_name']) ?>
                        </h3>
                        <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed h-10">
                            <?= htmlspecialchars($lab['description'] ?? 'Belum ada deskripsi.') ?>
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div
                            class="bg-slate-50 p-2.5 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center">
                            <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">PC
                                Unit</span>
                            <span class="text-sm font-bold text-slate-700 flex items-center gap-1.5">
                                <i class="bi bi-pc-display text-primary-500"></i>
                                <?= $lab['pc_count'] ?? 0 ?>
                            </span>
                        </div>
                        <div
                            class="bg-slate-50 p-2.5 rounded-xl border border-slate-100 flex flex-col items-center justify-center text-center">
                            <span
                                class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Display</span>
                            <span class="text-sm font-bold text-slate-700 flex items-center gap-1.5">
                                <i class="bi bi-tv text-primary-500"></i>
                                <?= $lab['tv_count'] ?? 0 ?>
                            </span>
                        </div>
                    </div>

                    <div class="mt-auto grid grid-cols-2 gap-3">
                        <a href="<?= url('/koordinator/laboratories/' . $lab['id'] . '/edit') ?>"
                            class="inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-600 hover:border-primary-500 hover:text-primary-600 transition-all">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>

                        <form action="<?= url('/koordinator/laboratories/' . $lab['id'] . '/delete') ?>" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus laboratorium ini? Data tidak bisa dikembalikan.');"
                            class="w-full">
                            <button type="submit"
                                class="w-full inline-flex justify-center items-center gap-2 px-4 py-2.5 bg-red-50 border border-red-100 text-red-600 rounded-xl text-sm font-bold hover:bg-red-600 hover:text-white hover:border-red-600 transition-all shadow-sm">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php else: ?>
        <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 border-dashed">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="bi bi-building-slash text-4xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900">Belum ada laboratorium</h3>
            <p class="text-slate-500 mt-2">Data laboratorium belum ditambahkan ke sistem.</p>
            <div class="mt-6">
                <a href="<?= url('/koordinator/laboratories/create') ?>"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-lg transition-all">
                    <i class="bi bi-plus-lg"></i> Tambah Sekarang
                </a>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>