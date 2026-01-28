<?php $title = 'Arsip Kegiatan Laboratorium'; ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-slate-50 min-h-screen pb-20">

    <div class="relative bg-white border-b border-slate-200 pt-20 pb-16 overflow-hidden">
        <div
            class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob">
        </div>
        <div
            class="absolute top-0 left-0 -ml-20 -mt-20 w-72 h-72 bg-purple-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000">
        </div>

        <div class="relative max-w-7xl mx-auto px-4 text-center z-10">
            <span
                class="inline-flex items-center gap-2 py-1 px-3 rounded-full bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider mb-6 border border-blue-100 shadow-sm">
                <i class="bi bi-journal-bookmark-fill"></i> Blog & Dokumentasi
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-6 tracking-tight leading-tight">
                Kegiatan Laboratorium
            </h1>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto leading-relaxed">
                Informasi terkini, berita acara, dan dokumentasi kegiatan praktikum di lingkungan Laboratorium FIKOM
                UMI.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 mt-16">

        <?php if (empty($activities)): ?>
        <div class="text-center py-24">
            <div
                class="inline-flex items-center justify-center w-24 h-24 bg-slate-100 rounded-full mb-6 text-slate-400">
                <i class="bi bi-journal-x text-4xl"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-700">Belum ada kegiatan</h3>
            <p class="text-slate-500 mt-2 max-w-md mx-auto">Saat ini belum ada dokumentasi kegiatan yang dipublikasikan.
                Silakan cek kembali nanti.</p>
        </div>
        <?php else: ?>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($activities as $news): ?>
            <?php
                    // --- LOGIKA FILTER: Hanya Tampilkan yang PUBLISHED ---
                    $status = $news['status'] ?? 'published'; // Default published untuk data lama
                    if ($status !== 'published') continue;
                    ?>

            <article
                class="flex flex-col bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group h-full">

                <a href="<?= url('/activity/' . $news['id']) ?>" class="relative h-56 overflow-hidden block">
                    <?php
                            $imgSrc = !empty($news['image_cover']) ? $news['image_cover'] : 'https://placehold.co/600x400/e2e8f0/94a3b8?text=No+Image';
                            // Fix URL jika perlu
                            if (strpos($imgSrc, 'http') === false) $imgSrc = BASE_URL . $imgSrc;
                            ?>
                    <img src="<?= e($imgSrc) ?>"
                        class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700"
                        alt="<?= e($news['title']) ?>" loading="lazy">

                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60"></div>

                    <div class="absolute top-4 left-4 flex gap-2">
                        <span
                            class="bg-white/90 backdrop-blur-md text-blue-700 text-[10px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-wider shadow-sm border border-white/50">
                            <?= getActivityTypeLabel($news['activity_type']) ?>
                        </span>
                    </div>
                </a>

                <div class="p-6 flex flex-col flex-1 relative">
                    <div
                        class="absolute -top-5 right-6 bg-blue-600 text-white text-xs font-bold px-3 py-2 rounded-lg shadow-lg flex flex-col items-center border-2 border-white">
                        <span class="text-lg leading-none"><?= date('d', strtotime($news['activity_date'])) ?></span>
                        <span class="uppercase text-[10px]"><?= date('M', strtotime($news['activity_date'])) ?></span>
                    </div>

                    <div class="mt-2 mb-3">
                        <h3
                            class="text-xl font-bold text-slate-900 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                            <a href="<?= url('/activity/' . $news['id']) ?>">
                                <?= e($news['title']) ?>
                            </a>
                        </h3>
                    </div>

                    <p class="text-slate-600 text-sm leading-relaxed mb-6 line-clamp-3 flex-1">
                        <?= e($news['description']) ?>
                    </p>

                    <div class="pt-6 border-t border-slate-100 flex items-center justify-between mt-auto">
                        <span class="text-xs text-slate-400 font-medium flex items-center gap-1">
                            <i class="bi bi-clock"></i> <?= date('Y', strtotime($news['activity_date'])) ?>
                        </span>

                        <a href="<?= url('/activity/' . $news['id']) ?>"
                            class="inline-flex items-center text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors group/btn">
                            Baca Selengkapnya
                            <i
                                class="bi bi-arrow-right ml-2 transform group-hover/btn:translate-x-1 transition-transform"></i>
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