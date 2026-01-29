<?php
// --- PROTEKSI HALAMAN: Cek Status Published ---
// Jika status draft/cancelled, jangan tampilkan detailnya
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
    <p class="text-slate-500 max-w-md mb-8">Halaman yang Anda cari mungkin sedang disunting (draft), telah dihapus, atau
        tidak dipublikasikan untuk umum.</p>
    <a href="<?= url('/activities') ?>"
        class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30">
        Kembali ke Daftar Kegiatan
    </a>
</div>
<?php
    include APP_PATH . '/views/layouts/footer.php';
    exit; // Hentikan script di sini
}

// Jika Published, lanjut render halaman normal
$title = e($activity['title']);
?>

<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-white min-h-screen pb-20">

    <div class="bg-slate-50 border-b border-slate-200">
        <div class="max-w-5xl mx-auto px-4 py-10">

            <!-- Back Button -->
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
                <span
                    class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide border border-blue-200">
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
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            <div class="lg:col-span-8">

                <div class="rounded-2xl overflow-hidden shadow-xl mb-10 border border-slate-100 bg-slate-100">
                    <?php
                    $imgSrc = !empty($activity['image_cover']) ? $activity['image_cover'] : 'https://placehold.co/800x500/e2e8f0/94a3b8?text=No+Image';
                    if (strpos($imgSrc, 'http') === false) $imgSrc = BASE_URL . $imgSrc;
                    ?>
                    <img src="<?= e($imgSrc) ?>" class="w-full h-auto object-cover max-h-[500px]"
                        alt="<?= e($activity['title']) ?>">
                </div>

                <div class="prose prose-lg prose-slate max-w-none text-slate-700 leading-relaxed">
                    <p class="whitespace-pre-line"><?= e($activity['description']) ?></p>
                </div>

                <?php
                $extLink = $activity['link_url'] ?? $activity['link'] ?? '';
                if (!empty($extLink) && $extLink != '#'):
                ?>
                <div
                    class="mt-12 p-6 bg-slate-50 rounded-2xl border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-6 hover:border-blue-200 transition-colors">
                    <div>
                        <h4 class="font-bold text-slate-900 text-lg mb-1">Tautan Terkait</h4>
                        <p class="text-sm text-slate-500">Baca informasi selengkapnya atau kunjungi sumber asli artikel
                            ini.</p>
                    </div>
                    <a href="<?= e($extLink) ?>" target="_blank" rel="noopener noreferrer"
                        class="shrink-0 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-500/30 flex items-center gap-2 group">
                        Kunjungi Tautan <i
                            class="bi bi-box-arrow-up-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <div class="lg:col-span-4 space-y-8">

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm sticky top-24">
                    <h3
                        class="font-bold text-slate-800 mb-4 uppercase text-xs tracking-wider border-b border-slate-100 pb-2">
                        Bagikan Artikel</h3>
                    <div class="flex gap-2">
                        <button
                            class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all transform hover:scale-110"
                            title="Facebook"><i class="bi bi-facebook"></i></button>
                        <button
                            class="w-10 h-10 rounded-full bg-slate-900 text-white flex items-center justify-center hover:bg-slate-700 transition-all transform hover:scale-110"
                            title="X (Twitter)"><i class="bi bi-twitter-x"></i></button>
                        <button
                            class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition-all transform hover:scale-110"
                            title="WhatsApp"><i class="bi bi-whatsapp"></i></button>
                        <button
                            class="w-10 h-10 rounded-full bg-slate-50 text-slate-600 flex items-center justify-center hover:bg-slate-600 hover:text-white transition-all transform hover:scale-110"
                            onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan disalin!')"
                            title="Salin Link"><i class="bi bi-link-45deg"></i></button>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-slate-900 text-lg mb-6 flex items-center gap-2">
                        <i class="bi bi-collection-play text-blue-500"></i> Kegiatan Lainnya
                    </h3>

                    <div class="space-y-5">
                        <?php if (!empty($related)): ?>
                        <?php
                            $countShown = 0;
                            foreach ($related as $item):
                                // --- FILTER DRAFT DI SIDEBAR ---
                                if (($item['status'] ?? 'published') !== 'published') continue;

                                // Batasi jumlah tampil di sidebar (opsional, misal max 5)
                                if ($countShown >= 5) break;
                                $countShown++;
                            ?>
                        <a href="<?= url('/activity/' . $item['id']) ?>"
                            class="group flex gap-4 items-start p-3 rounded-xl hover:bg-slate-50 transition-colors">
                            <div class="w-20 h-20 rounded-lg overflow-hidden shrink-0 border border-slate-200 relative">
                                <?php
                                        $relImg = !empty($item['image_cover']) ? $item['image_cover'] : 'https://placehold.co/150x150/e2e8f0/94a3b8?text=img';
                                        if (strpos($relImg, 'http') === false) $relImg = BASE_URL . $relImg;
                                        ?>
                                <img src="<?= e($relImg) ?>"
                                    class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="flex-1 min-w-0">
                                <span class="text-[10px] font-bold text-blue-600 uppercase block mb-1">
                                    <?= date('d M Y', strtotime($item['activity_date'])) ?>
                                </span>
                                <h4
                                    class="font-bold text-slate-800 text-sm leading-snug group-hover:text-blue-700 transition-colors line-clamp-2">
                                    <?= e($item['title']) ?>
                                </h4>
                            </div>
                        </a>
                        <?php endforeach; ?>

                        <?php if ($countShown == 0): ?>
                        <p class="text-sm text-slate-400 italic">Tidak ada kegiatan lain untuk ditampilkan.</p>
                        <?php endif; ?>

                        <?php else: ?>
                        <p class="text-sm text-slate-400 italic">Tidak ada kegiatan lain.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>

<?php include APP_PATH . '/views/layouts/footer.php'; ?>