<?php $title = e($activity['title']); ?>
<?php include APP_PATH . '/views/layouts/header.php'; ?>
<?php include APP_PATH . '/views/layouts/navbar.php'; ?>

<div class="bg-white min-h-screen pb-20">

    <div class="bg-slate-50 border-b border-slate-200">
        <div class="max-w-4xl mx-auto px-4 py-8">
            <a href="<?= url('/activities') ?>"
                class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-blue-600 mb-6 transition-colors">
                <i class="bi bi-arrow-left mr-2"></i> Kembali ke Daftar Kegiatan
            </a>

            <div class="flex items-center gap-3 mb-4">
                <span
                    class="bg-blue-100 text-blue-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                    <?= getActivityTypeLabel($activity['activity_type']) ?>
                </span>
                <span class="text-slate-400 text-sm font-medium flex items-center gap-1">
                    <i class="bi bi-calendar3"></i>
                    <?= date('d F Y', strtotime($activity['activity_date'])) ?>
                </span>
            </div>

            <h1 class="text-3xl md:text-5xl font-extrabold text-slate-900 leading-tight mb-4">
                <?= e($activity['title']) ?>
            </h1>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            <div class="lg:col-span-2">
                <div class="rounded-2xl overflow-hidden shadow-lg mb-8 border border-slate-100">
                    <img src="<?= !empty($activity['image_cover']) ? $activity['image_cover'] : 'https://placehold.co/800x500/e2e8f0/94a3b8?text=No+Image' ?>"
                        class="w-full h-auto object-cover max-h-[500px]" alt="<?= e($activity['title']) ?>">
                </div>

                <div class="prose prose-lg max-w-none text-slate-700 leading-relaxed">
                    <p class="whitespace-pre-line"><?= e($activity['description']) ?></p>
                </div>

                <?php if (!empty($activity['link_url']) && $activity['link_url'] != '#'): ?>
                    <div
                        class="mt-10 p-6 bg-slate-50 rounded-xl border border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <h4 class="font-bold text-slate-900 text-lg">Tautan Terkait</h4>
                            <p class="text-sm text-slate-500">Lihat informasi selengkapnya atau sumber asli berita ini.</p>
                        </div>
                        <a href="<?= e($activity['link_url']) ?>" target="_blank"
                            class="px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition-all shadow-md shadow-blue-500/30 flex items-center gap-2">
                            Kunjungi Tautan <i class="bi bi-box-arrow-up-right"></i>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="lg:col-span-1 space-y-8">

                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                    <h3 class="font-bold text-slate-800 mb-4 uppercase text-xs tracking-wider">Bagikan</h3>
                    <div class="flex gap-2">
                        <button
                            class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all"><i
                                class="bi bi-facebook"></i></button>
                        <button
                            class="w-10 h-10 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center hover:bg-sky-500 hover:text-white transition-all"><i
                                class="bi bi-twitter-x"></i></button>
                        <button
                            class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition-all"><i
                                class="bi bi-whatsapp"></i></button>
                        <button
                            class="w-10 h-10 rounded-full bg-slate-50 text-slate-600 flex items-center justify-center hover:bg-slate-600 hover:text-white transition-all"
                            onclick="navigator.clipboard.writeText(window.location.href); alert('Link disalin!')"><i
                                class="bi bi-link-45deg"></i></button>
                    </div>
                </div>

                <div>
                    <h3 class="font-bold text-slate-900 text-lg mb-6 flex items-center gap-2">
                        <i class="bi bi-newspaper text-blue-500"></i> Kegiatan Lainnya
                    </h3>

                    <div class="space-y-6">
                        <?php if (!empty($related)): ?>
                            <?php foreach ($related as $item): ?>
                                <a href="<?= url('/activity/' . $item['id']) ?>" class="group flex gap-4 items-start">
                                    <div class="w-24 h-24 rounded-lg overflow-hidden shrink-0 border border-slate-100">
                                        <img src="<?= !empty($item['image_cover']) ? $item['image_cover'] : 'https://placehold.co/150x150/e2e8f0/94a3b8?text=img' ?>"
                                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase block mb-1">
                                            <?= date('d M Y', strtotime($item['activity_date'])) ?>
                                        </span>
                                        <h4
                                            class="font-bold text-slate-800 text-sm leading-snug group-hover:text-blue-600 transition-colors line-clamp-3">
                                            <?= e($item['title']) ?>
                                        </h4>
                                    </div>
                                </a>
                            <?php endforeach; ?>
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