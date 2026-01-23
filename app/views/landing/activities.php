<?php $title = 'Arsip Kegiatan Laboratorium'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen pb-20">

    <div class="bg-white border-b border-slate-200 pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <span
                class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider mb-4 border border-blue-100">
                Blog & Dokumentasi
            </span>
            <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 mb-4 tracking-tight">
                Kegiatan Laboratorium
            </h1>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed">
                Kumpulan berita, dokumentasi praktikum, dan agenda kegiatan di lingkungan Laboratorium FIKOM UMI.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 mt-12">

        <?php if (empty($activities)): ?>
        <div class="text-center py-20">
            <div
                class="inline-flex items-center justify-center w-20 h-20 bg-slate-100 rounded-full mb-4 text-slate-400">
                <i class="bi bi-journal-x text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-700">Belum ada kegiatan</h3>
            <p class="text-slate-500 mt-2">Belum ada dokumentasi kegiatan yang diupload.</p>
        </div>
        <?php else: ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($activities as $news): ?>
            <article
                class="flex flex-col bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group h-full">

                <a href="<?= url('/activity/' . $news['id']) ?>" class="relative h-56 overflow-hidden block">
                    <img src="<?= !empty($news['image_cover']) ? $news['image_cover'] : 'https://placehold.co/600x400/e2e8f0/94a3b8?text=No+Image' ?>"
                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                        alt="<?= e($news['title']) ?>">

                    <div class="absolute top-4 left-4">
                        <span
                            class="bg-blue-600/90 backdrop-blur text-white text-[10px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-wider shadow-sm">
                            <?= getActivityTypeLabel($news['activity_type']) ?>
                        </span>
                    </div>
                </a>

                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-center gap-2 text-xs text-slate-400 font-bold uppercase tracking-wide mb-3">
                        <i class="bi bi-calendar-event"></i>
                        <?= date('d F Y', strtotime($news['activity_date'])) ?>
                    </div>

                    <h3
                        class="text-xl font-bold text-slate-900 mb-3 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                        <a href="<?= url('/activity/' . $news['id']) ?>">
                            <?= e($news['title']) ?>
                        </a>
                    </h3>

                    <p class="text-slate-600 text-sm leading-relaxed mb-6 line-clamp-3 flex-1">
                        <?= e($news['description']) ?>
                    </p>

                    <div class="mt-auto pt-6 border-t border-slate-100 flex items-center justify-between">
                        <a href="<?= url('/activity/' . $news['id']) ?>"
                            class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">
                            Baca Selengkapnya
                            <i class="bi bi-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>

    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>