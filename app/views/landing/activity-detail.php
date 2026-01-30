<?php
// --- PROTEKSI HALAMAN: Cek Status Published ---
$status = $activity['status'] ?? 'published';
if ($status !== 'published') {
    $title = 'Konten Tidak Tersedia';
    include APP_PATH . '/views/layouts/header.php';
    include APP_PATH . '/views/layouts/navbar.php';
?>
<div class="min-h-[60vh] flex flex-col items-center justify-center bg-slate-50 px-4 text-center">
    <div class="w-20 h-20 bg-slate-200 text-slate-400 rounded-full flex items-center justify-center mb-6">
        <i class="bi bi-eye-slash-fill text-4xl"></i>
    </div>
    <h1 class="text-2xl font-bold text-slate-800 mb-2">Konten Tidak Tersedia</h1>
    <p class="text-slate-500 max-w-md mb-8">Halaman yang Anda cari mungkin sedang disunting (draft), telah dihapus, atau tidak dipublikasikan untuk umum.</p>
    <a href="<?= url('/activities') ?>" class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30">
        Kembali ke Daftar Kegiatan
    </a>
</div>
<?php
    include APP_PATH . '/views/layouts/footer.php';
    exit;
}

// Jika Published, lanjut render halaman normal
$title = e($activity['title']);
?>

<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-white min-h-screen pb-20">

    <div class="bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 py-10">

            <div class="mb-6">
                <a href="<?= url('/activities') ?>" class="inline-flex items-center gap-2 text-slate-600 hover:text-blue-600 font-medium transition-colors group">
                    <i class="bi bi-arrow-left transition-transform group-hover:-translate-x-1"></i>
                    <span>Kembali ke Kegiatan</span>
                </a>
            </div>

            <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 leading-tight mb-6">
                <?= e($activity['title']) ?>
            </h1>

            <div class="flex flex-wrap items-center gap-3">
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide border border-blue-200">
                    <?= getActivityTypeLabel($activity['activity_type']) ?>
                </span>
                <span class="text-slate-500 text-sm font-medium flex items-center gap-1.5">
                    <i class="bi bi-calendar-event text-slate-400"></i>
                    <?= date('d F Y', strtotime($activity['activity_date'])) ?>
                </span>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-10">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 mb-16">

            <div class="lg:col-span-5">
                <div class="sticky top-24">
                    <?php
                        $imgSrc = !empty($activity['image_cover']) ? $activity['image_cover'] : 'https://placehold.co/800x600/e2e8f0/94a3b8?text=No+Image';
                        if (strpos($imgSrc, 'http') === false) $imgSrc = BASE_URL . $imgSrc;
                    ?>
                    <img src="<?= e($imgSrc) ?>" 
                         class="w-full h-auto rounded-2xl shadow-xl border border-slate-100 bg-slate-50" 
                         alt="<?= e($activity['title']) ?>">
                </div>
            </div>

            <div class="lg:col-span-7 flex flex-col">
                
                <div class="prose prose-lg prose-slate max-w-none text-slate-700 leading-relaxed">
                    <p class="whitespace-pre-line"><?= e($activity['description']) ?></p>
                </div>

                <?php
                $extLink = $activity['link_url'] ?? $activity['link'] ?? '';
                if (!empty($extLink) && $extLink != '#'):
                ?>
                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between gap-4">
                    <h4 class="font-bold text-slate-900 text-lg">Tautan Terkait</h4>
                    
                    <a href="<?= e($extLink) ?>" target="_blank" rel="noopener noreferrer"
                        class="shrink-0 px-6 py-2.5 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2 group text-sm">
                        Kunjungi Tautan <i class="bi bi-box-arrow-up-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <hr class="border-slate-200 mb-12">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <div class="lg:col-span-12">
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center text-blue-600 text-xl border border-slate-100">
                            <i class="bi bi-share-fill"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">Bagikan Artikel Ini</h3>
                            <p class="text-sm text-slate-500">Sebarkan informasi ini ke media sosial teman anda.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-3 w-full md:w-auto">
                        <button class="flex-1 md:flex-none py-2 px-4 rounded-lg bg-[#1877F2] text-white font-medium text-sm hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
                            <i class="bi bi-facebook"></i> <span class="hidden sm:inline">Facebook</span>
                        </button>
                        <button class="flex-1 md:flex-none py-2 px-4 rounded-lg bg-[#000000] text-white font-medium text-sm hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
                            <i class="bi bi-twitter-x"></i> <span class="hidden sm:inline">X</span>
                        </button>
                        <button class="flex-1 md:flex-none py-2 px-4 rounded-lg bg-[#25D366] text-white font-medium text-sm hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
                            <i class="bi bi-whatsapp"></i> <span class="hidden sm:inline">WhatsApp</span>
                        </button>
                        <button class="w-10 flex-none py-2 rounded-lg bg-white border border-slate-300 text-slate-600 hover:bg-slate-50 transition-colors flex items-center justify-center" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan disalin!')" title="Salin Link">
                            <i class="bi bi-link-45deg text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-12 mt-6">
                <h3 class="font-bold text-slate-900 text-xl mb-6 flex items-center gap-2 border-l-4 border-blue-500 pl-3">
                    Kegiatan Lainnya
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php if (!empty($related)): ?>
                        <?php
                            $countShown = 0;
                            foreach ($related as $item):
                                // Filter Status
                                if (($item['status'] ?? 'published') !== 'published') continue;
                                // Skip item yang sedang dibuka
                                if ($item['id'] == $activity['id']) continue;

                                if ($countShown >= 3) break;
                                $countShown++;
                        ?>
                        <a href="<?= url('/activity/' . $item['id']) ?>" class="group flex flex-col bg-white border border-slate-200 rounded-xl overflow-hidden hover:shadow-lg hover:border-blue-200 transition-all duration-300">
                            <div class="h-40 overflow-hidden relative bg-slate-100">
                                <?php
                                    $relImg = !empty($item['image_cover']) ? $item['image_cover'] : 'https://placehold.co/400x300/e2e8f0/94a3b8?text=Img';
                                    if (strpos($relImg, 'http') === false) $relImg = BASE_URL . $relImg;
                                ?>
                                <img src="<?= e($relImg) ?>" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                <div class="absolute top-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider text-blue-700 shadow-sm">
                                    <?= getActivityTypeLabel($item['activity_type']) ?>
                                </div>
                            </div>
                            
                            <div class="p-4 flex flex-col flex-1">
                                <div class="text-[10px] text-slate-400 font-bold mb-1 uppercase">
                                    <?= date('d M Y', strtotime($item['activity_date'])) ?>
                                </div>
                                <h4 class="font-bold text-slate-800 text-sm leading-snug group-hover:text-blue-600 transition-colors line-clamp-2 mb-2">
                                    <?= e($item['title']) ?>
                                </h4>
                                <span class="text-xs text-blue-600 font-medium mt-auto flex items-center gap-1 group-hover:gap-2 transition-all">
                                    Baca Detail <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </a>
                        <?php endforeach; ?>

                        <?php if ($countShown == 0): ?>
                        <div class="col-span-3 text-center py-8 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-slate-400">
                            Tidak ada kegiatan lain saat ini.
                        </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class="col-span-3 text-center py-8 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-slate-400">
                            Tidak ada kegiatan lain.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>